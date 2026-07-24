<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $profile->full_name ?? 'Corporate Portfolio' }} | {{ $customization->site_title ?? 'Portfolio' }}</title>
    <meta name="description" content="{{ $profile->tagline ?? '' }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: {{ $customization->primary_color ?? '#1e3a5f' }};
            --secondary: {{ $customization->secondary_color ?? '#2c5282' }};
            --accent: {{ $customization->accent_color ?? '#3182ce' }};
            --bg-light: {{ $customization->bg_light_color ?? '#f7fafc' }};
            --bg-dark: {{ $customization->bg_dark_color ?? '#1a202c' }};
            --text-dark: {{ $customization->text_dark_color ?? '#2d3748' }};
            --text-light: {{ $customization->text_light_color ?? '#718096' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; color: var(--text-dark); background: #fff; }
        .navbar-corp { padding: 1rem 0; transition: all 0.3s; background: var(--bg-dark); }
        .navbar-corp.scrolled { background: #fff; box-shadow: 0 1px 10px rgba(0,0,0,0.08); padding: 0.7rem 0; }
        .navbar-corp .nav-link { color: rgba(255,255,255,0.85); font-weight: 500; padding: 0.5rem 1.25rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; transition: color 0.3s; }
        .navbar-corp.scrolled .nav-link { color: var(--text-dark); }
        .navbar-corp .nav-link:hover { color: var(--accent); }
        .navbar-corp .navbar-brand { font-weight: 900; font-size: 1.3rem; color: #fff; text-transform: uppercase; letter-spacing: 1px; }
        .navbar-corp.scrolled .navbar-brand { color: var(--primary); }
        .btn-corp { background: var(--primary); color: #fff; border: none; padding: 0.75rem 2rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; transition: all 0.3s; }
        .btn-corp:hover { background: var(--accent); color: #fff; }
        .section-padding { padding: 5rem 0; }
        .section-title { font-weight: 900; text-transform: uppercase; letter-spacing: 1px; font-size: 2rem; margin-bottom: 0.5rem; }
        .section-subtitle { color: var(--text-light); margin-bottom: 3rem; }
        .corp-divider { width: 50px; height: 3px; background: var(--primary); margin-bottom: 1rem; }
        .corp-card { background: #fff; border: 1px solid #e2e8f0; padding: 2rem; transition: all 0.3s; }
        .corp-card:hover { border-color: var(--primary); box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
        .service-box { text-align: left; padding: 2rem; border: 1px solid #e2e8f0; transition: all 0.3s; }
        .service-box:hover { border-color: var(--primary); }
        .service-box .icon-box { width: 60px; height: 60px; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem; }
        .exp-block { border-left: 3px solid var(--primary); padding-left: 1.5rem; margin-bottom: 2.5rem; }
        .back-to-top { position: fixed; bottom: 30px; right: 30px; width: 42px; height: 42px; background: var(--primary); color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999; }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { background: var(--accent); }
        footer { background: var(--bg-dark); color: #a0aec0; padding: 4rem 0 0; }
        footer a { color: #a0aec0; text-decoration: none; transition: color 0.3s; }
        footer a:hover { color: #fff; }
        footer .corp-footer-title { color: #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; margin-bottom: 1.5rem; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-corp fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#hero">{{ $profile->full_name ?? 'Corporate' }}</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach(['hero' => 'Home', 'about' => 'About', 'experience' => 'Experience', 'services' => 'Services', 'education' => 'Education', 'skills' => 'Skills', 'contact' => 'Contact'] as $id => $label)
                    <li class="nav-item"><a class="nav-link" href="#{{ $id }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer>
        <div class="container">
            <div class="row g-4 pb-4">
                <div class="col-lg-4">
                    <h6 class="corp-footer-title">{{ $profile->full_name ?? '' }}</h6>
                    <p class="small">{{ $profile->tagline ?? '' }}</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="corp-footer-title">Quick Links</h6>
                    <ul class="list-unstyled">
                        @foreach(['About', 'Services', 'Projects', 'Contact'] as $item)
                        <li class="mb-2"><a href="#{{ strtolower($item) }}" class="small">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="corp-footer-title">Contact Details</h6>
                    <p class="small mb-1"><i class="bi bi-envelope me-2"></i>{{ $profile->email ?? '' }}</p>
                    <p class="small mb-1"><i class="bi bi-telephone me-2"></i>{{ $profile->phone ?? '' }}</p>
                    <p class="small mb-3"><i class="bi bi-geo-alt me-2"></i>{{ $profile->location ?? '' }}</p>
                    <div>
                        @foreach($profile->socialLinks ?? [] as $link)
                        <a href="{{ $link->url }}" class="me-2" target="_blank"><i class="bi bi-{{ $link->platform }}"></i></a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 pb-3 text-center">
                <p class="small mb-0">&copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="bi bi-chevron-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        AOS.init({ duration: 600, easing: 'ease-out', once: true });
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
