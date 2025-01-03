<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category; // Import the Category model
use App\Models\Wishlist;
use App\Models\Banner; // Import the Banner model
use App\Models\Coupon; // Import the Coupon model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cartData = json_decode(request()->cookie('shopping_cart'), true) ?? ['items' => []];
        $cartCount = array_sum(array_column($cartData['items'], 'quantity'));

        $products = Product::with('category')->paginate(8);

        $banners = Banner::where('active', 1)->get();

        $categories = Category::all();

        $coupon = Coupon::where('is_active', true)
            ->orderBy('discount_value', 'desc')
            ->first();

        return view('ecommerce.home', compact('products', 'cartCount', 'banners', 'categories', 'coupon'));
    }
}
