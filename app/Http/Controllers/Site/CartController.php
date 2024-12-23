<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Method to display the cart page
    public function index()
    {
        return view('ecommerce.cart');  // Display cart page
    }

    // Method to add product to cart
    public function add(Request $request)
    {
        $productId = $request->product_id;

        // Check if product exists in the database
        $product = Product::findOrFail($productId);

        // Retrieve current cart from session, if it exists
        $cart = session()->get('cart', []);

        // Add product to cart or increase quantity if it's already in the cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        // Save the updated cart in the session
        session()->put('cart', $cart);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product added to cart!');
    }
}
