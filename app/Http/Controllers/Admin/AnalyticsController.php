<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Analytics;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $days = (int) $request->get('days', 30);
        $startDate = Carbon::now()->subDays($days);

        $totalViews = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->count();

        $uniqueVisitors = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count('ip_address');

        $viewsPerDay = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topPages = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('url, COUNT(*) as views')
            ->groupBy('url')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $topCountries = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')
            ->selectRaw('country, COUNT(*) as views')
            ->groupBy('country')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $browsers = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->selectRaw('browser, COUNT(*) as views')
            ->groupBy('browser')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $devices = Analytics::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('device')
            ->selectRaw('device, COUNT(*) as views')
            ->groupBy('device')
            ->orderByDesc('views')
            ->get();

        return view('admin.analytics.index', compact(
            'profile',
            'totalViews',
            'uniqueVisitors',
            'viewsPerDay',
            'topPages',
            'topCountries',
            'browsers',
            'devices',
            'days'
        ));
    }
}
