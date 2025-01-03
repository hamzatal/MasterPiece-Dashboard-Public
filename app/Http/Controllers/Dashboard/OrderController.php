<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Models\Product;

class OrderController extends Controller
{
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

    const ALLOWED_STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    const ALLOWED_PAYMENT_METHODS = ['visa', 'paypal', 'cash'];

    public function show($orderId)
    {
        $order = Order::with(['shipping_address', 'orderItems.product'])->findOrFail($orderId);
        // dd($order->shipping_address);

        return view('order.show', compact('order'));
    }


    public function create()
    {
        return view('admin.orders.edit', ['order' => new Order()]);
    }

    public function store(Request $request)
    {

        $validatedData = $this->validateOrderData($request);
        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::firstOrCreate(
                    ['email' => $validatedData['email']],
                    ['name' => $validatedData['name']]
                );

                Order::create([
                    'user_id' => $user->id,
                    'status' => $validatedData['status'],
                    'total' => $validatedData['total'],
                    'payment' => $validatedData['payment'],
                    'payment_status' => $validatedData['payment_status'] ?? 'pending',
                    'notes' => $validatedData['notes'],
                    'shipping_address_id' => $validatedData['shipping_address_id'],

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

    public function update(Request $request, Order $order)
    {

        $validatedData = $this->validateOrderData($request);
        try {

            $order->status = $validatedData['status'];
            $order->total = $validatedData['total'];
            $order->payment = $validatedData['payment'];
            $order->payment_status = $validatedData['payment_status'];

            $order->save();
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

    public function view($id)
    {
        $order = Order::with(['user', 'orderItems'])->findOrFail($id);

        // dd($order);
        return view('admin.orders.view', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function generateInvoice(Order $order)
    {
        $order->load('user', 'orderItems');
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download("invoice_{$order->id}.pdf");
    }

    public function export(Request $request)
    {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }

    private function applyFilters($query, Request $request)
    {
        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
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

    private function getOrderStatistics()
    {
        return [
            'totalOrders' => Order::count(),
            'completedOrders' => Order::where('status', 'delivered')->count(),
            'pendingOrders' => Order::whereIn('status', ['pending', 'processing'])->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
        ];
    }

    private function getUserStatistics()
    {
        return [
            'totalUsers' => User::count(),
            'recentUsers' => User::orderBy('created_at', 'desc')->take(5)->get(),
            'topUsers' => User::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->take(5)
                ->get()
        ];
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Validate the incoming status
        $validatedData = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        // Update the order status
        $order->update([
            'status' => $validatedData['status']
        ]);

        // Optional: Add a flash message
        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    private function validateOrderData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'status' => 'required|in:' . implode(',', self::ALLOWED_STATUSES),
            'total' => 'required|numeric|min:0',
            'payment' => 'required|in:' . implode(',', self::ALLOWED_PAYMENT_METHODS),
            'payment_status' => 'nullable|in:paid,pending,failed',
            'email' => 'required|email|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);
    }
}
