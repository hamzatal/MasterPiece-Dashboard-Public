<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function search(Request $request)
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
                ->select('id', 'name', 'original_price', 'new_price', 'is_discount_active', 'image1 as image')
                ->get()
                ->map(function ($product) {
                    $price = $product->is_discount_active ? $product->new_price : $product->original_price;

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $price,
                        'image' => $product->image,
                        'is_discount_active' => $product->is_discount_active,
                        'original_price' => $product->original_price,
                        'new_price' => $product->new_price, 
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while searching'
            ], 500);
        }
    }
}
