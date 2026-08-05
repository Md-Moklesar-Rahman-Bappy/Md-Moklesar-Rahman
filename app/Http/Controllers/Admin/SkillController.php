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

        $skills = Skill::query()
            ->where('profile_id', $profile->id)
            ->with('category')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            })
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $categories = SkillCategory::where('profile_id', $profile->id)
            ->withCount('skills')
            ->withAvg('skills', 'percentage')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $stats = [
            'total' => Skill::where('profile_id', $profile->id)->count(),
            'active' => Skill::where('profile_id', $profile->id)->where('is_active', true)->count(),
            'categories' => $categories->count(),
            'avg' => round(Skill::where('profile_id', $profile->id)->avg('percentage') ?? 0),
        ];

        return view('admin.skills.index', compact('skills', 'profile', 'categories', 'stats'));
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
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
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
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
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
