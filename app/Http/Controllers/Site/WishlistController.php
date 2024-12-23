<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        // Fetch wishlist items for the logged-in user
        $wishlistItems = Wishlist::where('user_id', auth()->id())->with('product')->get();

        // Pass the wishlist items to the view
        return view('ecommerce.wishlist', compact('wishlistItems'));
    }
}
