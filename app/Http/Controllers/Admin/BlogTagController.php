<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $tags = BlogTag::where('profile_id', $profile->id)
            ->withCount('blogPosts')
            ->orderBy('name')
            ->paginate(30);

        if ($request->ajax()) {
            return response()->json($tags);
        }

        return view('admin.blog-tags.index', compact('tags', 'profile'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['profile_id'] = $profile->id;

        $tag = BlogTag::firstOrCreate(
            ['slug' => $validated['slug'], 'profile_id' => $profile->id],
            $validated
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'tag' => $tag]);
        }

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Blog tag created successfully.');
    }

    public function destroy(BlogTag $blogTag, Request $request)
    {
        $blogTag->blogPosts()->detach();
        $blogTag->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Blog tag deleted successfully.');
    }
}
