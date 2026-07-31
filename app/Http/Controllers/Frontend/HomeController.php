<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Message;
use App\Models\Newsletter;
use App\Models\Profile;
use App\Models\Project;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected ThemeManager $theme) {}

    public function index()
    {
        $profile = Profile::with([
            'socialLinks' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order');
            },
            'skills.category', 'experiences', 'educations',
            'projects.category', 'services', 'testimonials' => function ($q) {
                $q->where('is_active', true);
            },
            'certifications' => function ($q) {
                $q->where('is_active', true);
            },
            'blogPosts' => function ($q) {
                $q->where('status', 'published')->latest('published_at')->take(6);
            },
            'blogPosts.category', 'blogPosts.tags',
        ])->first();

        if (! $profile) {
            return view('themes.empty');
        }

        $this->theme->setProfile($profile);

        $sections = $this->theme->getSections();
        $customization = $this->theme->getCustomization();
        $activeTheme = $this->theme->getActiveTheme();

        $data = compact('profile', 'sections', 'customization', 'activeTheme');
        $data['cssVariables'] = $this->theme->getCssVariables();

        return view('frontend.home', $data);
    }

    public function showProject($slug)
    {
        $profile = Profile::first();
        $project = Project::with(['category', 'projectImages'])
            ->where('slug', $slug)
            ->firstOrFail();

        $project->increment('views_count');

        $relatedProjects = Project::where('profile_id', $profile?->id)
            ->where('id', '!=', $project->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        $activeTheme = $this->theme->getActiveTheme();

        return view('frontend.project-detail', compact('project', 'profile', 'relatedProjects', 'activeTheme'));
    }

    public function blog()
    {
        $profile = Profile::first();
        $posts = BlogPost::with(['category', 'tags'])
            ->where('profile_id', $profile?->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        $activeTheme = $this->theme->getActiveTheme();

        return view('frontend.blog-index', compact('posts', 'profile', 'activeTheme'));
    }

    public function showBlogPost($slug)
    {
        $profile = Profile::first();
        $post = BlogPost::with(['category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views_count');

        $relatedPosts = BlogPost::where('profile_id', $profile?->id)
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $activeTheme = $this->theme->getActiveTheme();

        return view('frontend.blog-detail', compact('post', 'profile', 'relatedPosts', 'activeTheme'));
    }

    public function contact()
    {
        $profile = Profile::with('socialLinks')->first();

        $activeTheme = $this->theme->getActiveTheme();

        return view('frontend.contact', compact('profile', 'activeTheme'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $profile = Profile::first();

        if ($profile) {
            Message::create([
                'profile_id' => $profile->id,
                ...$validated,
            ]);
        }

        return redirect()->route('home.contact')->with('success', 'Message sent successfully!');
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $profile = Profile::first();

        if ($profile) {
            Newsletter::updateOrCreate(
                ['email' => $validated['email'], 'profile_id' => $profile->id],
                ['subscribed_at' => now(), 'is_active' => true]
            );
        }

        return back()->with('success', 'Successfully subscribed to newsletter!');
    }
}
