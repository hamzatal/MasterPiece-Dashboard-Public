<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Display all categories
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $search = $request->input('search');
        $status = $request->input('status');
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->paginate($request->input('per_page', 10));

        return view('admin.categories.index', compact('categories'));
    }

    // Toggle Category Status
    public function toggle(Category $category)
    {
        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($category) {
            // Toggle category status
            $category->status = $category->status == 'active' ? 'inactive' : 'active';
            $category->save();

            // If deactivating, hide all products in this category
            if ($category->status == 'inactive') {
                Product::where('category_id', $category->id)->update(['status' => 'inactive']);
            } else {
                // Optionally, you might want to reactivate products
                // This depends on your specific business logic
                Product::where('category_id', $category->id)->update(['status' => 'active']);
            }
        });

        return redirect()->route('categories.index')->with('success', 'Category status updated successfully!');
    }

    // Show form to create a category
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:50000',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Show form to edit a category
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Update a category in the database
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('image')) {
            // Delete the old image if it exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        } else {
            $imagePath = $category->image;
        }

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
