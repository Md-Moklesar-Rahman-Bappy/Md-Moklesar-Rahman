<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        return view('admin.blog.index', compact('posts', 'profile'));
    }

    public function create()
    {
        $profile = $this->getProfile();
        $categories = BlogCategory::where('profile_id', $profile->id)->orderBy('name')->get();
        $tags = BlogTag::where('profile_id', $profile->id)->orderBy('name')->get();

        return view('admin.blog.create', compact('profile', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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

    public function edit(BlogPost $blogPost)
    {
        $profile = $this->getProfile();
        $this->authorizeOwnership($blogPost);
        $categories = BlogCategory::where('profile_id', $profile->id)->orderBy('name')->get();
        $tags = BlogTag::where('profile_id', $profile->id)->orderBy('name')->get();
        $post = $blogPost;

        return view('admin.blog.edit', compact('post', 'profile', 'categories', 'tags'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $this->authorizeOwnership($blogPost);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = $blogPost->published_at ?? now();
        }

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = $path;
        }

        if ($request->hasFile('og_image')) {
            if ($blogPost->og_image) {
                Storage::disk('public')->delete($blogPost->og_image);
            }
            $path = $request->file('og_image')->store('blog/og', 'public');
            $validated['og_image'] = $path;
        }

        $blogPost->update($validated);
        $blogPost->tags()->sync($tags);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $this->authorizeOwnership($blogPost);
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }
        if ($blogPost->og_image) {
            Storage::disk('public')->delete($blogPost->og_image);
        }

        $blogPost->tags()->detach();
        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
