<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the wishlist.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $productIds = $wishlistItems->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get();

        $products = Product::with('category')->paginate(5); // Adjust pagination as required

        //wishlistItems pagination
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->paginate(10); // Adjust pagination as required





        return view('ecommerce.wishlist', compact('wishlistItems', 'products'));
    }

    /**
     * Add a product to the wishlist.
     *
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($productId)
    {

        if (Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->exists()) {
            return redirect()->back()->with('info', 'Product is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }


    /**
     * Remove a product from the wishlist.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        $wishlistItem = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$wishlistItem) {
            return redirect()->back()->with('error', 'Product not found in your wishlist.');
        }

        $wishlistItem->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }

    /**
     * Clear the entire wishlist.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function clearAll()
    {
        try {
            // Delete all wishlist items for the authenticated user
            Wishlist::where('user_id', Auth::id())->delete();

            return redirect()->back()->with('success', 'All items have been removed from your wishlist.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear the wishlist.');
        }
    }
}
