<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillCategoryController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $categories = SkillCategory::where('profile_id', $profile->id)
            ->withCount('skills')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.skill-categories.index', compact('categories', 'profile'));
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

    public function update(Request $request, SkillCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category updated successfully.');
    }

    public function destroy(SkillCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.skill-categories.index')
            ->with('success', 'Skill category deleted successfully.');
    }
}
