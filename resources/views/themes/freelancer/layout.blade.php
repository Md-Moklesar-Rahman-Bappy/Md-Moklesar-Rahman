<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $profile->full_name ?? 'Portfolio' }} - {{ $profile->tagline ?? 'Freelance Professional' }}">
    <title>{{ $profile->full_name ?? 'Portfolio' }} | Freelancer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --fre-primary: {{ $customization->primary_color ?? '#2563eb' }};
            --fre-secondary: {{ $customization->secondary_color ?? '#f97316' }};
            --fre-accent: {{ $customization->accent_color ?? '#10b981' }};
            --fre-bg: {{ $customization->background_color ?? '#ffffff' }};
            --fre-bg-alt: {{ $customization->secondary_bg_color ?? '#f1f5f9' }};
            --fre-text: {{ $customization->text_color ?? '#475569' }};
            --fre-heading: {{ $customization->heading_color ?? '#0f172a' }};
            --fre-font: 'Open Sans', sans-serif;
            --fre-shadow: 0 2px 10px rgba(0,0,0,0.06);
            --fre-shadow-lg: 0 15px 50px rgba(0,0,0,0.1);
            --fre-radius: 16px;
            --fre-warm: linear-gradient(135deg, #2563eb, #7c3aed);
            --fre-warm-accent: linear-gradient(135deg, #f97316, #ef4444);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--fre-font);
            background: var(--fre-bg);
            color: var(--fre-text);
            line-height: 1.8;
            overflow-x: hidden;
        }

        ::selection { background: var(--fre-primary); color: #fff; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--fre-bg-alt); }
        ::-webkit-scrollbar-thumb { background: var(--fre-primary); border-radius: 4px; }

        h1, h2, h3, h4, h5, h6 { color: var(--fre-heading); font-weight: 700; }

        a { color: var(--fre-primary); text-decoration: none; transition: all 0.3s ease; }
        a:hover { color: var(--fre-secondary); }

        .fre-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .fre-nav.scrolled {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            box-shadow: var(--fre-shadow);
            padding: 0.5rem 0;
        }

        .fre-nav .nav-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--fre-primary);
        }

        .fre-nav .nav-link {
            color: var(--fre-heading);
            font-weight: 500;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .fre-nav .nav-link:hover,
        .fre-nav .nav-link.active {
            color: var(--fre-primary);
            background: rgba(37, 99, 235, 0.06);
        }

        .fre-section {
            padding: 6rem 0;
        }

        .fre-section-alt { background: var(--fre-bg-alt); }

        .fre-section-header {
            margin-bottom: 3.5rem;
            text-align: center;
        }

        .fre-section-header .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1.2rem;
            background: rgba(37, 99, 235, 0.08);
            color: var(--fre-primary);
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .fre-section-header h2 {
            font-size: 2.25rem;
            font-weight: 800;
        }

        .fre-section-header p {
            color: var(--fre-text);
            max-width: 520px;
            margin: 0.75rem auto 0;
        }

        .fre-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: var(--fre-radius);
            padding: 2rem;
            box-shadow: var(--fre-shadow);
            transition: all 0.3s ease;
            height: 100%;
        }

        .fre-card:hover {
            box-shadow: var(--fre-shadow-lg);
            transform: translateY(-5px);
        }

        .fre-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 2rem;
            background: var(--fre-warm);
            color: #fff;
            font-family: var(--fre-font);
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .fre-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
            color: #fff;
        }

        .fre-btn-accent {
            background: var(--fre-warm-accent);
        }

        .fre-btn-accent:hover {
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
        }

        .fre-btn-outline {
            background: transparent;
            border: 2px solid var(--fre-primary);
            color: var(--fre-primary);
        }

        .fre-btn-outline:hover {
            background: var(--fre-warm);
            border-color: transparent;
            color: #fff;
        }

        .fre-hero-fullscreen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 5rem;
        }

        .fre-hero-fullscreen::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232563eb' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .fre-hero-fullscreen .container { position: relative; z-index: 1; }

        /* Timeline styles */
        .fre-timeline {
            position: relative;
            padding: 1rem 0;
        }

        .fre-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 30px;
            width: 3px;
            background: linear-gradient(180deg, var(--fre-primary), var(--fre-secondary));
            border-radius: 2px;
        }

        .fre-timeline-item {
            position: relative;
            padding-left: 80px;
            margin-bottom: 2.5rem;
        }

        .fre-timeline-item::before {
            content: '';
            position: absolute;
            left: 21px;
            top: 8px;
            width: 20px;
            height: 20px;
            background: var(--fre-primary);
            border: 4px solid var(--fre-bg);
            border-radius: 50%;
            box-shadow: 0 0 0 3px var(--fre-primary);
            z-index: 1;
        }

        .fre-timeline-item .fre-card {
            position: relative;
        }

        /* Pricing card styles */
        .fre-pricing-card {
            background: #fff;
            border-radius: var(--fre-radius);
            padding: 2.5rem 2rem;
            box-shadow: var(--fre-shadow);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .fre-pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--fre-shadow-lg);
        }

        .fre-pricing-card.featured {
            border-color: var(--fre-primary);
        }

        .fre-pricing-card.featured::before {
            content: 'Popular';
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--fre-warm);
            color: #fff;
            padding: 0.25rem 2.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            transform: rotate(45deg);
        }

        /* Carousel custom */
        .fre-testimonial-carousel .carousel-item {
            padding: 0 15px;
        }

        .fre-footer {
            background: var(--fre-heading);
            color: #cbd5e1;
            padding: 4rem 0 1.5rem;
        }

        .fre-footer h5 { color: #fff; font-weight: 700; }
        .fre-footer a { color: #cbd5e1; transition: color 0.3s; }
        .fre-footer a:hover { color: var(--fre-primary); }

        .fre-footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            color: #cbd5e1;
            transition: all 0.3s ease;
        }

        .fre-footer .social-links a:hover {
            background: var(--fre-primary);
            color: #fff;
            transform: translateY(-2px);
        }

        .fre-footer .copyright {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.85rem;
        }

        .fre-back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 48px;
            height: 48px;
            background: var(--fre-warm);
            color: #fff;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .fre-back-to-top.visible { opacity: 1; visibility: visible; }
        .fre-back-to-top:hover { transform: translateY(-3px); }

        .fre-icon-box {
            width: 64px;
            height: 64px;
            background: rgba(37, 99, 235, 0.08);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--fre-primary);
            font-size: 1.4rem;
            transition: all 0.3s ease;
            margin: 0 auto 1.25rem;
        }

        .fre-card:hover .fre-icon-box {
            background: var(--fre-warm);
            color: #fff;
            transform: scale(1.1);
        }

        .fre-progress {
            height: 8px;
            background: rgba(37,99,235,0.1);
            border-radius: 4px;
            overflow: hidden;
        }

        .fre-progress-fill {
            height: 100%;
            background: var(--fre-warm);
            border-radius: 4px;
        }

        .fre-stat-card {
            background: #fff;
            border-radius: var(--fre-radius);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--fre-shadow);
            transition: all 0.3s ease;
        }

        .fre-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--fre-shadow-lg);
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="fre-nav" id="mainNav">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="#hero" class="nav-brand">{{ $profile->full_name ?? 'Freelancer' }}</a>
                <div class="d-none d-lg-flex align-items-center gap-1">
                    @if($data['nav_items'] ?? null)
                        @foreach($data['nav_items'] as $item)
                            <a href="#{{ $item['section'] ?? '#' }}" class="nav-link">{{ $item['label'] ?? '' }}</a>
                        @endforeach
                    @else
                        <a href="#about" class="nav-link">About</a>
                        <a href="#skills" class="nav-link">Skills</a>
                        <a href="#experience" class="nav-link">Experience</a>
                        <a href="#services" class="nav-link">Services</a>
                        <a href="#contact" class="nav-link">Contact</a>
                    @endif
                </div>
                <a href="#contact" class="fre-btn d-none d-lg-inline-flex" style="padding: 0.6rem 1.5rem; font-size: 0.85rem;">
                    <i class="bi bi-chat-dots"></i> Hire Me
                </a>
                <button class="btn btn-sm d-lg-none" style="color: var(--fre-primary);" onclick="document.querySelector('.fre-nav-links').classList.toggle('d-none')">
                    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="fre-nav-links d-lg-none d-none mt-3">
                @if($data['nav_items'] ?? null)
                    @foreach($data['nav_items'] as $item)
                        <a href="#{{ $item['section'] ?? '#' }}" class="nav-link d-block py-2">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                @else
                    <a href="#about" class="nav-link d-block py-2">About</a>
                    <a href="#skills" class="nav-link d-block py-2">Skills</a>
                    <a href="#experience" class="nav-link d-block py-2">Experience</a>
                    <a href="#services" class="nav-link d-block py-2">Services</a>
                    <a href="#contact" class="nav-link d-block py-2">Contact</a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="fre-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">{{ $profile->full_name ?? '' }}</h5>
                    <p style="line-height: 1.8;">{{ $profile->tagline ?? '' }}</p>
                    <div class="social-links mt-3">
                        @if($profile->socialLinks ?? null)
                            @foreach($profile->socialLinks as $link)
                                <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h6 class="mb-3" style="color: #fff;">Quick Links</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="#about">About</a>
                        <a href="#services">Services</a>
                        <a href="#projects">Projects</a>
                        <a href="#contact">Contact</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="mb-3" style="color: #fff;">Reach Me</h6>
                    @if($profile->email ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope" style="color: var(--fre-primary);"></i>
                            <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                        </div>
                    @endif
                    @if($profile->phone ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone" style="color: var(--fre-primary);"></i>
                            <a href="tel:{{ $profile->phone }}">{{ $profile->phone }}</a>
                        </div>
                    @endif
                    @if($profile->location ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt" style="color: var(--fre-primary);"></i>
                            <span>{{ $profile->location }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="copyright text-center">
                &copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. All rights reserved.
            </div>
        </div>
    </footer>

    <button class="fre-back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        const backToTop = document.getElementById('backToTop');
        const nav = document.getElementById('mainNav');

        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.scrollY > 300);
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        document.querySelectorAll('.fre-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        const sections = document.querySelectorAll('.fre-section[id]');
        const navLinks = document.querySelectorAll('.fre-nav .nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
