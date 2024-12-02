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
     * Display a listing of orders with statistics
     */
    public function index(Request $request)
    {
        $query = Order::query()->with(['user', 'orderItems']);

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
     * Show order creation form
     */
    public function create()
    {
        return view('admin.orders.edit', ['order' => new Order()]);
    }
    public function filterOrders(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $dateFilter = $request->input('date');

        // Define the statuses array
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        $orders = Order::query()
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($dateFilter, function ($query) use ($dateFilter) {
                $date = now();
                switch ($dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', $date->toDateString());
                        break;
                    case 'this_week':
                        $query->whereBetween('created_at', [$date->startOfWeek(), $date->endOfWeek()]);
                        break;
                    case 'this_month':
                        $query->whereMonth('created_at', $date->month)
                            ->whereYear('created_at', $date->year);
                        break;
                    case 'last_month':
                        $query->whereMonth('created_at', $date->subMonth()->month)
                            ->whereYear('created_at', $date->year);
                        break;
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders', 'statuses')); // Passing statuses to the view
    }
    /**
     * Show specific order details
     */
    public function view($id)
    {
        $order = Order::with(['customer', 'orderItems'])->findOrFail($id);
        return view('admin.orders.view', compact('order'));
    }

    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateOrderData($request);

        try {
            DB::transaction(function () use ($validatedData) {
                $customer = User::firstOrCreate(
                    ['email' => $validatedData['customer_email']],
                    ['name' => $validatedData['customer_name']]
                );

                Order::create([
                    'customer_id' => $customer->id,
                    'status' => $validatedData['status'],
                    'total' => $validatedData['total'],
                    'payment_method' => $validatedData['payment_method'],
                    'notes' => $validatedData['notes']
                ]);
            });

            return redirect()
                ->route('orders.index')
                ->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Update existing order
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $this->validateOrderData($request);

        try {
            DB::transaction(function () use ($validatedData, $order) {
                $customer = User::updateOrCreate(
                    ['email' => $validatedData['customer_email']],
                    ['name' => $validatedData['customer_name']]
                );

                $order->update([
                    'customer_id' => $customer->id,
                    'status' => $validatedData['status'],
                    'total' => $validatedData['total'],
                    'payment_method' => $validatedData['payment_method'],
                    'notes' => $validatedData['notes']
                ]);
            });

            return redirect()
                ->route('orders.index')
                ->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF invoice for order
     */
    public function generateInvoice(Order $order)
    {
        $order->load('customer', 'orderItems');
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download("invoice_{$order->id}.pdf");
    }
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }
    /**
     * Export orders to Excel
     */
    public function exportOrders(Request $request)
    {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, Request $request)
    {
        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Date filter
        if ($request->filled('date')) {
            $query = $this->applyDateFilter($query, $request->input('date'));
        }

        return $query;
    }

    /**
     * Apply date filtering to query
     */
    private function applyDateFilter($query, $dateFilter)
    {
        $now = Carbon::now();

        switch ($dateFilter) {
            case 'today':
                return $query->whereDate('created_at', $now->toDateString());
            case 'this_week':
                return $query->whereBetween('created_at', [
                    $now->startOfWeek(),
                    $now->endOfWeek()
                ]);
            case 'this_month':
                return $query->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year);
            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                return $query->whereMonth('created_at', $lastMonth->month)
                    ->whereYear('created_at', $lastMonth->year);
            default:
                return $query;
        }
    }

    /**
     * Get order statistics
     */
    private function getOrderStatistics()
    {
        return [
            'totalOrders' => Order::count(),
            'completedOrders' => Order::where('status', 'delivered')->count(),
            'pendingOrders' => Order::whereIn('status', ['pending', 'processing'])->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get user statistics
     */
    private function getUserStatistics()
    {
        return [
            'totalUsers' => User::count(),
            'recentUsers' => User::orderBy('created_at', 'desc')->take(5)->get(),
            'topCustomers' => User::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->take(5)
                ->get()
        ];
    }

    /**
     * Validate order data
     */
    private function validateOrderData(Request $request)
    {
        return $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'status' => 'required|in:' . implode(',', self::ALLOWED_STATUSES),
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:' . implode(',', self::ALLOWED_PAYMENT_METHODS),
            'notes' => 'nullable|string|max:1000'
        ]);
    }
}
