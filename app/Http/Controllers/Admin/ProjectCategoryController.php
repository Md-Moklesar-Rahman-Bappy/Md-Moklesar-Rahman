<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectCategoryController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $categories = ProjectCategory::where('profile_id', $profile->id)
            ->withCount('projects')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.project-categories.index', compact('categories', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();

        return view('admin.project-categories.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['profile_id'] = $profile->id;

        ProjectCategory::create($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category created successfully.');
    }

    public function edit(ProjectCategory $projectCategory)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($projectCategory);

        return view('admin.project-categories.edit', compact('projectCategory', 'profile'));
    }

    public function update(Request $request, ProjectCategory $projectCategory)
    {
        $this->authorizeOwnership($projectCategory);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $projectCategory->update($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category updated successfully.');
    }

    public function destroy(ProjectCategory $projectCategory)
    {
        $this->authorizeOwnership($projectCategory);
        $projectCategory->delete();

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category deleted successfully.');
    }
}
