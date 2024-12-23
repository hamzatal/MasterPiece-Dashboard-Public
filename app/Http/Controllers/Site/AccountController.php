<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        // Ensure user is authenticated before accessing account details
        $wishlistItems = Wishlist::where('user_id', auth()->id())->with('product')->get();
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $orders = Order::where('user_id', auth()->id())->latest()->get(); // Retrieve user orders

        return view('ecommerce.profile', compact('wishlistItems', 'cartItems', 'orders'));
    }

    // Show the profile edit page
    public function edit()
    {
        $user = Auth::user(); // Ensure the user is authenticated and get the current user
        return view('ecommerce.edit-profile', compact('user')); // Pass the user to the view
    }

    // Update the profile information
    public function update(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        // Handle profile image upload
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete('public/' . $user->image); // Delete old image if exists
            }

            $path = $request->file('image')->store('profile_images', 'public'); // Store new image
            $user->image = 'profile_images/' . $path;
        }

        $user->save(); // Save the updated user data

        return redirect()->route('account.index')->with('status', 'Profile updated successfully!');
    }
}
