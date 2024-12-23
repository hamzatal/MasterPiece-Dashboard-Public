<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Fetch user's orders with pagination
        $orders = Order::where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(5);

        // Fetch wishlist items with product details
        $wishlistItems = Wishlist::where('user_id', $user->id)
                               ->with('product')
                               ->get();

        // Fetch cart items with product details
        $cartItems = Cart::where('user_id', $user->id)
                        ->with('product')
                        ->get();

        // Calculate cart total
        $cartTotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.dashboard', compact(
            'user',
            'orders',
            'wishlistItems',
            'cartItems',
            'cartTotal'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->sav();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->delete();

        return back()->with('success', 'Item removed from wishlist.');
    }

    public function updateCartQuantity(Request $request, $cartId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        Cart::where('id', $cartId)
            ->where('user_id', auth()->id())
            ->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function removeFromCart($cartId)
    {
        Cart::where('id', $cartId)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
