<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Analytics;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $days = (int) $request->get('days', 30);
        $startDate = Carbon::now()->subDays($days);

        $totalViews = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->count();

        $uniqueVisitors = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count('ip_address');

        $viewsPerDay = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topPages = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('path, COUNT(*) as views')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $topCountries = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('country')
            ->selectRaw('country, COUNT(*) as views')
            ->groupBy('country')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $browsers = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('browser')
            ->selectRaw('browser, COUNT(*) as views')
            ->groupBy('browser')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $devices = PageView::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('device_type')
            ->selectRaw('device_type, COUNT(*) as views')
            ->groupBy('device_type')
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
