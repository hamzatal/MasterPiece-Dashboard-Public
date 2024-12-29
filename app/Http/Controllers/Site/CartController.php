<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $cart = json_decode(request()->cookie('cart'), true) ?? [];
        $subtotal = $this->calculateSubtotal($cart);

        return view('ecommerce.cart', compact('cart', 'subtotal'));
    }
    public function addToCart(Request $request)
    {
        $product = [
            'id' => $request->product_id,
            'name' => $request->product_name,
            'price' => floatval($request->product_price),
            'image' => $request->product_image,
            'quantity' => 1
        ];

        $cart = json_decode($request->cookie('cart'), true) ?? [];

        if (isset($cart[$product['id']])) {
            $cart[$product['id']]['quantity']++;
        } else {
            $cart[$product['id']] = $product;
        }

        Cookie::queue('cart', json_encode($cart), 60 * 24 * 7); // 7 days

        return redirect()->back()->with('success', 'Product added to cart');
    }
    public function removeFromCart(Request $request)
    {
        $cart = json_decode($request->cookie('cart'), true) ?? [];

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
        }

        Cookie::queue('cart', json_encode($cart), 60 * 24 * 7);
        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function updateCart(Request $request)
    {
        $cart = json_decode($request->cookie('cart'), true) ?? [];
        $productId = $request->id;
        $quantity = max(1, intval($request->quantity));

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Cookie::queue('cart', json_encode($cart), 60 * 24 * 7);

            $itemTotal = number_format($cart[$productId]['price'] * $quantity, 2);
            $subtotal = $this->calculateSubtotal($cart);

            return response()->json([
                'itemTotal' => $itemTotal,
                'subtotal' => $subtotal,
            ]);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }

    public function clearCart()
    {
        Cookie::queue(Cookie::forget('cart'));
        return redirect()->back()->with('success', 'Cart cleared');
    }

    private function calculateSubtotal($cart)
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return number_format($subtotal, 2);
    }
}
