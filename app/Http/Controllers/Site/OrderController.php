<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use DB;

class OrderController extends Controller
{
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

        DB::transaction(function () use ($cartData, $user, $subtotal, $discount, $total) {
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
        });

        return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
    }
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('ecommerce.order-success', compact('order'));
    }
}
