<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $profile->full_name ?? 'Portfolio' }} - {{ $profile->tagline ?? 'Modern Portfolio' }}">
    <title>{{ $profile->full_name ?? 'Portfolio' }} | Modern</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --mod-primary: {{ $customization->primary_color ?? '#6366f1' }};
            --mod-secondary: {{ $customization->secondary_color ?? '#8b5cf6' }};
            --mod-accent: {{ $customization->accent_color ?? '#06b6d4' }};
            --mod-bg: {{ $customization->background_color ?? '#ffffff' }};
            --mod-bg-alt: {{ $customization->secondary_bg_color ?? '#f8fafc' }};
            --mod-text: {{ $customization->text_color ?? '#475569' }};
            --mod-heading: {{ $customization->heading_color ?? '#0f172a' }};
            --mod-card-bg: #ffffff;
            --mod-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --mod-shadow-lg: 0 10px 40px rgba(0,0,0,0.08);
            --mod-radius: 16px;
            --mod-font: 'Inter', sans-serif;
            --mod-gradient: linear-gradient(135deg, var(--mod-primary), var(--mod-secondary));
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--mod-font);
            background: var(--mod-bg);
            color: var(--mod-text);
            line-height: 1.7;
            overflow-x: hidden;
        }

        ::selection {
            background: var(--mod-primary);
            color: #fff;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--mod-bg-alt); }
        ::-webkit-scrollbar-thumb { background: var(--mod-primary); border-radius: 3px; }

        h1, h2, h3, h4, h5, h6 {
            color: var(--mod-heading);
            font-family: var(--mod-font);
            font-weight: 700;
        }

        a { color: var(--mod-primary); text-decoration: none; transition: all 0.3s ease; }
        a:hover { color: var(--mod-secondary); }

        .mod-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .mod-nav.scrolled {
            padding: 0.5rem 0;
            box-shadow: var(--mod-shadow);
        }

        .mod-nav .nav-brand {
            font-weight: 800;
            font-size: 1.25rem;
            background: var(--mod-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mod-nav .nav-link {
            color: var(--mod-text);
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mod-nav .nav-link:hover,
        .mod-nav .nav-link.active {
            color: var(--mod-primary);
            background: rgba(99, 102, 241, 0.08);
        }

        .mod-section {
            padding: 6rem 0;
        }

        .mod-section-alt {
            background: var(--mod-bg-alt);
        }

        .mod-section-header {
            margin-bottom: 3.5rem;
            text-align: center;
        }

        .mod-section-header .section-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            background: rgba(99, 102, 241, 0.08);
            color: var(--mod-primary);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .mod-section-header h2 {
            font-size: 2.25rem;
            font-weight: 800;
        }

        .mod-section-header p {
            color: var(--mod-text);
            max-width: 560px;
            margin: 0.75rem auto 0;
            font-size: 1.05rem;
        }

        .mod-card {
            background: var(--mod-card-bg);
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: var(--mod-radius);
            padding: 2rem;
            box-shadow: var(--mod-shadow);
            transition: all 0.3s ease;
            height: 100%;
        }

        .mod-card:hover {
            box-shadow: var(--mod-shadow-lg);
            transform: translateY(-6px);
            border-color: rgba(99, 102, 241, 0.15);
        }

        .mod-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 2rem;
            background: var(--mod-gradient);
            color: #fff;
            font-family: var(--mod-font);
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .mod-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
            color: #fff;
        }

        .mod-btn-outline {
            background: transparent;
            border: 2px solid var(--mod-primary);
            color: var(--mod-primary);
        }

        .mod-btn-outline:hover {
            background: var(--mod-primary);
            color: #fff;
        }

        .mod-skill-chip {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: rgba(99, 102, 241, 0.06);
            color: var(--mod-primary);
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0.3rem;
            transition: all 0.3s ease;
        }

        .mod-skill-chip:hover {
            background: var(--mod-primary);
            color: #fff;
        }

        .mod-footer {
            background: var(--mod-heading);
            color: #94a3b8;
            padding: 4rem 0 1.5rem;
        }

        .mod-footer h5 {
            color: #fff;
            font-size: 1.1rem;
        }

        .mod-footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            color: #94a3b8;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .mod-footer .social-links a:hover {
            background: var(--mod-primary);
            color: #fff;
            transform: translateY(-2px);
        }

        .mod-footer .copyright {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.85rem;
        }

        .mod-back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 48px;
            height: 48px;
            background: var(--mod-gradient);
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
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .mod-back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .mod-back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .mod-progress-bar {
            height: 6px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }

        .mod-progress-bar .progress-fill {
            height: 100%;
            background: var(--mod-gradient);
            border-radius: 3px;
            transition: width 1s ease;
        }

        .mod-icon-circle {
            width: 56px;
            height: 56px;
            background: rgba(99, 102, 241, 0.08);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--mod-primary);
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .mod-card:hover .mod-icon-circle {
            background: var(--mod-primary);
            color: #fff;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="mod-nav" id="mainNav">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="#hero" class="nav-brand">{{ $profile->full_name ?? 'Portfolio' }}</a>
                <div class="d-none d-lg-flex align-items-center gap-1">
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
                <a href="#contact" class="mod-btn d-none d-lg-inline-flex" style="padding: 0.6rem 1.5rem; font-size: 0.85rem;">Let's Talk</a>
                <button class="btn btn-sm d-lg-none" style="color: var(--mod-primary);" onclick="document.querySelector('.mod-nav-links').classList.toggle('d-none')">
                    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                </button>
            </div>
            <div class="mod-nav-links d-lg-none d-none mt-3">
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

    <footer class="mod-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">{{ $profile->full_name ?? '' }}</h5>
                    <p style="line-height: 1.8;">{{ $profile->tagline ?? '' }}</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h6 class="mb-3" style="color: #e2e8f0;">Quick Links</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="#about" style="color: #94a3b8; font-size: 0.9rem;">About</a>
                        <a href="#projects" style="color: #94a3b8; font-size: 0.9rem;">Projects</a>
                        <a href="#contact" style="color: #94a3b8; font-size: 0.9rem;">Contact</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="mb-3" style="color: #e2e8f0;">Connect</h6>
                    <div class="social-links">
                        @if($profile->socialLinks ?? null)
                            @foreach($profile->socialLinks as $link)
                                <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                &copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. Crafted with care.
            </div>
        </div>
    </footer>

    <button class="mod-back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
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

        document.querySelectorAll('.mod-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        const sections = document.querySelectorAll('.mod-section[id]');
        const navLinks = document.querySelectorAll('.mod-nav .nav-link');
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
