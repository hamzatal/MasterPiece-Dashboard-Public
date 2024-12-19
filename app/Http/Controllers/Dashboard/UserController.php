<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $currentUserRole = auth()->user()->role;

        $search = $request->input('search');

        if ($currentUserRole === 'super_admin') {
            // Super admin can see all users
            $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->paginate(5);
        } elseif ($currentUserRole === 'admin') {
            // Admin can only see regular users
            $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->where('role', 'user')
                ->paginate(5);
        } else {
            // Other roles (if any) see only their own user type
            $users = User::where('role', $currentUserRole)
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->paginate(5);
        }

        return view('admin.users.index', compact('users'));
    }


    public function view(User $user)
    {
        return view('admin.users.view
        ', compact('user'));
    }
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a newly created user
    public function store(Request $request)
    {
        $currentUserRole = auth()->user()->role;

        // If the current user is an admin, restrict role creation to only user
        if ($currentUserRole !== 'super_admin') {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:255',
                'role' => 'required|in:user', // Only allow creating user role
                'image' => 'nullable|image|max:2048',
            ]);
        } else {
            // Super admin can create any role
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:255',
                'role' => 'required|in:user,admin,super_admin',
                'image' => 'nullable|image|max:2048',
            ]);
        }

        $imagePath = $request->file('image') ? $request->file('image')->store('users', 'public') : null;
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' => $validatedData['phone'],
            'role' => $validatedData['role'],
            'image' => $imagePath,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update the user information
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin,super_admin',
            'image' => 'nullable|image|max:2048',

        ]);
        $imagePath = $request->file('image') ? $request->file('image')->store('users', 'public') : null;

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'image' => $imagePath,

        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'profile_images/' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $imagePath);

            // Save the image path to the database
            $user->image = $imagePath;
            $user->save();
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // Toggle the user active status
    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('users.index')->with('success', "User {$status} successfully.");
    }
}
