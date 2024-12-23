<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product; // Ensure you import the Product model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch products from the database (with pagination, if needed)
        $products = Product::with('category')->paginate(8); // Adjust pagination as required
        // dd($products);
        // Pass the products to the view
        return view('ecommerce.home', compact('products'));
    }

}
