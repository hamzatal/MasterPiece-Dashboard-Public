<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue checkout.');
        }

        $cartData = json_decode(request()->cookie('shopping_cart'), true) ?? ['items' => []];
        if (empty($cartData['items'])) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $products = [];
        $subtotal = 0;
        $discount = 0;
        $appliedCoupon = null;

        foreach ($cartData['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $price = $product->is_discount_active ? $product->new_price : $product->original_price;
                $itemTotal = $price * $item['quantity'];
                $subtotal += $itemTotal;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image1,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                    'color' => $item['color'] ?? null,
                    'size' => $item['size'] ?? null,
                ];
            }
        }

        if (!empty($cartData['coupon'])) {
            $coupon = Coupon::where('code', $cartData['coupon'])->where('is_active', true)->first();
            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
                $appliedCoupon = $coupon;
            }
        }

        $total = $subtotal - $discount;
        $user = auth()->user();
        $defaultAddress = ShippingAddress::where('user_id', $user->id)
            ->where('default_address', true)
            ->first();

        return view('ecommerce.checkout', compact(
            'products',
            'subtotal',
            'discount',
            'total',
            'appliedCoupon',
            'user',
            'defaultAddress'
        ));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'payment_method' => 'required|in:visa,paypal,cash',
                'address_type' => 'required|in:home,work',
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'subtotal' => 'required|numeric',
                'discount' => 'required|numeric',
                'total' => 'required|numeric',
            ]);

            $cartData = json_decode(request()->cookie('shopping_cart'), true);
            if (!$cartData || empty($cartData['items'])) {
                throw new \Exception('Your cart is empty.');
            }

            DB::beginTransaction();

            $subtotal = 0;
            $discount = 0;
            $orderItems = [];

            foreach ($cartData['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $price = $product->is_discount_active ? $product->new_price : $product->original_price;
                    $itemTotal = $price * $item['quantity'];
                    $subtotal += $itemTotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $price,
                        'color' => $item['color'] ?? null,
                        'size' => $item['size'] ?? null,
                    ];
                }
            }

            if (!empty($cartData['coupon'])) {
                $coupon = Coupon::where('code', $cartData['coupon'])->first();
                if ($coupon) {
                    $discount = ($subtotal * $coupon->discount_value) / 100;
                }
            }

            $total = $subtotal - $discount;

            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $validatedData['name'],
                'total' => $validatedData['total'],
                'payment_status' => 'pending',
                'price' => $validatedData['subtotal'],
                'status' => 'pending',
                'payment_method' => $validatedData['payment_method'],
                'amount' => 1,
                'total_price' => $validatedData['total'],
                'total_amount' => 1,
            ]);

            foreach ($orderItems as $orderItem) {
                OrderItem::create(array_merge($orderItem, ['order_id' => $order->id]));
            }

            ShippingAddress::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'address_type' => $validatedData['address_type'],
                'street_address' => $validatedData['street_address'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
                'default_address' => false,
            ]);

            DB::commit();

            Cookie::queue(Cookie::forget('shopping_cart'));

            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function confirmation($id)
    {
        $order = Cache::remember("order_{$id}", 600, function () use ($id) {
            return Order::with(['items.product', 'shippingAddress', 'coupon'])->findOrFail($id);
        });

        $subtotal = 0;
        foreach ($order->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $discount = 0;
        if ($order->coupon) {
            $discount = ($subtotal * $order->coupon->discount_value) / 100;
        }

        $total = $subtotal - $discount;

        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->total = $total;

        $orders = Order::where('user_id', auth()->id())->paginate(10);

        return view('ecommerce.order-confirmation', compact('order', 'orders'));
    }
}
