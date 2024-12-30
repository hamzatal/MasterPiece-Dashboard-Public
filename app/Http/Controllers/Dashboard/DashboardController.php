<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // Fetch key metrics
        $totalCustomers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');

        // Fetch recent orders
        $recentOrders = Order::with(['user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Fetch top-selling products
        $topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as total_revenue'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->with('product')
            ->take(5)
            ->get();

        // Fetch low stock products
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();

        // Fetch active coupons
        $activeCoupons = Coupon::where('expiry_date', '>=', now())
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get();

        // Fetch review statistics
        $averageRating = Review::avg('rating');
        $totalReviews = Review::count();

        // Get recent activities with pagination
        $recentActivities = Activity::with('user')
            ->latest()
            ->paginate(5); // Use paginate() instead of get()
        $statusColors = [
            'completed' => 'bg-green-100 text-green-800 dark:bg-green-600 dark:text-white',
            'pending' => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-500 dark:text-white',
            'processing' => 'bg-blue-200 text-blue-800 dark:bg-blue-500 dark:text-white',
            'shipped' => 'bg-purple-200 text-purple-800 dark:bg-purple-500 dark:text-white',
            'delivered' => 'bg-green-200 text-green-800 dark:bg-green-500 dark:text-white',
            'cancelled' => 'bg-red-200 text-red-800 dark:bg-red-600 dark:text-white',
        ];
        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'topSellingProducts',
            'lowStockProducts',
            'activeCoupons',
            'averageRating',
            'totalReviews',
            'recentActivities',
            'statusColors',
        ));
    }
}
