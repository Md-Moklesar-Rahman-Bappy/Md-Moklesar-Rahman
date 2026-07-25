<?php

namespace App\Http\Controllers\Admin;

use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillCategoryController extends AdminController
{
    public function index()
    {
        return redirect()->route('admin.skills.index');
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['profile_id'] = $profile->id;

        SkillCategory::create($validated);

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category created successfully.');
    }

    public function update(Request $request, SkillCategory $skillCategory)
    {
        $this->authorizeOwnership($skillCategory);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $skillCategory->update($validated);

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category updated successfully.');
    }

    public function destroy(SkillCategory $skillCategory)
    {
        $this->authorizeOwnership($skillCategory);
        $skillCategory->delete();

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category deleted successfully.');
    }
}
