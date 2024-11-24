<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // Display the list of coupons
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    // Show the form to create a new coupon
    public function create()
    {
        return view('admin.coupons.create');
    }

    // Store the newly created coupon
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'discount_type' => 'required|string|max:255',
            'discount_value' => 'required|numeric',
            'min_order_value' => 'nullable|numeric',
            'expiry_date' => 'nullable|date',
        ]);

        Coupon::create($validated);

        return redirect()->route('coupons.index')->with('success', 'Coupon added successfully!');
    }


    // Show the form to edit an existing coupon
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    // Update the coupon
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $id,
            'discount_type' => 'required|string|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date|after_or_equal:today',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => $request->input('code'),
            'discount_type' => $request->input('discount_type'),
            'discount_value' => $request->input('discount_value'),
            'min_order_value' => $request->input('min_order_value'),
            'expiry_date' => $request->input('expiry_date'),
            'updated_at' => now(),
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);

        return back()->with('success', 'Coupon status updated successfully');
    }
    // Delete the coupon
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully!');
    }
}
