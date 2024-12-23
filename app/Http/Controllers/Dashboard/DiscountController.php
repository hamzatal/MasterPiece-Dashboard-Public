<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product_discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // Display all discounts
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch discounts with their related products
        $discounts = Product_discount::query()
            ->with('product')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('admin.discounts.index', compact('discounts'));
    }

    // Show form to create a new discount
    public function create()
    {
        $products = Product::all(); // Fetch all products for dropdown
        return view('admin.discounts.create', compact('products'));
    }

    // Store a new discount
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'startdate' => 'required|date|before_or_equal:enddate',
            'enddate' => 'required|date|after_or_equal:startdate',
            'is_active' => 'boolean',
        ]);

        try {
            $discount = Product_discount::create($validated);

            // Update product price
            $product = $discount->product;
            $discountedPrice = $product->original_price * (1 - ($discount->percentage / 100));
            $product->update(['price' => $discountedPrice]);

            return redirect()->route('discounts.index')->with('success', 'Discount created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create discount.')->withInput();
        }
    }

    // Show form to edit a discount
    public function edit($id)
    {
        $discount = Product_discount::findOrFail($id);
        $products = Product::all(); // Fetch all products for dropdown
        return view('admin.discounts.edit', compact('discount', 'products'));
    }

    // Update an existing discount
    public function update(Request $request, $id)
    {
        $discount = Product_discount::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'startdate' => 'required|date|before_or_equal:enddate',
            'enddate' => 'required|date|after_or_equal:startdate',
            'is_active' => 'boolean',
        ]);

        try {
            $discount->update($validated);

            // Update product price
            $product = $discount->product;
            $discountedPrice = $product->original_price * (1 - ($discount->percentage / 100));
            $product->update(['price' => $discountedPrice]);

            return redirect()->route('discounts.index')->with('success', 'Discount updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update discount.')->withInput();
        }
    }

    // Delete a discount
    public function destroy($id)
    {
        $discount = Product_discount::findOrFail($id);

        try {
            $product = $discount->product;

            // Revert to the original price if necessary
            if ($product->original_price && $discount->is_active) {
                $product->update(['price' => $product->original_price]);
            }

            $discount->delete();

            return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete discount.');
        }
    }
}
