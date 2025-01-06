<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\Banner;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cartData = json_decode(request()->cookie('shopping_cart'), true) ?? ['items' => []];
        $cartCount = array_sum(array_column($cartData['items'], 'quantity'));

        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $discountedProducts = Product::where('is_discount_active', true)
            ->orderBy('discount_percentage', 'desc')
            ->paginate(15);

        $banners = Banner::where('active', 1)->get();

        $categories = Category::all();

        $coupon = Coupon::where('is_active', true)
            ->orderBy('discount_value', 'desc')
            ->first();

        return view('ecommerce.home', compact('products', 'discountedProducts', 'cartCount', 'banners', 'categories', 'coupon'));
    }
}
