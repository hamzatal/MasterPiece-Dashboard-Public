<?php


namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)  // Add the $request parameter
    {
        $query = Discount::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('code', 'like', "%{$search}%")
                  ->orWhere('discount_type', 'like', "%{$search}%");
        }

        // Filter by discount type
        if ($request->filled('type')) {
            $query->where('discount_type', $request->input('type'));
        }

        // Filter by minimum discount value
        if ($request->filled('min_value')) {
            $query->where('discount_value', '>=', $request->input('min_value'));
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->input('per_page', 5);
        $discounts = $query->paginate($perPage);

        // Preserve query parameters in pagination links
        $discounts->appends($request->all());

        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discounts|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_order_value' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        Discount::create($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }
    public function toggle(Discount $discount)
    {
        $discount->update(['is_active' => !$discount->is_active]);
        return back()->with('success', 'Discount status updated successfully.');
    }
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|max:255|unique:discounts,code,' . $discount->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_order_value' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        $discount->update($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }
}
