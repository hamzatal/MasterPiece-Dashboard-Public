<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Ensure you import the Product model
use App\Models\Category; // Ensure you import the Product model

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(16);
        $categories = Category::all(); // Adjust pagination as required
        return view('ecommerce.shop', compact('products', 'categories'));
    }
}
