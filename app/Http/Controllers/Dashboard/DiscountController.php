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
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        try {
            // Create the discount
            $discount = Product_discount::create([
                'product_id' => $validated['product_id'],
                'discount_percentage' => $validated['discount_percentage'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Update the product price and activate discount
            $product = $discount->product;
            $discountedPrice = $product->original_price * (1 - ($validated['discount_percentage'] / 100));
            $product->update([
                'new_price' => $discountedPrice,
                'is_discount_active' => true,
                'discount_percentage' => $validated['discount_percentage'],
            ]);

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
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        try {
            $discount->update([
                'product_id' => $validated['product_id'],
                'discount_percentage' => $validated['discount_percentage'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Update the product price and activate discount
            $product = $discount->product;
            $discountedPrice = $product->original_price * (1 - ($validated['discount_percentage'] / 100));
            $product->update([
                'new_price' => $discountedPrice,
                'is_discount_active' => true,
                'discount_percentage' => $validated['discount_percentage'],
            ]);

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

            // Revert to the original price, deactivate discount, and reset discount percentage
            if ($product->original_price) {
                $product->update([
                    'price' => $product->original_price,
                    'is_discount_active' => false,
                    'discount_percentage' => null,
                ]);
            }

            $discount->delete();

            return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete discount.');
        }
    }
    // Toggle discount status
    public function toggleStatus($id)
    {
        $discount = Product_discount::findOrFail($id);

        try {
            // Toggle the is_active status
            $discount->update([
                'is_active' => !$discount->is_active,
            ]);

            // Update the product price based on the new discount status
            $product = $discount->product;
            if ($discount->is_active) {
                $discountedPrice = $product->original_price * (1 - ($discount->discount_percentage / 100));
                $product->update([
                    'price' => $discountedPrice,
                    'is_discount_active' => true,
                ]);
            } else {
                $product->update([
                    'price' => $product->original_price,
                    'is_discount_active' => false,
                ]);
            }

            return redirect()->route('discounts.index')->with('success', 'Discount status toggled successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to toggle discount status: ' . $e->getMessage());
        }
    }
}
