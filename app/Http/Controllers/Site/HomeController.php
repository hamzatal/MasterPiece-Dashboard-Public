<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Banner; // Import the Banner model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        // Fetch products from the database (with pagination, if needed)
        $products = Product::with('category')->paginate(8); // Adjust pagination as required

        // Fetch active banners from the database
        $banners = Banner::where('active', 1)->get();

        // Pass the banners and products to the view
        return view('ecommerce.home', compact('products', 'wishlistCount', 'banners'));
    }
}
