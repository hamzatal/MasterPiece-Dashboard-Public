<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $sort = $request->get('sort', 'latest');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $category = $request->get('category');
        $search = $request->get('search');

        // Base query
        $query = Product::query();

        // Apply filters
        if ($minPrice && $maxPrice) {
            $query->whereBetween('new_price', [$minPrice, $maxPrice]);
        }

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('id', $category);
            });
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Apply sorting
        switch ($sort) {
            case 'popularity':
                $query->orderBy('views', 'desc');
                break;
            case 'price_low':
                $query->orderBy('new_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('new_price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
        }

        // Get paginated results
        $products = $query->paginate(12);

        // Get categories for sidebar
        $categories = Category::paginate(10);

        return view('ecommerce.shop', compact('products', 'categories'));
    }

    public function addToWishlist($productId)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return redirect()->route('login');
            }

            $user->wishlist()->attach($productId);
            return back()->with('success', 'Product added to wishlist');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product to wishlist');
        }
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->new_price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function shop()
    {
        $categories = Category::paginate(5);
        $products = Product::paginate(10);
        return view('shop', compact('categories', 'products'));
    }

    public function searchProducts(Request $request)
    {
        try {
            $query = $request->get('q');

            if (empty($query)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Search query is required'
                ], 400);
            }

            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->select('id', 'name', 'new_price as price', 'image1 as image')
                ->get();

            $categories = Category::where('name', 'like', "%{$query}%")
                ->select('id', 'name', 'image as image')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'products' => $products,
                    'categories' => $categories,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while searching'
            ], 500);
        }
    }
}
