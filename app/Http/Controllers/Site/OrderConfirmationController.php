<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class OrderConfirmationController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product', 'shippingAddress')->paginate(10);

        return view('ecommerce.order-confirmation', compact('orders'));
    }

    public function show($id)
    {
        $order = auth()->user()->orders()->with('items.product', 'shippingAddress')->findOrFail($id);

        return view('ecommerce.order-info', compact('order'));
    }
}
