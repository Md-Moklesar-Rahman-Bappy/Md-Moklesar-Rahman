<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $profile->full_name ?? 'SaaS Portfolio' }} | {{ $customization->site_title ?? 'Portfolio' }}</title>
    <meta name="description" content="{{ $profile->tagline ?? '' }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: {{ $customization->primary_color ?? '#7c3aed' }};
            --secondary: {{ $customization->secondary_color ?? '#3b82f6' }};
            --accent: {{ $customization->accent_color ?? '#06b6d4' }};
            --bg-light: {{ $customization->bg_light_color ?? '#f8fafc' }};
            --bg-dark: {{ $customization->bg_dark_color ?? '#0f172a' }};
            --text-dark: {{ $customization->text_dark_color ?? '#0f172a' }};
            --text-light: {{ $customization->text_light_color ?? '#64748b' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; color: var(--text-dark); overflow-x: hidden; }
        .navbar-saas { padding: 1rem 0; transition: all 0.3s; background: transparent; }
        .navbar-saas.scrolled { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); box-shadow: 0 1px 30px rgba(0,0,0,0.08); padding: 0.7rem 0; }
        .navbar-saas .nav-link { color: rgba(255,255,255,0.85); font-weight: 500; padding: 0.5rem 1.1rem; font-size: 0.9rem; transition: all 0.3s; }
        .navbar-saas.scrolled .nav-link { color: var(--text-dark); }
        .navbar-saas .nav-link:hover { color: var(--accent); }
        .navbar-saas .navbar-brand { font-weight: 800; font-size: 1.4rem; color: #fff; }
        .navbar-saas.scrolled .navbar-brand { color: var(--primary); }
        .btn-saas { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; border: none; padding: 0.8rem 2rem; border-radius: 12px; font-weight: 600; transition: all 0.3s; }
        .btn-saas:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(124,58,237,0.3); color: #fff; }
        .btn-saas-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.3); padding: 0.8rem 2rem; border-radius: 12px; font-weight: 600; transition: all 0.3s; }
        .btn-saas-outline:hover { background: #fff; color: var(--primary); border-color: #fff; }
        .btn-saas-dark { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; border: none; padding: 0.8rem 2rem; border-radius: 12px; font-weight: 600; transition: all 0.3s; }
        .btn-saas-dark:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(124,58,237,0.3); color: #fff; }
        .section-padding { padding: 6rem 0; }
        .section-title { font-weight: 800; font-size: 2.2rem; letter-spacing: -0.5px; margin-bottom: 0.5rem; }
        .section-subtitle { color: var(--text-light); margin-bottom: 3rem; font-weight: 400; }
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; }
        .feature-card { background: #fff; border-radius: 20px; padding: 2.5rem; transition: all 0.4s; border: 1px solid #f1f5f9; position: relative; overflow: hidden; }
        .feature-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, var(--primary), var(--secondary)); opacity: 0; transition: opacity 0.3s; }
        .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .feature-card:hover::before { opacity: 1; }
        .feature-icon { width: 65px; height: 65px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem; }
        .pricing-card { background: #fff; border-radius: 24px; padding: 3rem 2rem; text-align: center; transition: all 0.4s; border: 1px solid #f1f5f9; position: relative; }
        .pricing-card.popular { border: 2px solid var(--primary); transform: scale(1.05); box-shadow: 0 20px 50px rgba(124,58,237,0.15); }
        .pricing-card.popular::before { content: 'Most Popular'; position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; padding: 4px 20px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .pricing-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .pricing-card.popular:hover { transform: scale(1.05) translateY(-8px); }
        .cta-section { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%); position: relative; overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; top: -50%; right: -20%; width: 500px; height: 500px; background: rgba(255,255,255,0.05); border-radius: 50%; }
        .cta-section::after { content: ''; position: absolute; bottom: -30%; left: -10%; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; }
        .testimonial-card { background: #fff; border-radius: 20px; padding: 2rem; box-shadow: 0 5px 30px rgba(0,0,0,0.04); }
        .back-to-top { position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; border: none; border-radius: 14px; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 999; }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(124,58,237,0.3); }
        footer { background: var(--bg-dark); color: #94a3b8; padding: 5rem 0 0; }
        footer a { color: #94a3b8; text-decoration: none; transition: color 0.3s; }
        footer a:hover { color: #fff; }
        footer .footer-title { color: #fff; font-weight: 700; margin-bottom: 1.5rem; }
        footer .social-link { width: 42px; height: 42px; border-radius: 12px; background: rgba(255,255,255,0.05); display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.08); }
        footer .social-link:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-saas fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#hero">{{ $profile->full_name ?? 'SaaS' }}</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach(['hero' => 'Home', 'about' => 'About', 'features' => 'Features', 'services' => 'Services', 'projects' => 'Projects', 'testimonials' => 'Testimonials', 'contact' => 'Contact'] as $id => $label)
                    <li class="nav-item"><a class="nav-link" href="#{{ $id }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
                <a href="#contact" class="btn btn-saas ms-3" style="padding: 0.5rem 1.5rem; font-size: 0.85rem;">Get Started</a>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="footer-title">{{ $profile->full_name ?? '' }}</h5>
                    <p class="small">{{ $profile->tagline ?? '' }}</p>
                    <div class="d-flex gap-2 mt-3">
                        @foreach($profile->socialLinks ?? [] as $link)
                        <a href="{{ $link->url }}" class="social-link" target="_blank"><i class="bi bi-{{ $link->platform }}"></i></a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="footer-title" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Product</h6>
                    <ul class="list-unstyled">
                        @foreach(['Features', 'Services', 'Projects', 'Pricing'] as $item)
                        <li class="mb-2"><a href="#{{ strtolower($item) }}" class="small">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="footer-title" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Company</h6>
                    <ul class="list-unstyled">
                        @foreach(['About', 'Blog', 'Careers', 'Contact'] as $item)
                        <li class="mb-2"><a href="#{{ strtolower($item) }}" class="small">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="footer-title" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Contact</h6>
                    <p class="small"><i class="bi bi-envelope me-2"></i>{{ $profile->email ?? '' }}</p>
                    <p class="small"><i class="bi bi-telephone me-2"></i>{{ $profile->phone ?? '' }}</p>
                    <p class="small"><i class="bi bi-geo-alt me-2"></i>{{ $profile->location ?? '' }}</p>
                </div>
            </div>
            <div class="border-top mt-5 pt-4 pb-4 d-flex justify-content-between align-items-center" style="border-color: rgba(255,255,255,0.08) !important;">
                <small>&copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. All rights reserved.</small>
                <small>Built with passion</small>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true });
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
