<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $profile->full_name ?? 'Minimal Portfolio' }} | {{ $customization->site_title ?? 'Portfolio' }}</title>
    <meta name="description" content="{{ $profile->tagline ?? '' }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: {{ $customization->primary_color ?? '#111827' }};
            --secondary: {{ $customization->secondary_color ?? '#374151' }};
            --accent: {{ $customization->accent_color ?? '#6b7280' }};
            --bg-light: {{ $customization->bg_light_color ?? '#fafafa' }};
            --bg-dark: {{ $customization->bg_dark_color ?? '#111827' }};
            --text-dark: {{ $customization->text_dark_color ?? '#111827' }};
            --text-light: {{ $customization->text_light_color ?? '#9ca3af' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: var(--text-dark); background: #fff; font-weight: 400; line-height: 1.7; }
        .navbar-min { padding: 1.25rem 0; transition: all 0.3s; background: transparent; border-bottom: 1px solid transparent; }
        .navbar-min.scrolled { background: #fff; border-bottom: 1px solid #f3f4f6; padding: 0.8rem 0; }
        .navbar-min .nav-link { color: var(--text-dark); font-weight: 400; padding: 0.5rem 1rem; font-size: 0.875rem; transition: color 0.3s; }
        .navbar-min .nav-link:hover { color: var(--accent); }
        .navbar-min .navbar-brand { font-weight: 700; font-size: 1.1rem; color: var(--text-dark); letter-spacing: -0.5px; }
        .navbar-min .navbar-toggler { border: none; }
        .section-padding { padding: 6rem 0; }
        .section-title { font-weight: 700; font-size: 1.75rem; letter-spacing: -0.5px; margin-bottom: 0.5rem; }
        .section-subtitle { color: var(--text-light); font-size: 0.95rem; margin-bottom: 3rem; font-weight: 300; }
        .min-line { width: 40px; height: 1px; background: var(--text-dark); margin-bottom: 1.5rem; }
        .min-card { padding: 2.5rem 0; border-bottom: 1px solid #f3f4f6; transition: all 0.3s; }
        .min-card:last-child { border-bottom: none; }
        .min-card:hover { padding-left: 1rem; }
        .min-link { color: var(--text-dark); text-decoration: none; border-bottom: 1px solid transparent; transition: all 0.3s; padding-bottom: 2px; }
        .min-link:hover { border-bottom-color: var(--text-dark); }
        .skill-tag { display: inline-block; padding: 0.4rem 1rem; border: 1px solid #e5e7eb; font-size: 0.8rem; margin: 0.25rem; transition: all 0.3s; color: var(--text-dark); }
        .skill-tag:hover { background: var(--text-dark); color: #fff; border-color: var(--text-dark); }
        .project-row { padding: 2rem 0; border-bottom: 1px solid #f3f4f6; transition: all 0.3s; }
        .project-row:hover { background: #fafafa; padding-left: 1rem; padding-right: 1rem; }
        .back-to-top { position: fixed; bottom: 30px; right: 30px; width: 40px; height: 40px; background: var(--text-dark); color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999; font-size: 0.9rem; }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { background: var(--accent); }
        footer { padding: 4rem 0 2rem; border-top: 1px solid #f3f4f6; }
        footer a { color: var(--text-light); text-decoration: none; transition: color 0.3s; font-size: 0.875rem; }
        footer a:hover { color: var(--text-dark); }
        .fade-in { opacity: 1 !important; transform: none !important; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-min fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#hero">{{ $profile->full_name ?? 'Minimal' }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-4" style="color: var(--text-dark);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach(['about' => 'About', 'skills' => 'Skills', 'experience' => 'Work', 'projects' => 'Projects', 'blog' => 'Writing', 'contact' => 'Contact'] as $id => $label)
                    <li class="nav-item"><a class="nav-link" href="#{{ $id }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <p class="mb-1" style="font-weight: 600;">{{ $profile->full_name ?? '' }}</p>
                    <p class="text-muted small">{{ $profile->tagline ?? '' }}</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <div class="d-flex gap-3 justify-content-lg-end">
                        @foreach($profile->socialLinks ?? [] as $link)
                        <a href="{{ $link->url }}" target="_blank">{{ $link->platform }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-top" style="border-color: #f3f4f6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">&copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}</small>
                    <small class="text-muted">{{ $profile->email ?? '' }}</small>
                </div>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        AOS.init({ duration: 500, easing: 'ease-out', once: true, offset: 50 });
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            const btn = document.getElementById('backToTop');
            if (window.scrollY > 50) { nav.classList.add('scrolled'); } else { nav.classList.remove('scrolled'); }
            if (window.scrollY > 400) { btn.classList.add('show'); } else { btn.classList.remove('show'); }
        });
        document.getElementById('backToTop').addEventListener('click', function() { window.scrollTo({ top: 0, behavior: 'smooth' }); });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
