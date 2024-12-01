<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
    const ALLOWED_STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    const ALLOWED_PAYMENT_METHODS = ['credit_card', 'paypal', 'bank_transfer'];

    /**
     * Display a listing of orders with statistics.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Apply filters
        $query = $this->applyFilters($query, $request);

        // Get paginated orders
        $orders = $query->latest()->paginate(10);

        // Get statistics
        $statistics = $this->getOrderStatistics();

        // Get user statistics
        $userStatistics = $this->getUserStatistics();

        if ($request->ajax()) {
            return view('orders.partials.table-rows', compact('orders'));
        }

        return view('admin.orders.index', compact('orders', 'statistics', 'userStatistics'));
    }

    /**
     * Show order creation form.
     */
    public function create()
    {
        return view('admin.orders.edit', ['order' => new Order()]);
    }

    /**
     * Filter orders based on search, status, and date.
     */
    public function filterOrders(Request $request)
    {
        $orders = Order::query()
            ->when($request->search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date, function ($query, $dateFilter) {
                $this->applyDateFilter($query, $dateFilter);
            })
            ->latest()
            ->paginate(10);

        $statuses = self::ALLOWED_STATUSES;

        return view('orders.index', compact('orders', 'statuses'));
    }

    /**
     * Show specific order details.
     */
    public function view($id)
    {
        $order = Order::with(['user', 'orderItems'])->findOrFail($id);
        return view('admin.orders.view', compact('order'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateOrderData($request);

        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::firstOrCreate(
                    ['email' => $validatedData['user_email']],
                    ['name' => $validatedData['user_name']]
                );

                Order::create([
                    'user_id' => $user->id,
                    'status' => $validatedData['status'],
                    'total' => $validatedData['total'],
                    'payment_method' => $validatedData['payment_method'],
                    'notes' => $validatedData['notes']
                ]);
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Update existing order.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $this->validateOrderData($request);

        try {
            DB::transaction(function () use ($validatedData, $order) {
                $user = User::updateOrCreate(
                    ['email' => $validatedData['user_email']],
                    ['name' => $validatedData['user_name']]
                );

                $order->update([
                    'user_id' => $user->id,
                    'status' => $validatedData['status'],
                    'total' => $validatedData['total'],
                    'payment_method' => $validatedData['payment_method'],
                    'notes' => $validatedData['notes']
                ]);
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF invoice for order.
     */
    public function generateInvoice(Order $order)
    {
        $order->load(['user', 'orderItems']);
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download("invoice_{$order->id}.pdf");
    }

    /**
     * Export orders to Excel.
     */
    public function exportOrders(Request $request)
    {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }

    /**
     * Apply filters to query.
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'LIKE', "%{$request->search}%")
                    ->orWhereHas('user', function ($subQuery) use ($request) {
                        $subQuery->where('name', 'LIKE', "%{$request->search}%")
                            ->orWhere('email', 'LIKE', "%{$request->search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query = $this->applyDateFilter($query, $request->date);
        }

        return $query;
    }

    /**
     * Apply date filtering to query.
     */
    private function applyDateFilter($query, $dateFilter)
    {
        $now = Carbon::now();

        switch ($dateFilter) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year);
                break;
            case 'last_month':
                $lastMonth = $now->subMonth();
                $query->whereMonth('created_at', $lastMonth->month)
                    ->whereYear('created_at', $lastMonth->year);
                break;
        }
    }

    /**
     * Get order statistics.
     */
    private function getOrderStatistics()
    {
        return [
            'totalOrders' => Order::count(),
            'deliveredOrders' => Order::where('status', 'delivered')->count(),
            'pendingOrders' => Order::whereIn('status', ['pending', 'processing'])->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get user statistics.
     */
    private function getUserStatistics()
    {
        return [
            'totalUsers' => User::count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'topCustomers' => User::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->take(5)
                ->get()
        ];
    }

    /**
     * Validate order data.
     */
    private function validateOrderData(Request $request)
    {
        return $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'status' => 'required|in:' . implode(',', self::ALLOWED_STATUSES),
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:' . implode(',', self::ALLOWED_PAYMENT_METHODS),
            'notes' => 'nullable|string|max:1000',
        ]);
    }
}
