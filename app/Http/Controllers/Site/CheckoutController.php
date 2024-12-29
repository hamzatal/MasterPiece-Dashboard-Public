<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get cart items
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        // Get user's shipping addresses
        $shippingAddresses = ShippingAddress::where('user_id', Auth::id())->get();

        // Calculate totals
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->new_price);
        $discount = session('coupon_discount', 0);
        $total = max($subtotal - $discount, 0);

        return view('ecommerce.checkout', compact(
            'cartItems',
            'shippingAddresses',
            'subtotal',
            'discount',
            'total'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'payment' => 'required|in:paypal,visa,cash',
            'address_id' => 'required_without:street_address',
            'street_address' => 'required_without:address_id|string|max:255',
            'city' => 'required_without:address_id|string|max:100',
            'state' => 'required_without:address_id|string|max:100',
            'zip_code' => 'required_without:address_id|string|max:20',
            'country' => 'required_without:address_id|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Handle shipping address
            if ($request->address_id === 'new') {
                // Create new shipping address
                $shippingAddress = ShippingAddress::create([
                    'user_id' => Auth::id(),
                    'street_address' => $request->street_address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                    'default_address' => $request->boolean('default_address'),
                    'address_type' => 'shipping',
                ]);

                // If this is set as default, update other addresses
                if ($request->boolean('default_address')) {
                    ShippingAddress::where('user_id', Auth::id())
                        ->where('id', '!=', $shippingAddress->id)
                        ->update(['default_address' => false]);
                }

                $addressId = $shippingAddress->id;
            } else {
                $addressId = $request->address_id;
            }

            // Fetch cart items and calculate totals
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->new_price);
            $discount = session('coupon_discount', 0);
            $total = max($subtotal - $discount, 0);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_address_id' => $addressId,
                'total_price' => $subtotal,
                'discount' => $discount,
                'total_amount' => $total,
                'payment_method' => $request->payment,
                'status' => 'pending',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->new_price,
                    'subtotal' => $item->quantity * $item->product->new_price,
                ]);

                // Update product stock (if you have stock management)
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            // Clear coupon session
            session()->forget(['coupon_discount', 'applied_coupon']);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect_url' => route('checkout.success', ['order' => $order->id])
                ]);
            }

            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to place order: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()]);
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['orderItems.product', 'shippingAddress'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('ecommerce.checkout-success', compact('order'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('is_active', true)
            ->where('expiry_date', '>', now())
            ->where(function ($query) {
                $query->where('usage_limit', '>', DB::raw('usage_count'))
                    ->orWhereNull('usage_limit');
            })
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code'
            ], 422);
        }

        // Calculate cart total
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 422);
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->new_price);

        // Calculate discount
        $discount = $coupon->discount_type === 'percentage'
            ? ($subtotal * $coupon->discount_value / 100)
            : $coupon->discount_value;

        // Apply maximum discount if set
        if ($coupon->max_discount_amount) {
            $discount = min($discount, $coupon->max_discount_amount);
        }

        $newTotal = max($subtotal - $discount, 0);

        // Update coupon usage
        $coupon->increment('usage_count');

        // Store in session
        session([
            'applied_coupon' => $coupon->id,
            'coupon_discount' => $discount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'data' => [
                'subtotal' => $subtotal,
                'discount' => $discount,
                'new_total' => $newTotal,
                'formatted_subtotal' => number_format($subtotal, 2),
                'formatted_discount' => number_format($discount, 2),
                'formatted_new_total' => number_format($newTotal, 2)
            ]
        ]);
    }
}
