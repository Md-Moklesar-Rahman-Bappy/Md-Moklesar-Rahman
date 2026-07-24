<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['profile_id'] = $profile->id;

        ProjectCategory::create($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category created successfully.');
    }

    public function edit(ProjectCategory $category)
    {
        $profile = $this->getProfile();

        return view('admin.project-categories.edit', compact('category', 'profile'));
    }

    public function update(Request $request, ProjectCategory $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category updated successfully.');
    }

    public function destroy(ProjectCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category deleted successfully.');
    }
}
