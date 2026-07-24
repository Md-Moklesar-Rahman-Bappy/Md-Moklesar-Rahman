<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Project,
    BlogPost,
    Message,
    Skill,
    Experience,
    Education,
    Service,
    Testimonial,
    Certification,
    Visitor,
    Newsletter
};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;

        $stats = [
            'projects' => Project::where('profile_id', $profile?->id)->count(),
            'blog_posts' => BlogPost::where('profile_id', $profile?->id)->count(),
            'messages' => Message::where('profile_id', $profile?->id)->count(),
            'unread_messages' => Message::where('profile_id', $profile?->id)->where('is_read', false)->count(),
            'skills' => Skill::where('profile_id', $profile?->id)->count(),
            'experiences' => Experience::where('profile_id', $profile?->id)->count(),
            'services' => Service::where('profile_id', $profile?->id)->count(),
            'testimonials' => Testimonial::where('profile_id', $profile?->id)->count(),
            'certifications' => Certification::where('profile_id', $profile?->id)->count(),
            'newsletter_subscribers' => Newsletter::where('profile_id', $profile?->id)->where('is_active', true)->count(),
            'total_views' => Visitor::where('profile_id', $profile?->id)->count(),
            'recent_messages' => Message::where('profile_id', $profile?->id)->latest()->take(5)->get(),
            'recent_projects' => Project::where('profile_id', $profile?->id)->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'profile'));
    }
}
