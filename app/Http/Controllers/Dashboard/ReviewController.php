<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('status', 'approved')->orderBy('created_at', 'desc')->paginate(5);
        return response()->json($reviews);
    }

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

    public function edit($id)
    {
        $review = Review::findOrFail($id); // Fetch review by ID
        return view('admin.reviews.edit', compact('review'));
    }

    public function updateStatus(Review $review, Request $request)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,disapproved,active,inactive'],
        ]);

        $review->update([
            'status' => $validated['status']
        ]);

        return redirect()->back()->with('success', 'Review status updated successfully');
    }

    public function getStats()
    {
        return response()->json($this->getStatsData());
    }

    public function toggleActive($id)
    {
        $review = Review::findOrFail($id);
        $review->is_active = !$review->is_active;
        $review->save();

        $status = $review->is_active ? 'activated' : 'deactivated';

        if (request()->wantsJson()) {
            return response()->json([
                'message' => "Review $status successfully",
                'stats' => $this->getStatsData()
            ]);
        }

        return back()->with('success', "Review $status successfully.");
    }

    // Helper method to get statistics
    private function getStatsData()
    {
        return [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'disapproved' => Review::where('status', 'disapproved')->count(),
            'active' => Review::where('is_active', true)->count()
        ];
    }

    // Batch update multiple reviews
    public function batchUpdate(Request $request)
    {
        $request->validate([
            'reviews' => 'required|array',
            'reviews.*.id' => 'required|exists:reviews,id',
            'reviews.*.status' => 'required|in:pending,approved,disapproved'
        ]);

        foreach ($request->reviews as $reviewData) {
            Review::where('id', $reviewData['id'])
                ->update(['status' => $reviewData['status']]);
        }

        return response()->json([
            'message' => 'Reviews updated successfully',
            'stats' => $this->getStatsData()
        ]);
    }

    // Get all reviews
    public function getReviews()
    {
        $reviews = Review::where('status', 'approved')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['reviews' => $reviews]);
    }
}
