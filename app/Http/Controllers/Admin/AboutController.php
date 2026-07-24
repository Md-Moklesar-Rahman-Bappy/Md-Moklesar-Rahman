<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = About::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'heading' => 'About Me',
                'content' => '',
                'counters' => json_encode([]),
                'achievements' => '',
            ]
        );

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'counters' => 'nullable|string',
            'achievements' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $about = About::firstOrCreate(
            ['user_id' => auth()->id()]
        );

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('about', 'public');
        }

        $about->update($validated);

        return redirect()->route('admin.about.edit')->with('success', 'About section updated.');
    }
}
