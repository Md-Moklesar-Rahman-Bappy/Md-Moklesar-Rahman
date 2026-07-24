<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $profile->full_name ?? 'Portfolio' }} - {{ $profile->tagline ?? 'Creative Portfolio' }}">
    <title>{{ $profile->full_name ?? 'Portfolio' }} | Creative</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --cre-primary: {{ $customization->primary_color ?? '#e11d48' }};
            --cre-secondary: {{ $customization->secondary_color ?? '#7c3aed' }};
            --cre-accent: {{ $customization->accent_color ?? '#f59e0b' }};
            --cre-bg: {{ $customization->background_color ?? '#ffffff' }};
            --cre-bg-alt: {{ $customization->secondary_bg_color ?? '#fef2f2' }};
            --cre-text: {{ $customization->text_color ?? '#374151' }};
            --cre-heading: {{ $customization->heading_color ?? '#111827' }};
            --cre-gradient: linear-gradient(135deg, var(--cre-primary), var(--cre-secondary));
            --cre-gradient-alt: linear-gradient(135deg, var(--cre-secondary), var(--cre-accent));
            --cre-font: 'Poppins', sans-serif;
            --cre-shadow: 0 4px 20px rgba(0,0,0,0.08);
            --cre-shadow-lg: 0 20px 60px rgba(0,0,0,0.12);
            --cre-radius: 20px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--cre-font);
            background: var(--cre-bg);
            color: var(--cre-text);
            line-height: 1.7;
            overflow-x: hidden;
        }

        ::selection { background: var(--cre-primary); color: #fff; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--cre-bg); }
        ::-webkit-scrollbar-thumb { background: var(--cre-gradient); border-radius: 4px; }

        h1, h2, h3, h4, h5, h6 { color: var(--cre-heading); font-weight: 700; }

        a { color: var(--cre-primary); text-decoration: none; transition: all 0.3s ease; }
        a:hover { color: var(--cre-secondary); }

        .cre-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .cre-nav.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 0.5rem 0;
        }

        .cre-nav .nav-brand {
            font-weight: 800;
            font-size: 1.3rem;
            background: var(--cre-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cre-nav .nav-link {
            color: var(--cre-heading);
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .cre-nav .nav-link:hover,
        .cre-nav .nav-link.active {
            color: #fff;
            background: var(--cre-gradient);
        }

        .cre-section {
            padding: 6rem 0;
            position: relative;
        }

        .cre-section-alt { background: var(--cre-bg-alt); }

        .cre-section-header {
            margin-bottom: 3.5rem;
            text-align: center;
        }

        .cre-section-header .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1.2rem;
            background: var(--cre-gradient);
            color: #fff;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .cre-section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .cre-section-header p {
            color: var(--cre-text);
            max-width: 520px;
            margin: 0.75rem auto 0;
        }

        .cre-card {
            background: #fff;
            border: none;
            border-radius: var(--cre-radius);
            padding: 2rem;
            box-shadow: var(--cre-shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .cre-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--cre-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
            transform-origin: left;
        }

        .cre-card:hover::before { transform: scaleX(1); }

        .cre-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--cre-shadow-lg);
        }

        .cre-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 2rem;
            background: var(--cre-gradient);
            color: #fff;
            font-family: var(--cre-font);
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cre-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(225, 29, 72, 0.3);
            color: #fff;
        }

        .cre-btn-outline {
            background: transparent;
            border: 2px solid var(--cre-primary);
            color: var(--cre-primary);
        }

        .cre-btn-outline:hover {
            background: var(--cre-gradient);
            border-color: transparent;
            color: #fff;
        }

        .cre-skew-section {
            background: var(--cre-gradient);
            padding: 5rem 0;
            position: relative;
        }

        .cre-skew-section::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            right: 0;
            height: 50px;
            background: inherit;
            clip-path: polygon(0 100%, 100% 0, 100% 100%);
        }

        .cre-skew-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            background: inherit;
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }

        .cre-footer {
            background: var(--cre-heading);
            color: #d1d5db;
            padding: 4rem 0 1.5rem;
        }

        .cre-footer h5 { color: #fff; font-weight: 700; }
        .cre-footer a { color: #d1d5db; transition: color 0.3s; }
        .cre-footer a:hover { color: var(--cre-primary); }

        .cre-footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            color: #d1d5db;
            transition: all 0.3s ease;
        }

        .cre-footer .social-links a:hover {
            background: var(--cre-gradient);
            color: #fff;
            transform: translateY(-3px);
        }

        .cre-footer .copyright {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.85rem;
        }

        .cre-back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: var(--cre-gradient);
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(225, 29, 72, 0.3);
        }

        .cre-back-to-top.visible { opacity: 1; visibility: visible; }
        .cre-back-to-top:hover { transform: translateY(-3px) scale(1.1); }

        .cre-icon-blob {
            width: 70px;
            height: 70px;
            background: var(--cre-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            margin: 0 auto 1.25rem;
            transition: all 0.3s ease;
        }

        .cre-card:hover .cre-icon-blob {
            transform: scale(1.1) rotate(5deg);
        }

        .cre-split-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .cre-gradient-text {
            background: var(--cre-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cre-tag {
            display: inline-block;
            padding: 0.3rem 0.9rem;
            background: rgba(225, 29, 72, 0.08);
            color: var(--cre-primary);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin: 0.2rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="cre-nav" id="mainNav">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="#hero" class="nav-brand">{{ $profile->full_name ?? 'Creative' }}</a>
                <div class="d-none d-lg-flex align-items-center gap-2">
                    @if($data['nav_items'] ?? null)
                        @foreach($data['nav_items'] as $item)
                            <a href="#{{ $item['section'] ?? '#' }}" class="nav-link">{{ $item['label'] ?? '' }}</a>
                        @endforeach
                    @else
                        <a href="#about" class="nav-link">About</a>
                        <a href="#skills" class="nav-link">Skills</a>
                        <a href="#experience" class="nav-link">Experience</a>
                        <a href="#projects" class="nav-link">Projects</a>
                        <a href="#contact" class="nav-link">Contact</a>
                    @endif
                </div>
                <a href="#contact" class="cre-btn d-none d-lg-inline-flex" style="padding: 0.6rem 1.5rem; font-size: 0.85rem;">Hire Me</a>
                <button class="btn btn-sm d-lg-none" style="color: var(--cre-primary);" onclick="document.querySelector('.cre-nav-links').classList.toggle('d-none')">
                    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="cre-nav-links d-lg-none d-none mt-3">
                @if($data['nav_items'] ?? null)
                    @foreach($data['nav_items'] as $item)
                        <a href="#{{ $item['section'] ?? '#' }}" class="nav-link d-block py-2">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                @else
                    <a href="#about" class="nav-link d-block py-2">About</a>
                    <a href="#skills" class="nav-link d-block py-2">Skills</a>
                    <a href="#experience" class="nav-link d-block py-2">Experience</a>
                    <a href="#projects" class="nav-link d-block py-2">Projects</a>
                    <a href="#contact" class="nav-link d-block py-2">Contact</a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="cre-footer">
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
                        <a href="#about">About Me</a>
                        <a href="#projects">Projects</a>
                        <a href="#services">Services</a>
                        <a href="#contact">Contact</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="mb-3" style="color: #fff;">Contact Info</h6>
                    @if($profile->email ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope" style="color: var(--cre-primary);"></i>
                            <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                        </div>
                    @endif
                    @if($profile->phone ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone" style="color: var(--cre-primary);"></i>
                            <a href="tel:{{ $profile->phone }}">{{ $profile->phone }}</a>
                        </div>
                    @endif
                    @if($profile->location ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt" style="color: var(--cre-primary);"></i>
                            <span>{{ $profile->location }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="copyright text-center">
                &copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. All rights reserved. Made with <i class="bi bi-heart-fill" style="color: var(--cre-primary);"></i>
            </div>
        </div>
    </footer>

    <button class="cre-back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
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

        document.querySelectorAll('.cre-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        const sections = document.querySelectorAll('.cre-section[id]');
        const navLinks = document.querySelectorAll('.cre-nav .nav-link');
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
