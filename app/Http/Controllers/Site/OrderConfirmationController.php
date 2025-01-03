<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderConfirmationController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->paginate(10);
        $orders = auth()->user()->orders()->with('items.product', 'shippingAddress')->paginate(10);
        return view('ecommerce.order-confirmation', ['orders' => $orders, 'isOrderList' => true]);
    }

    public function show($id)
    {
        $order = auth()->user()->orders()->with('items.product', 'shippingAddress')->findOrFail($id);
        return view('ecommerce.order-confirmation', ['order' => $order, 'isOrderList' => false]);
    }
}
