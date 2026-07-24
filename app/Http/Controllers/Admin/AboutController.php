<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends AdminController
{
    public function edit()
    {
        $profile = $this->getProfile();

        $about = About::where('profile_id', $profile->id)->first();

        if (!$about) {
            $about = About::create([
                'profile_id' => $profile->id,
                'heading'    => 'About Me',
                'content'    => '',
            ]);
        }

        return view('admin.about.edit', compact('about', 'profile'));
    }

    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'heading'           => 'required|string|max:255',
            'content'           => 'required|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'counters'          => 'nullable|array',
            'counters.*.label'  => 'required|string|max:255',
            'counters.*.value'  => 'required|string|max:255',
            'counters.*.icon'   => 'nullable|string|max:255',
            'achievements'      => 'nullable|array',
            'achievements.*'    => 'required|string|max:500',
        ]);

        $validated['counters'] = $validated['counters'] ?? null;
        $validated['achievements'] = $validated['achievements'] ?? null;

        if ($request->hasFile('image')) {
            $about = About::where('profile_id', $profile->id)->first();
            if ($about && $about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('about', 'public');
        }

        About::updateOrCreate(
            ['profile_id' => $profile->id],
            $validated
        );

        return redirect()->route('admin.about.edit')
            ->with('success', 'About section updated successfully.');
    }
}
