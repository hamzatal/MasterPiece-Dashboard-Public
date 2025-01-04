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
            'discount_percentage' => 'required|numeric|min:0|max:100', // Match table column
            'start_date' => 'required|date|before_or_equal:end_date', // Match table column
            'end_date' => 'required|date|after_or_equal:start_date', // Match table column
            'is_active' => 'boolean',
        ]);

        try {
            // Create the discount
            $discount = Product_discount::create([
                'product_id' => $validated['product_id'],
                'discount_percentage' => $validated['discount_percentage'], // Match table column
                'start_date' => $validated['start_date'], // Match table column
                'end_date' => $validated['end_date'], // Match table column
                'is_active' => $validated['is_active'] ?? false, // Default to false if not provided
            ]);

            // Update the product price
            $product = $discount->product;
            $discountedPrice = $product->original_price * (1 - ($discount->discount_percentage / 100)); // Match table column
            $product->update(['new_price' => $discountedPrice]);

            return redirect()->route('discounts.index')->with('success', 'Discount created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create discount: ' . $e->getMessage())->withInput();
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
            'discount_percentage' => 'required|numeric|min:0|max:100', // Match table column
            'start_date' => 'required|date|before_or_equal:end_date', // Match table column
            'end_date' => 'required|date|after_or_equal:start_date', // Match table column
            'is_active' => 'boolean',
        ]);

        try {
            $discount->update([
                'product_id' => $validated['product_id'],
                'discount_percentage' => $validated['discount_percentage'], // Match table column
                'start_date' => $validated['start_date'], // Match table column
                'end_date' => $validated['end_date'], // Match table column
                'is_active' => $validated['is_active'] ?? false, // Default to false if not provided
            ]);

            // Update the product price
            $product = $discount->product;
            $discountedPrice = $product->original_price * (1 - ($discount->discount_percentage / 100)); // Match table column
            $product->update(['price' => $discountedPrice]);

            return redirect()->route('discounts.index')->with('success', 'Discount updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update discount: ' . $e->getMessage())->withInput();
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
