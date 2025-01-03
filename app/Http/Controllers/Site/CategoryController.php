<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        $categories = Category::withCount('products')->get();
        return view('ecommerce.categories.index', compact('categories'));
    }
}
