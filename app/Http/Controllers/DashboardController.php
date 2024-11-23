<?php
// App/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Revenue;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get monthly data for the past 12 months
        $months = collect(range(11, 0, -1))->map(function ($month) {
            return Carbon::now()->subMonths($month)->format('M');
        });

        // Get user statistics
        $totalUsers = User::count();
        $lastMonthUsers = User::where('created_at', '<', Carbon::now()->subMonth())->count();
        $userGrowth = $lastMonthUsers ? (($totalUsers - $lastMonthUsers) / $lastMonthUsers * 100) : 0;

        $userStats = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))  // Group by numeric month
            ->orderBy(DB::raw('MONTH(created_at)'))  // Order by numeric month
            ->pluck('count', 'month')
            ->toArray();



        // Get revenue statistics
        $monthlyRevenue = Revenue::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))  // Group by the numeric month
            ->orderBy(DB::raw('MONTH(created_at)'))  // Order by numeric month
            ->pluck('total', 'month')
            ->toArray();


        $currentMonthRevenue = $monthlyRevenue[Carbon::now()->format('M')] ?? 0;
        $lastMonthRevenue = $monthlyRevenue[Carbon::now()->subMonth()->format('M')] ?? 0;
        $revenueGrowth = $lastMonthRevenue ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100) : 0;

        // Get project statistics
        $activeProjects = Project::where('status', 'active')->count();
        $lastMonthProjects = Project::where('status', 'active')
            ->where('created_at', '<', Carbon::now()->subMonth())
            ->count();
        $projectGrowth = $lastMonthProjects ? (($activeProjects - $lastMonthProjects) / $lastMonthProjects * 100) : 0;

        // Get task statistics
        $pendingTasks = Task::where('status', 'pending')->count();
        $yesterdayTasks = Task::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->count();
        $taskDifference = $pendingTasks - $yesterdayTasks;

        // Get recent activities
        $recentActivities = Activity::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'months',
            'totalUsers',
            'userGrowth',
            'userStats',
            'currentMonthRevenue',
            'revenueGrowth',
            'monthlyRevenue',
            'activeProjects',
            'projectGrowth',
            'pendingTasks',
            'taskDifference',
            'recentActivities'
        ));
    }
}
