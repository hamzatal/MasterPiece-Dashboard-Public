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
        $order = Order::with(['items.product', 'shippingAddress'])->find($orderId);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        return view('ecommerce.order-info', compact('order'));
    }
}
