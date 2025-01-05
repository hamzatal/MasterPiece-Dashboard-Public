<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderInfoController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'shippingAddress'])->latest()->get();
        return view('ecommerce.order-info', compact('orders'));
    }

    public function show($orderId)
    {
        $order = Order::with(['items.product', 'shippingAddress', 'coupon'])->find($orderId);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        $subtotal = $order->total_price;

        $discount = 0;
        if ($order->coupon) {
            if ($order->coupon->discount_value && $order->coupon->discount_value > 0) {
                $discount = ($subtotal * $order->coupon->discount_value) / 100;
            }
        }

        $total = $subtotal - $discount;

        return view('ecommerce.order-info', compact('order', 'subtotal', 'discount', 'total'));
    }
}
