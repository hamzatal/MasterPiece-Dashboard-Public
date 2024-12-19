<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        $activities = Activity::with('user')
            ->recent()
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'activity_type' => $activity->activity_type,
                    'created_at' => $activity->created_at->toIso8601String(), // More standardized date format
                    'user_name' => $activity->user?->name ?? 'System' // Null coalescing operator
                ];
            });

        return response()->json($activities);
    }

    public static function log(array $data): Activity
    {
        return Activity::create([
            'user_id' => Auth::id(), // More Laravel-like way to get current user ID
            'activity_type' => $data['activity_type'] ?? 'generic',
            'description' => $data['description'],
            'type' => $data['type'] ?? null,
            'subject_type' => $data['subject_type'] ?? null,
            'subject_id' => $data['subject_id'] ?? null
        ]);
    }

    // Optional: Add method to get paginated activities
    public function getPaginatedActivities(Request $request)
    {
        $perPage = $request->input('per_page', 15);

        return Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

public function showNotifications()
{
    $recentActivities = Activity::with('user')
        ->recent() // Ensure you have defined this scope in the Activity model
        ->limit(10) // Show the last 10 activities
        ->get();

    return view('admin.navigation', compact('recentActivities'));
}
}
