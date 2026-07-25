<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $categories = BlogCategory::where('profile_id', $profile->id)
            ->with('parent')
            ->withCount('blogPosts')
            ->orderBy('name')
            ->paginate(15);

        $parentCategories = BlogCategory::where('profile_id', $profile->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.blog-categories.index', compact('categories', 'parentCategories', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();
        $parentCategories = BlogCategory::where('profile_id', $profile->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.blog-categories.create', compact('profile', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['profile_id'] = $profile->id;

        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($blogCategory);
        $parentCategories = BlogCategory::where('profile_id', $profile->id)
            ->whereNull('parent_id')
            ->where('id', '!=', $blogCategory->id)
            ->orderBy('name')
            ->get();

        return view('admin.blog-categories.edit', compact('blogCategory', 'profile', 'parentCategories'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $this->authorizeOwnership($blogCategory);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $this->authorizeOwnership($blogCategory);
        BlogCategory::where('parent_id', $blogCategory->id)->update(['parent_id' => null]);

        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category deleted successfully.');
    }
}
