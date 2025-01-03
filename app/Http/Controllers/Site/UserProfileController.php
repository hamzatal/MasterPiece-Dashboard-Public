<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('ecommerce.user-profile', compact('user'));
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = auth()->user();
        $user->update($validatedData);

        return redirect()->route('user-profile')->with('success', 'Profile updated successfully!');
    }
}
