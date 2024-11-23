<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{

    /**
     * Display a listing of orders with statistics
     */
  public function index(Request $request)
{
    // Ensure that the $request variable is passed and used properly
    // Get order statistics
    $statistics = [
        'totalOrders' => Order::count(),
        'completedOrders' => Order::where('status', 'delivered')->count(),
        'pendingOrders' => Order::where('status', 'pending')->count(),
        'cancelledOrders' => Order::where('status', 'cancelled')->count(),
    ];

    // Get orders with customer (user) information
    $orders = Order::with('customer')
        ->when($request->input('status'), function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($request->input('date'), function ($query, $date) {
            return $this->applyDateFilter($query, $date);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    // Get user statistics
    $userStatistics = [
        'totalUsers' => User::count(),
        'recentUsers' => User::orderBy('created_at', 'desc')->take(5)->get(),
        'topCustomers' => User::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get()
    ];

    // Return the view with the required variables
    return view('admin.orders.index', compact('orders', 'statistics', 'userStatistics'));
}


    /**
     * Show order creation form
     */
    public function create()
    {
        $order = new Order();
        return view('admin.orders.edit', compact('order'));
    }
    public function view($id)
    {
        // Fetch the order by ID
        $order = Order::find($id);

        // If the order does not exist, return a 404 response
        if (!$order) {
            abort(404, 'Order not found');
        }

        // Return a view and pass the order data to it
        return view('admin.orders.view', compact('order'));
    }


    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            $customer = User::firstOrCreate(
                ['email' => $validatedData['customer_email']],
                ['name' => $validatedData['customer_name']]
            );

            $order = Order::create([
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
    }

    public function exportOrders(Request $request)
    {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }

    /**
     * Show specific order details
     */
    public function show(Order $order)
    {
        $orders = Order::with('customer', 'orderItems')
    ->when($request->input('status'), function ($query, $status) {
        return $query->where('status', $status);
    })
    ->when($request->input('date'), function ($query, $date) {
        return $this->applyDateFilter($query, $date);
    })
    ->orderBy('created_at', 'desc')
    ->paginate(5);

        return view('orders.view', compact('order'));
    }

    /**
     * Edit existing order
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update existing order
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'notes' => 'nullable|string|max:1000'
        ]);

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
    }

    /**
     * Update order status via AJAX
     */
    public function updateStatus(Order $order)
    {
        $newStatus = $this->getNextStatus($order->status);
        $order->update(['status' => $newStatus]);

        return response()->json([
            'status' => $newStatus,
            'message' => "Order status updated to {$newStatus}"
        ]);
    }

    /**
     * Search and filter orders
     */
    public function search(Request $request)
    {
        $query = Order::with('customer')
            ->when($request->input('search'), function ($q, $search) {
                return $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->when($request->input('status'), function ($q, $status) {
                return $q->where('status', $status);
            })
            ->when($request->input('date'), function ($q, $date) {
                return $this->applyDateFilter($q, $date);
            });

        $orders = $query->paginate(15);

        return response()->json([
            'table_rows' => view('orders.partials.table-rows', compact('orders'))->render()
        ]);
    }

    /**
     * Export orders to Excel
     */

    /**
     * Generate PDF invoice for order
     */
    public function generateInvoice(Order $order)
    {
        $order->load('customer', 'orderItems');
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download("invoice_{$order->id}.pdf");
    }

    /**
     * Apply date filtering to query
     */
    private function applyDateFilter($query, $dateFilter)
    {
        return match ($dateFilter) {
            'today' => $query->whereDate('created_at', today()),
            'this_week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'this_month' => $query->whereMonth('created_at', now()->month),
            'last_month' => $query->whereMonth('created_at', now()->subMonth()->month),
            default => $query
        };
    }

    /**
     * Determine next status in order lifecycle
     */
    private function getNextStatus($currentStatus)
    {
        $statusFlow = [
            'pending' => 'processing',
            'processing' => 'shipped',
            'shipped' => 'delivered',
            'delivered' => 'delivered',
            'cancelled' => 'cancelled'
        ];

        return $statusFlow[$currentStatus] ?? $currentStatus;
    }
}
