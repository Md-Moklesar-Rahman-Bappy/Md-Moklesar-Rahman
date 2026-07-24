<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogPost;
use App\Models\Certification;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Newsletter;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Visitor;

class DashboardController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $stats = [
            'projects' => Project::where('profile_id', $profile->id)->count(),
            'blog_posts' => BlogPost::where('profile_id', $profile->id)->count(),
            'messages' => Message::where('profile_id', $profile->id)->count(),
            'unread_messages' => Message::where('profile_id', $profile->id)->where('is_read', false)->count(),
            'skills' => Skill::where('profile_id', $profile->id)->count(),
            'experiences' => Experience::where('profile_id', $profile->id)->count(),
            'services' => Service::where('profile_id', $profile->id)->count(),
            'testimonials' => Testimonial::where('profile_id', $profile->id)->count(),
            'certifications' => Certification::where('profile_id', $profile->id)->count(),
            'newsletter_subscribers' => Newsletter::where('profile_id', $profile->id)->where('is_active', true)->count(),
            'total_views' => Visitor::where('profile_id', $profile->id)->count(),
            'recent_messages' => Message::where('profile_id', $profile->id)->latest()->take(5)->get(),
            'recent_projects' => Project::where('profile_id', $profile->id)->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'profile'));
    }
}
