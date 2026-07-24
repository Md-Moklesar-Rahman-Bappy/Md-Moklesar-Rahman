<?php

namespace App\Http\Controllers\Admin;

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
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|max:255',
            'settings.*.value' => 'nullable|string',
            'settings.*.type' => 'nullable|string|in:text,textarea,image,boolean',
            'settings.*.group' => 'nullable|string|max:255',
        ]);

        foreach ($validated['settings'] as $settingData) {
            $value = $settingData['value'] ?? null;
            $type = $settingData['type'] ?? 'text';
            $group = $settingData['group'] ?? 'general';

            if ($type === 'boolean') {
                $value = $value ? '1' : '0';
            }

            if ($type === 'image' && $request->hasFile("setting_files.{$settingData['key']}")) {
                $existing = Setting::where('profile_id', $profile->id)
                    ->where('key', $settingData['key'])
                    ->first();
                if ($existing && $existing->value) {
                    Storage::disk('public')->delete($existing->value);
                }
                $file = $request->file("setting_files.{$settingData['key']}");
                $path = $file->store('settings', 'public');
                $value = $path;
            }

            Setting::updateOrCreate(
                [
                    'profile_id' => $profile->id,
                    'key' => $settingData['key'],
                ],
                [
                    'value' => $value,
                    'type' => $type,
                    'group' => $group,
                ]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
