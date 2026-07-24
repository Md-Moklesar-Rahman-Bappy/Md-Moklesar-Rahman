<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $testimonials = Testimonial::where('profile_id', $profile->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.testimonials.index', compact('testimonials', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();

        return view('admin.testimonials.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'client_name'   => 'required|string|max:255',
            'company'       => 'nullable|string|max:255',
            'position'      => 'nullable|string|max:255',
            'review'        => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['profile_id'] = $profile->id;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('testimonials', 'public');
            $validated['profile_image'] = $path;
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        $profile = $this->getProfile();

        return view('admin.testimonials.edit', compact('testimonial', 'profile'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name'   => 'required|string|max:255',
            'company'       => 'nullable|string|max:255',
            'position'      => 'nullable|string|max:255',
            'review'        => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($testimonial->profile_image) {
                Storage::disk('public')->delete($testimonial->profile_image);
            }
            $path = $request->file('profile_image')->store('testimonials', 'public');
            $validated['profile_image'] = $path;
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->profile_image) {
            Storage::disk('public')->delete($testimonial->profile_image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}
