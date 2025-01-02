<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with(['items.product'])->latest()->get();

        return view('ecommerce.orders', compact('orders'));
    }

    public function show($orderId)
    {
        $order = auth()->user()->orders()->with(['items.product', 'shippingAddress'])->find($orderId);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        return view('ecommerce.product-details', compact('order'));
    }

    public function store(Request $request)
    {
        $cartData = json_decode(request()->cookie('shopping_cart'), true) ?? ['items' => [], 'coupon' => null];
        $user = auth()->user();

        if (empty($cartData['items'])) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        $discount = 0;

        foreach ($cartData['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }

        if (isset($cartData['coupon'])) {
            $coupon = Coupon::where('code', $cartData['coupon'])->first();
            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
            }
        }

        $total = $subtotal - $discount;

        $order = DB::transaction(function () use ($cartData, $user, $subtotal, $discount, $total) {
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartData['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                    ]);
                }
            }

            return $order;
        });

        // Clear cart cookie
        cookie()->queue(cookie()->forget('shopping_cart'));

        return redirect()->route('orders.success', $order->id)->with('success', 'Your order has been placed successfully!');
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('ecommerce.order-success', compact('order'));
    }
}
