<?php

namespace App\Http\Controllers\Admin;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $experiences = Experience::where('profile_id', $profile->id)
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.experiences.index', compact('experiences', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();

        return view('admin.experiences.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:255',
        ]);

        $validated['profile_id'] = $profile->id;
        $validated['is_current'] = $request->boolean('is_current');

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience created successfully.');
    }

    public function edit(Experience $experience)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($experience);

        return view('admin.experiences.edit', compact('experience', 'profile'));
    }

    public function update(Request $request, Experience $experience)
    {
        $this->authorizeOwnership($experience);
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:255',
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        $this->authorizeOwnership($experience);
        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience deleted successfully.');
    }
}
