<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $settings = Setting::where('profile_id', $profile->id)
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings', 'profile'));
    }

    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'settings'   => 'required|array',
            'settings.*.key'   => 'required|string|max:255',
            'settings.*.value' => 'nullable|string',
            'settings.*.type'  => 'nullable|string|in:text,textarea,image,boolean',
        ]);

        foreach ($validated['settings'] as $settingData) {
            $value = $settingData['value'] ?? null;
            $type = $settingData['type'] ?? 'text';

            if ($type === 'boolean') {
                $value = $value ? '1' : '0';
            }

            if ($type === 'image' && $request->hasFile("setting_files.{$settingData['key']}")) {
                $file = $request->file("setting_files.{$settingData['key']}");
                $path = $file->store('settings', 'public');
                $value = $path;
            }

            Setting::updateOrCreate(
                [
                    'profile_id' => $profile->id,
                    'key'        => $settingData['key'],
                ],
                [
                    'value' => $value,
                    'type'  => $type,
                    'group' => $settingData['group'] ?? 'general',
                ]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
