<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('search'); // Get the search term
    $categories = Category::when($query, function ($queryBuilder) use ($query) {
        return $queryBuilder->where('name', 'like', '%' . $query . '%');
    })->paginate(5);  // Paginate with 12 items per page

    return view('admin.categories.index', compact('categories'));
}

    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Create the new category and store it in the database
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        // Redirect back with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
    public function create()
    {
        // Return the view for creating a category
        return view('admin.categories.create');
    }
    public function update(Request $request, Category $category)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Update the category with the new data
        $category->update($request->only('name', 'description'));

        // Redirect back to the categories index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function edit(Category $category)
    {
        // Return the view for editing the category, passing the category data
        return view('admin.categories.edit', compact('category'));
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
