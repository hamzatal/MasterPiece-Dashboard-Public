<?php

namespace App\Http\Controllers;

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
    { // Fetch key metrics$totalCustomers = User::count();$totalProducts = Product::count();$totalOrders = Order::count();$totalRevenue = Order::sum('total_price');
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
            'totalReviews'
        ));
    }
}
