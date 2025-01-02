<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $banners = Banner::latest()->paginate(10); // Use paginate instead of get
        return view('admin.banners.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.banners.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4048', // 10 MB
            'is_homepage' => 'required|in:hero,discounted_section',
        ]);

        $data = $validated;
        $data['active'] = 1; // Automatically set active to 1
        $data['image'] = $request->file('image')->store('banners', 'public');

        Banner::create($data);

        return redirect()->route('banners.index')->with('success', 'Banner created and activated successfully.');
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|min:3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
        ]);

        $data = $request->only(['title', 'description']);

        // Assign active status
        $data['active'] = $request->has('active') ? 1 : 0;

        // Assign is_homepage based on request value
        if ($request->has('is_homepage')) {
            $data['is_homepage'] = $request->input('is_homepage'); // Use the value passed (e.g., 'hero' or 'discounted_section')
        } else {
            $data['is_homepage'] = 'none'; // Default to 'none' if not selected
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }
    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
    public function toggleStatus(Banner $banner)
    {
        $banner->update([
            'active' => !$banner->active, // Toggle the active status
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner status updated successfully.');
    }
}
