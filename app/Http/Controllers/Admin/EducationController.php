<?php

namespace App\Http\Controllers\Admin;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $educations = Education::where('profile_id', $profile->id)
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.educations.index', compact('educations', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();

        return view('admin.educations.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'group_or_field' => 'nullable|string|max:255',
            'result' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['profile_id'] = $profile->id;

        Education::create($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Education record created successfully.');
    }

    public function edit(Education $education)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($education);

        return view('admin.educations.edit', compact('education', 'profile'));
    }

    public function update(Request $request, Education $education)
    {
        $this->authorizeOwnership($education);
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'group_or_field' => 'nullable|string|max:255',
            'result' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $education->update($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Education record updated successfully.');
    }

    public function destroy(Education $education)
    {
        $this->authorizeOwnership($education);
        $education->delete();

        return redirect()->route('admin.educations.index')
            ->with('success', 'Education record deleted successfully.');
    }
}
