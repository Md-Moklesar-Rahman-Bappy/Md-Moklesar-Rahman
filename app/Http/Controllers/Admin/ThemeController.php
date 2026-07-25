<?php

namespace App\Http\Controllers\Admin;

use App\Models\Theme;
use App\Models\ThemeCustomization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $themes = Theme::orderBy('name')->get();

        return view('admin.themes.index', compact('themes', 'profile'));
    }

    public function activate(Theme $theme)
    {
        $profile = $this->getProfile();

        $theme->update(['is_active' => true]);

        return redirect()->route('admin.themes.index')
            ->with('success', "Theme \"{$theme->name}\" activated successfully.");
    }

    public function customize(Theme $theme)
    {
        $profile = $this->getProfile();

        $customization = ThemeCustomization::where('theme_id', $theme->id)
            ->where('profile_id', $profile->id)
            ->first();

        return view('admin.themes.customize', compact('theme', 'customization', 'profile'));
    }

    public function updateCustomization(Request $request, Theme $theme)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'background_color' => 'nullable|string|max:7',
            'heading_font' => 'nullable|string|max:255',
            'body_font' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
            'header_layout' => 'nullable|string|max:255',
            'footer_layout' => 'nullable|string|max:255',
        ]);

        $existing = ThemeCustomization::where('theme_id', $theme->id)
            ->where('profile_id', $profile->id)
            ->first();

        if ($request->hasFile('logo')) {
            if ($existing && $existing->logo) {
                Storage::disk('public')->delete($existing->logo);
            }
            $validated['logo'] = $request->file('logo')->store('themes/logos', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($existing && $existing->favicon) {
                Storage::disk('public')->delete($existing->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('themes/favicons', 'public');
        }

        ThemeCustomization::updateOrCreate(
            [
                'theme_id' => $theme->id,
                'profile_id' => $profile->id,
            ],
            $validated
        );

        return redirect()->route('admin.themes.customize', $theme)
            ->with('success', 'Theme customization saved successfully.');
    }
}
