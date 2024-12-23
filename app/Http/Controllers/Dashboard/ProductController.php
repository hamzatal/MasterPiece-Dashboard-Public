<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'is_on_sale' => 'nullable|boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ], [
            'price.required' => 'The price field is required.',
            'stock_quantity.min' => 'The stock quantity must be at least 0.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ]);

        try {
            $newPrice = $validated['price'];
            $is_active = 0;

            if (isset($validated['discount_percentage'])) {
                $newPrice = $validated['price'] * (1 - $validated['discount_percentage'] / 100);
                $is_active = 1;
            }

            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'original_price' => $validated['price'],
                'new_price' => $newPrice,
                'stock_quantity' => $validated['stock_quantity'] ?? 0,
                'category_id' => $validated['category_id'],
                'discount_percentage' => $validated['discount_percentage'],
                'is_discount_active' => $is_active,
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $data['image'] = $imagePath;
            }

            $product = Product::create($data);

            if ($validated['discount_percentage'] != null) {
                $product_discount = Product_discount::create([
                    'product_id' => $product->id,
                    'discount_percentage' => $validated['discount_percentage'],
                    'start_date' => now(),
                    'is_active' => 1
                ]);
            }

            return redirect()->route('products.index')
                ->with('success', "Product '{$product->name}' added successfully!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add product. Please try again.')
                ->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'is_on_sale' => 'nullable|boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ], [
            'price.required' => 'The price field is required.',
            'stock_quantity.min' => 'The stock quantity must be at least 0.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ]);

        try {
            $newPrice = $validated['price'];
            $is_active = 0;

            if (isset($validated['discount_percentage'])) {
                $newPrice = $validated['price'] * (1 - $validated['discount_percentage'] / 100);
                $is_active = 1;
            }

            $data = $validated;
            $data['new_price'] = $newPrice;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $imagePath = $request->file('image')->store('products', 'public');
                $data['image'] = $imagePath;
            }

            $product->update($data);

            return redirect()->route('products.index')
                ->with('success', "Product '{$product->name}' updated successfully.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update product. Please try again.')
                ->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Delete associated image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $productName = $product->name;
            $product->delete();

            return redirect()->route('products.index')
                ->with('success', "Product '{$productName}' deleted successfully.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Additional method to handle low stock alerts
    public function checkLowStock()
    {
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->get();

        return view('admin.products.low-stock', compact('lowStockProducts'));
    }
}
