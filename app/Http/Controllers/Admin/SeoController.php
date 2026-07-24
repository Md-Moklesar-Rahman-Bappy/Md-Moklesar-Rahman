<?php

namespace App\Http\Controllers\Admin;

use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $seo = SeoSetting::where('profile_id', $profile->id)->first();

        return view('admin.seo.index', compact('seo', 'profile'));
    }

    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'robots_meta' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'schema_markup' => 'nullable|string',
        ]);

        if ($request->hasFile('og_image')) {
            $existing = SeoSetting::where('profile_id', $profile->id)->first();
            if ($existing && $existing->og_image) {
                Storage::disk('public')->delete($existing->og_image);
            }
            $path = $request->file('og_image')->store('seo', 'public');
            $validated['og_image'] = $path;
        }

        if ($request->hasFile('twitter_image')) {
            $existing = SeoSetting::where('profile_id', $profile->id)->first();
            if ($existing && $existing->twitter_image) {
                Storage::disk('public')->delete($existing->twitter_image);
            }
            $path = $request->file('twitter_image')->store('seo', 'public');
            $validated['twitter_image'] = $path;
        }

        SeoSetting::updateOrCreate(
            ['profile_id' => $profile->id],
            $validated
        );

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO settings updated successfully.');
    }
}
