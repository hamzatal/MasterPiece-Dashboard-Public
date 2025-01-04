<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_discount;
use App\Models\Review;
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
            'new_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image1' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'image2' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'image3' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'is_on_sale' => 'nullable|boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $data = $validated;

            // Handle image uploads
            if ($request->hasFile('image1')) {
                $data['image1'] = $request->file('image1')->store('products', 'public');
            }
            if ($request->hasFile('image2')) {
                $data['image2'] = $request->file('image2')->store('products', 'public');
            }
            if ($request->hasFile('image3')) {
                $data['image3'] = $request->file('image3')->store('products', 'public');
            }

            $product = Product::create($data);

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
            'new_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image1' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'image2' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'image3' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'is_on_sale' => 'nullable|boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $data = $validated;

            // Handle image uploads
            if ($request->hasFile('image1')) {
                if ($product->image1) {
                    Storage::disk('public')->delete($product->image1);
                }
                $data['image1'] = $request->file('image1')->store('products', 'public');
            }
            if ($request->hasFile('image2')) {
                if ($product->image2) {
                    Storage::disk('public')->delete($product->image2);
                }
                $data['image2'] = $request->file('image2')->store('products', 'public');
            }
            if ($request->hasFile('image3')) {
                if ($product->image3) {
                    Storage::disk('public')->delete($product->image3);
                }
                $data['image3'] = $request->file('image3')->store('products', 'public');
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
            if ($product->image1) {
                Storage::disk('public')->delete($product->image1);
            }
            if ($product->image2) {
                Storage::disk('public')->delete($product->image2);
            }
            if ($product->image3) {
                Storage::disk('public')->delete($product->image3);
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

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('ecommerce.product-details', compact('product'));
    }
    public function showinfo()
    {
        return view('admin.products.showinfo');
    }
    public function checkLowStock()
    {
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->get();

        return view('admin.products.low-stock', compact('lowStockProducts'));
    }
}
