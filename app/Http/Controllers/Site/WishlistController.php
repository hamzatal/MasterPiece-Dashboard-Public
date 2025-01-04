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
            ->paginate(10);

        $productIds = $wishlistItems->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get();

        $products = Product::with('category')->paginate(5);

        return view('ecommerce.wishlist', compact('wishlistItems', 'products'));
    }

    /**
     * Add a product to the wishlist.
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function add($productId)
    {
        try {
            if (Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->exists()) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Product is already in your wishlist.',
                ]);
            }

            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * Remove a product from the wishlist.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        try {
            $wishlistItem = Wishlist::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$wishlistItem) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found in your wishlist.',
                ], 404);
            }

            $wishlistItem->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from wishlist.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * Clear the entire wishlist.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAll()
    {
        try {
            Wishlist::where('user_id', Auth::id())->delete();

            return redirect()->back()->with('success', 'All items have been removed from your wishlist.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear the wishlist.');
        }
    }
}
