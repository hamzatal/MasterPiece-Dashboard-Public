<?php
namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
{
    $discounts = Discount::all();  // You can use pagination if you have many discounts: ->paginate(10)
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
        return view('discounts.edit', compact('discount'));
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

        return redirect()->route('admin.discounts.index')->with('success', 'Discount updated successfully.');
    }
}
