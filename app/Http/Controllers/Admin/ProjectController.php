<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $query = Project::where('profile_id', $profile->id)->with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            match ($request->status) {
                'active'    => $query->where('is_active', true),
                'inactive'  => $query->where('is_active', false),
                'featured'  => $query->where('is_featured', true),
                default     => null,
            };
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ProjectCategory::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'categories', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();
        $categories = ProjectCategory::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.projects.create', compact('profile', 'categories'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:project_categories,id',
            'description'      => 'nullable|string',
            'short_description'=> 'nullable|string|max:500',
            'technologies'     => 'nullable|array',
            'technologies.*'   => 'string|max:255',
            'features'         => 'nullable|array',
            'features.*'       => 'string|max:255',
            'github_url'       => 'nullable|url|max:255',
            'live_url'         => 'nullable|url|max:255',
            'client_name'      => 'nullable|string|max:255',
            'is_featured'      => 'boolean',
            'is_active'        => 'boolean',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['profile_id'] = $profile->id;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('projects/thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $profile = $this->getProfile();
        $categories = ProjectCategory::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.projects.edit', compact('project', 'profile', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:project_categories,id',
            'description'      => 'nullable|string',
            'short_description'=> 'nullable|string|max:500',
            'technologies'     => 'nullable|array',
            'technologies.*'   => 'string|max:255',
            'features'         => 'nullable|array',
            'features.*'       => 'string|max:255',
            'github_url'       => 'nullable|url|max:255',
            'live_url'         => 'nullable|url|max:255',
            'client_name'      => 'nullable|string|max:255',
            'is_featured'      => 'boolean',
            'is_active'        => 'boolean',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $path = $request->file('thumbnail')->store('projects/thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
