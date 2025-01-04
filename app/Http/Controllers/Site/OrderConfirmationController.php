<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderConfirmationController extends Controller
{
    /**
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product', 'coupon'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('ecommerce.order-confirmation', compact('orders'));
    }

    /**

     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = auth()->user()->orders()
            ->with(['items.product', 'shippingAddress'])
            ->findOrFail($id);

        return view('ecommerce.order-confirmation', [
            'order' => $order,
            'isOrderList' => false,
        ]);
    }
}
