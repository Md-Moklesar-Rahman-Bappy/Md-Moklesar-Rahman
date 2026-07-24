<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $query = BlogPost::where('profile_id', $profile->id)->with('category', 'tags');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.blog-posts.index', compact('posts', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();
        $categories = BlogCategory::where('profile_id', $profile->id)->orderBy('name')->get();
        $tags = BlogTag::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.blog-posts.create', compact('profile', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:blog_categories,id',
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:1000',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'published_at'     => 'nullable|date',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:blog_tags,id',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'og_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['profile_id'] = $profile->id;
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = $path;
        }

        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('blog/og', 'public');
            $validated['og_image'] = $path;
        }

        $post = BlogPost::create($validated);
        $post->tags()->sync($tags);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $post)
    {
        $profile = $this->getProfile();
        $categories = BlogCategory::where('profile_id', $profile->id)->orderBy('name')->get();
        $tags = BlogTag::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.blog-posts.edit', compact('post', 'profile', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:blog_categories,id',
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:1000',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'published_at'     => 'nullable|date',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:blog_tags,id',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'og_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = $post->published_at ?? now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = $path;
        }

        if ($request->hasFile('og_image')) {
            if ($post->og_image) {
                Storage::disk('public')->delete($post->og_image);
            }
            $path = $request->file('og_image')->store('blog/og', 'public');
            $validated['og_image'] = $path;
        }

        $post->update($validated);
        $post->tags()->sync($tags);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        if ($post->og_image) {
            Storage::disk('public')->delete($post->og_image);
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
