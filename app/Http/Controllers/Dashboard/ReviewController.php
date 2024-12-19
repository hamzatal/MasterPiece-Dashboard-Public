<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::paginate(5);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Review added successfully',
                'stats' => $this->getStatsData()
            ]);
        }

        return redirect()->route('reviews.index')->with('success', 'Review added successfully.');
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
}
