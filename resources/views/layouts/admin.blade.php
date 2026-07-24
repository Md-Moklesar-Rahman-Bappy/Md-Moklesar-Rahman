<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Dashboard') - Portfolio Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 72px;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #6366f1;
            --main-bg: #f1f5f9;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.18);
            --glass-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            --transition-speed: 0.3s;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--main-bg);
            min-height: 100vh;
            overflow-x: hidden;
        }
        .admin-sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-width); height: 100vh;
            background: var(--sidebar-bg); z-index: 1040;
            display: flex; flex-direction: column;
            transition: width var(--transition-speed) ease; overflow: hidden;
        }
        .admin-sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .sidebar-logo {
            padding: 1.25rem 1rem; display: flex; align-items: center;
            gap: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.07); min-height: 65px;
        }
        .sidebar-logo i { font-size: 1.6rem; color: var(--accent); flex-shrink: 0; }
        .sidebar-logo span {
            color: #fff; font-weight: 700; font-size: 1.05rem;
            white-space: nowrap; opacity: 1; transition: opacity var(--transition-speed);
        }
        .collapsed .sidebar-logo span { opacity: 0; pointer-events: none; }
        .sidebar-nav { flex: 1; overflow-y: auto; padding: 0.5rem 0; }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
        .sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 1rem; color: #94a3b8; text-decoration: none;
            font-size: 0.88rem; font-weight: 500; white-space: nowrap;
            transition: all 0.2s; border-left: 3px solid transparent; margin: 1px 0;
        }
        .sidebar-nav .nav-link i { font-size: 1.15rem; flex-shrink: 0; width: 22px; text-align: center; }
        .sidebar-nav .nav-link:hover {
            color: #fff; background: var(--sidebar-hover); border-left-color: var(--accent);
        }
        .sidebar-nav .nav-link.active {
            color: #fff; background: rgba(99,102,241,0.15); border-left-color: var(--accent);
        }
        .sidebar-nav .nav-link .nav-text {
            opacity: 1; transition: opacity var(--transition-speed);
        }
        .collapsed .sidebar-nav .nav-link .nav-text { opacity: 0; pointer-events: none; }
        .sidebar-nav .nav-link .badge { margin-left: auto; font-size: 0.7rem; }
        .collapsed .sidebar-nav .nav-link .badge { display: none; }
        .sidebar-section-title {
            padding: 0.75rem 1rem 0.3rem; font-size: 0.7rem;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: #475569; font-weight: 600; white-space: nowrap;
        }
        .collapsed .sidebar-section-title { opacity: 0; height: 0; padding: 0; overflow: hidden; }
        .sidebar-user {
            padding: 0.75rem 1rem; border-top: 1px solid rgba(255,255,255,0.07);
            display: flex; align-items: center; gap: 0.75rem;
        }
        .sidebar-user .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--accent); display: flex; align-items: center;
            justify-content: center; color: #fff; font-weight: 600;
            font-size: 0.85rem; flex-shrink: 0;
        }
        .sidebar-user .user-info { white-space: nowrap; }
        .sidebar-user .user-info .name { color: #fff; font-size: 0.85rem; font-weight: 600; }
        .sidebar-user .user-info .role { color: #64748b; font-size: 0.72rem; }
        .collapsed .sidebar-user .user-info { opacity: 0; pointer-events: none; }
        .admin-main {
            margin-left: var(--sidebar-width); min-height: 100vh;
            transition: margin-left var(--transition-speed) ease;
            display: flex; flex-direction: column;
        }
        .admin-main.sidebar-collapsed { margin-left: var(--sidebar-collapsed-width); }
        .admin-topbar {
            position: sticky; top: 0; z-index: 1030;
            background: var(--glass-bg); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0 1.5rem; height: 65px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
        .sidebar-toggle-btn {
            width: 38px; height: 38px; display: flex; align-items: center;
            justify-content: center; border: none; background: transparent;
            border-radius: 8px; color: #475569; cursor: pointer; transition: all 0.2s;
        }
        .sidebar-toggle-btn:hover { background: #e2e8f0; color: #1e293b; }
        .admin-content { flex: 1; padding: 1.5rem; }
        .glass-card {
            background: var(--glass-bg); backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border); border-radius: 16px;
            box-shadow: var(--glass-shadow);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .glass-card:hover {
            transform: translateY(-2px); box-shadow: 0 12px 40px rgba(31, 38, 135, 0.2);
        }
        .glass-card .card-body { padding: 1.5rem; }
        .stat-card { display: flex; align-items: center; gap: 1rem; }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; line-height: 1.2; }
        .stat-label { font-size: 0.82rem; color: #64748b; font-weight: 500; }
        .quick-action-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.55rem 1.1rem; border-radius: 10px; font-size: 0.85rem;
            font-weight: 600; text-decoration: none; transition: all 0.2s;
            border: none; cursor: pointer;
        }
        .table thead th {
            background: #f8fafc; border-bottom: 2px solid #e2e8f0;
            font-weight: 600; font-size: 0.82rem; text-transform: uppercase;
            letter-spacing: 0.04em; color: #475569;
        }
        .table td { vertical-align: middle; font-size: 0.9rem; }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 1035;
        }
        .admin-footer {
            padding: 1rem 1.5rem; text-align: center; font-size: 0.8rem;
            color: #94a3b8; border-top: 1px solid #e2e8f0;
        }
        .dark { --main-bg: #0f172a; --glass-bg: rgba(30, 41, 59, 0.85); --glass-border: rgba(255,255,255,0.05); }
        .dark .admin-topbar { background: rgba(15, 23, 42, 0.9); border-bottom-color: rgba(255,255,255,0.05); }
        .dark .stat-value, .dark h4, .dark h5, .dark h6 { color: #f1f5f9; }
        .dark .table thead th { background: #1e293b; color: #94a3b8; border-bottom-color: #334155; }
        .dark .table td { color: #cbd5e1; }
        .dark .table { color: #cbd5e1; }
        .dark .sidebar-toggle-btn:hover { background: #334155; }
        .dark .admin-footer { border-top-color: #334155; }
        .dark .form-control { background: #1e293b; border-color: #334155; color: #e2e8f0; }
        .dark .form-control:focus { background: #1e293b; color: #e2e8f0; box-shadow: 0 0 0 0.25rem rgba(99,102,241,0.25); }
        .dark .form-label { color: #cbd5e1; }
        @media (max-width: 991.98px) {
            .admin-sidebar { width: var(--sidebar-collapsed-width); }
            .admin-sidebar .nav-text,
            .admin-sidebar .sidebar-logo span,
            .admin-sidebar .user-info,
            .admin-sidebar .sidebar-section-title,
            .admin-sidebar .badge { opacity: 0; pointer-events: none; }
            .admin-main { margin-left: var(--sidebar-collapsed-width); }
            .admin-sidebar.mobile-open { width: var(--sidebar-width); }
            .admin-sidebar.mobile-open .nav-text,
            .admin-sidebar.mobile-open .sidebar-logo span,
            .admin-sidebar.mobile-open .user-info,
            .admin-sidebar.mobile-open .sidebar-section-title,
            .admin-sidebar.mobile-open .badge { opacity: 1; pointer-events: auto; }
            .sidebar-overlay.show { display: block; }
        }
        @media (max-width: 575.98px) {
            .admin-sidebar { transform: translateX(-100%); width: var(--sidebar-width); }
            .admin-sidebar.mobile-open { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .admin-content { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body x-data="{
    sidebarOpen: window.innerWidth > 991,
    mobileOpen: false,
    darkMode: localStorage.getItem('darkMode') === 'true',
    toggleSidebar() {
        if (window.innerWidth <= 991) {
            this.mobileOpen = !this.mobileOpen;
        } else {
            this.sidebarOpen = !this.sidebarOpen;
        }
    },
    toggleDark() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
    }
}" x-init="$watch('darkMode', val => document.documentElement.classList.toggle('dark', val)); if(darkMode) document.documentElement.classList.add('dark')">

    <div class="sidebar-overlay" :class="{ show: mobileOpen }" @click="mobileOpen = false"></div>

    <aside class="admin-sidebar" :class="{ collapsed: !sidebarOpen && !mobileOpen, 'mobile-open': mobileOpen }">
        <div class="sidebar-logo">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <span>Portfolio Builder</span>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i><span class="nav-text">Dashboard</span>
            </a>
            <div class="sidebar-section-title">Portfolio</div>
            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person"></i><span class="nav-text">Profile</span>
            </a>
            <a href="{{ route('admin.about.index') }}" class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i><span class="nav-text">About</span>
            </a>
            <a href="{{ route('admin.skills.index') }}" class="nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                <i class="bi bi-lightning"></i><span class="nav-text">Skills</span>
            </a>
            <a href="{{ route('admin.experience.index') }}" class="nav-link {{ request()->routeIs('admin.experience.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i><span class="nav-text">Experience</span>
            </a>
            <a href="{{ route('admin.education.index') }}" class="nav-link {{ request()->routeIs('admin.education.*') ? 'active' : '' }}">
                <i class="bi bi-mortarboard"></i><span class="nav-text">Education</span>
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i><span class="nav-text">Projects</span>
            </a>
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i><span class="nav-text">Services</span>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="bi bi-chat-quote"></i><span class="nav-text">Testimonials</span>
            </a>
            <a href="{{ route('admin.certifications.index') }}" class="nav-link {{ request()->routeIs('admin.certifications.*') ? 'active' : '' }}">
                <i class="bi bi-award"></i><span class="nav-text">Certifications</span>
            </a>
            <div class="sidebar-section-title">Content</div>
            <a href="{{ route('admin.blog.index') }}" class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i><span class="nav-text">Blog</span>
            </a>
            <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i><span class="nav-text">Messages</span>
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="nav-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i><span class="nav-text">Newsletter</span>
            </a>
            <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="bi bi-image"></i><span class="nav-text">Media</span>
            </a>
            <div class="sidebar-section-title">Tools</div>
            <a href="{{ route('admin.seo.index') }}" class="nav-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                <i class="bi bi-search"></i><span class="nav-text">SEO</span>
            </a>
            <a href="{{ route('admin.analytics.index') }}" class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i><span class="nav-text">Analytics</span>
            </a>
            <a href="{{ route('admin.pagebuilder.index') }}" class="nav-link {{ request()->routeIs('admin.pagebuilder.*') ? 'active' : '' }}">
                <i class="bi bi-layout-wtf"></i><span class="nav-text">Page Builder</span>
            </a>
            <a href="{{ route('admin.appearance.index') }}" class="nav-link {{ request()->routeIs('admin.appearance.*') ? 'active' : '' }}">
                <i class="bi bi-palette"></i><span class="nav-text">Appearance</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i><span class="nav-text">Settings</span>
            </a>
        </nav>
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            <div class="user-info">
                <div class="name">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
    </aside>

    <div class="admin-main" :class="{ 'sidebar-collapsed': !sidebarOpen && window.innerWidth > 991 }">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" @click="toggleSidebar()">
                    <i class="bi" :class="mobileOpen ? 'bi-x-lg' : 'bi-list'"></i>
                </button>
                @yield('breadcrumbs')
            </div>
            <div class="topbar-right">
                <button class="sidebar-toggle-btn" @click="toggleDark()" title="Toggle dark mode">
                    <i class="bi" :class="darkMode ? 'bi-sun-fill' : 'bi-moon-fill'"></i>
                </button>
                <div class="dropdown">
                    <button class="sidebar-toggle-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="min-width:320px;">
                        <h6 class="dropdown-header fw-semibold">Notifications</h6>
                        <div class="dropdown-item-text text-muted small">No new notifications</div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="d-flex align-items-center gap-2 border-0 bg-transparent p-1 rounded" data-bs-toggle="dropdown" aria-expanded="false">
                        <div style="width:34px;height:34px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:0.82rem;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline small fw-semibold" style="color:#475569;">{{ auth()->user()->name ?? 'User' }}</span>
                        <i class="bi bi-chevron-down small" style="color:#94a3b8;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text fw-semibold">{{ auth()->user()->name ?? 'User' }}</span></li>
                        <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email ?? '' }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bi bi-sliders me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </main>

        <footer class="admin-footer">
            &copy; {{ date('Y') }} Portfolio Builder. All rights reserved.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
