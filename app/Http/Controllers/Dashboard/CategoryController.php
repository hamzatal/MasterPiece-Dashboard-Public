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
    // Display all categories with optional search and status filters
    public function index(Request $request)
    {
        // Start building the query
        $query = Category::query();

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Paginate the results (default: 10 items per page)
        $perPage = $request->input('per_page', 10);
        $categories = $query->paginate($perPage);

        // Pass search and status parameters to the view
        $search = $request->input('search');
        $status = $request->input('status');

        return view('admin.categories.index', compact('categories', 'search', 'status'));
    }

    // Toggle the status of a category (active/inactive)
    public function toggle(Category $category)
    {
        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($category) {
            // Toggle the category status
            $category->status = $category->status == 'active' ? 'inactive' : 'active';
            $category->save();

            // If deactivating, hide all products in this category
            if ($category->status == 'inactive') {
                Product::where('category_id', $category->id)->update(['status' => 'inactive']);
            } else {
                // If activating, reactivate all products in this category
                Product::where('category_id', $category->id)->update(['status' => 'active']);
            }
        });

        return redirect()->route('categories.index')->with('success', 'Category status updated successfully!');
    }

    // Show the form to create a new category
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:50000',
        ]);

        // Store the uploaded image (if provided)
        $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        // Create the category
        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Show the form to edit an existing category
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Update an existing category in the database
    public function update(Request $request, Category $category)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload (if provided)
        if ($request->file('image')) {
            // Delete the old image if it exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('categories', 'public');
        } else {
            // Keep the existing image
            $imagePath = $category->image;
        }

        // Update the category
        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Delete a category from the database
    public function destroy(Category $category)
    {
        // Delete the category image if it exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Delete the category
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    // Show details of a specific category and its products
    public function show(Category $category)
    {
        // Retrieve products belonging to this category (paginated)
        $products = $category->products()->paginate(12);

        return view('ecommerce.categories', compact('category', 'products'));
    }
}
