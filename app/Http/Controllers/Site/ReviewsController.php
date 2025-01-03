<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $validated['status'] = 'pending'; // Default status
        $validated['is_active'] = true;

        Review::create($validated);

        return response()->json(['message' => 'Review added successfully']);
    }
    public function getReviews()
    {
        $reviews = Review::where('status', 'approved')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['reviews' => $reviews]);
    }
}
