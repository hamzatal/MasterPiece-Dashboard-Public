<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        // Get the current authenticated user
        $user = $request->user();

        // Pass the user image to the view
        return view('profile.edit', [
            'user' => $user,
            'image' => $user->image ? asset('storage/' . $user->image) : 'default-avatar.png', // Provide default image if none exists
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Get the current authenticated user
        $user = auth()->user();

        // Validate the input fields
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id], // Make sure the email is unique except for the current user
            'phone' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],  // Optional image upload validation
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image && Storage::disk('public')->exists($this->getImagePath($user->image))) {
                Storage::disk('public')->delete($this->getImagePath($user->image));
            }

            // Store the new image and update the path in the database
            $path = $request->file('image')->store('users', 'public');
            $validatedData['image'] = '/storage/' . $path; // Save the new image path
        } else {
            // If no image is uploaded, retain the existing image
            $validatedData['image'] = $user->image;
        }

        // Update the user's profile data
        $user->update($validatedData);

        // Redirect back to the profile page with a success message
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the current password for deletion
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Get the current user
        $user = $request->user();

        // Log the user out
        Auth::logout();

        // Delete the user's account
        $user->delete();

        // Invalidate and regenerate the session token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage with a success message
        return redirect('/')->with('status', 'Your account has been deleted successfully.');
    }

    /**
     * Helper function to get the image path.
     * Remove '/storage/' prefix if necessary.
     */
    private function getImagePath($image)
    {
        return str_replace('/storage/', '', $image);
    }
}
