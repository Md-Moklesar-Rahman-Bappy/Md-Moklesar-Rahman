<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends AdminController
{
    public function index()
    {
        return view('admin.profile.show', [
            'profile' => $this->getProfile(),
        ]);
    }

    public function edit()
    {
        return view('admin.profile.edit', [
            'profile' => $this->getProfile(),
        ]);
    }

    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:5000',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'location' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($profile->cover_image) {
                Storage::disk('public')->delete($profile->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('resume')) {
            if ($profile->resume_path) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        if (Str::slug($request->full_name) !== $profile->slug) {
            $slug = Str::slug($request->full_name);
            $count = Profile::where('slug', $slug)->where('id', '!=', $profile->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $validated['slug'] = $slug;
        }

        $profile->update($validated);

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy()
    {
        $profile = $this->getProfile();

        if ($profile->profile_image) {
            Storage::disk('public')->delete($profile->profile_image);
        }
        if ($profile->cover_image) {
            Storage::disk('public')->delete($profile->cover_image);
        }
        if ($profile->resume_path) {
            Storage::disk('public')->delete($profile->resume_path);
        }

        $profile->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Profile deleted successfully.');
    }
}
