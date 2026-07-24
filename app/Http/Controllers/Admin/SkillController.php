<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $skills = Skill::where('profile_id', $profile->id)
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.skills.index', compact('skills', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();
        $categories = SkillCategory::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.skills.create', compact('profile', 'categories'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'nullable|integer|min:0|max:100',
            'category_id' => 'nullable|exists:skill_categories,id',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $validated['profile_id'] = $profile->id;

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($skill);
        $categories = SkillCategory::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.skills.edit', compact('skill', 'profile', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $this->authorizeOwnership($skill);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'nullable|integer|min:0|max:100',
            'category_id' => 'nullable|exists:skill_categories,id',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $this->authorizeOwnership($skill);
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
}
