<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $profile->full_name ?? 'Agency Portfolio' }} | {{ $customization->site_title ?? 'Portfolio' }}</title>
    <meta name="description" content="{{ $profile->tagline ?? '' }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: {{ $customization->primary_color ?? '#1e40af' }};
            --secondary: {{ $customization->secondary_color ?? '#3b82f6' }};
            --accent: {{ $customization->accent_color ?? '#f59e0b' }};
            --bg-light: {{ $customization->bg_light_color ?? '#f8fafc' }};
            --bg-dark: {{ $customization->bg_dark_color ?? '#0f172a' }};
            --text-dark: {{ $customization->text_dark_color ?? '#1e293b' }};
            --text-light: {{ $customization->text_light_color ?? '#64748b' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; color: var(--text-dark); overflow-x: hidden; }
        .navbar-agency { padding: 1rem 0; transition: all 0.3s ease; background: transparent; }
        .navbar-agency.scrolled { background: #fff; box-shadow: 0 2px 20px rgba(0,0,0,0.1); padding: 0.6rem 0; }
        .navbar-agency .nav-link { color: #fff; font-weight: 500; padding: 0.5rem 1rem; transition: color 0.3s; }
        .navbar-agency.scrolled .nav-link { color: var(--text-dark); }
        .navbar-agency .nav-link:hover { color: var(--accent); }
        .navbar-agency .navbar-brand { font-weight: 800; font-size: 1.4rem; color: #fff; }
        .navbar-agency.scrolled .navbar-brand { color: var(--primary); }
        .btn-agency { background: var(--primary); color: #fff; border: none; padding: 0.75rem 2rem; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
        .btn-agency:hover { background: var(--secondary); color: #fff; transform: translateY(-2px); box-shadow: 0 5px 20px rgba(30,64,175,0.3); }
        .btn-agency-outline { background: transparent; color: #fff; border: 2px solid #fff; padding: 0.75rem 2rem; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
        .btn-agency-outline:hover { background: #fff; color: var(--primary); }
        .section-padding { padding: 6rem 0; }
        .section-title { font-weight: 800; margin-bottom: 1rem; }
        .section-subtitle { color: var(--text-light); font-weight: 400; margin-bottom: 3rem; }
        .agency-line { width: 60px; height: 4px; background: var(--accent); border-radius: 2px; margin-bottom: 1.5rem; }
        .stat-card { text-align: center; padding: 2rem; }
        .stat-number { font-size: 3rem; font-weight: 800; color: var(--primary); }
        .stat-label { color: var(--text-light); font-weight: 500; margin-top: 0.5rem; }
        .service-card { background: #fff; border-radius: 16px; padding: 2.5rem; text-align: center; box-shadow: 0 5px 30px rgba(0,0,0,0.05); transition: all 0.3s; border: 1px solid #f1f5f9; }
        .service-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
        .service-icon { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #fff; font-size: 2rem; }
        .project-card { border-radius: 16px; overflow: hidden; position: relative; }
        .project-card img { width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s; }
        .project-card:hover img { transform: scale(1.1); }
        .project-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 2rem; color: #fff; transform: translateY(100%); transition: transform 0.4s; }
        .project-card:hover .project-overlay { transform: translateY(0); }
        .testimonial-card { background: #fff; border-radius: 16px; padding: 2.5rem; box-shadow: 0 5px 30px rgba(0,0,0,0.05); position: relative; }
        .testimonial-card::before { content: '\201C'; font-size: 5rem; color: var(--primary); opacity: 0.1; position: absolute; top: -10px; left: 20px; font-family: serif; }
        .team-social a { width: 36px; height: 36px; border-radius: 50%; background: var(--bg-light); display: inline-flex; align-items: center; justify-content: center; margin: 0 3px; color: var(--primary); transition: all 0.3s; }
        .team-social a:hover { background: var(--primary); color: #fff; }
        .back-to-top { position: fixed; bottom: 30px; right: 30px; width: 45px; height: 45px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999; border: none; }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { background: var(--secondary); transform: translateY(-3px); }
        footer { background: var(--bg-dark); color: #cbd5e1; padding: 4rem 0 2rem; }
        footer a { color: #94a3b8; text-decoration: none; transition: color 0.3s; }
        footer a:hover { color: var(--accent); }
        footer .footer-heading { color: #fff; font-weight: 700; margin-bottom: 1.5rem; }
        footer .social-link { width: 40px; height: 40px; border-radius: 50%; border: 1px solid #334155; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; transition: all 0.3s; margin-right: 0.5rem; }
        footer .social-link:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-agency fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#hero">{{ $profile->full_name ?? 'Agency' }}</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach(['hero' => 'Home', 'about' => 'About', 'services' => 'Services', 'projects' => 'Projects', 'experience' => 'Experience', 'testimonials' => 'Testimonials', 'contact' => 'Contact'] as $id => $label)
                    <li class="nav-item"><a class="nav-link" href="#{{ $id }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="footer-heading">{{ $profile->full_name ?? '' }}</h5>
                    <p>{{ $profile->tagline ?? '' }}</p>
                    <div class="mt-3">
                        @foreach($profile->socialLinks ?? [] as $link)
                        <a href="{{ $link->url }}" class="social-link" target="_blank"><i class="bi bi-{{ $link->platform }}"></i></a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="list-unstyled">
                        @foreach(['About', 'Services', 'Projects', 'Contact'] as $item)
                        <li class="mb-2"><a href="#{{ strtolower($item) }}">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="footer-heading">Contact</h5>
                    <p><i class="bi bi-envelope me-2"></i>{{ $profile->email ?? '' }}</p>
                    <p><i class="bi bi-phone me-2"></i>{{ $profile->phone ?? '' }}</p>
                    <p><i class="bi bi-geo-alt me-2"></i>{{ $profile->location ?? '' }}</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: #334155;">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
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
