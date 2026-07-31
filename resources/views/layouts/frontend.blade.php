<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $profile->full_name ?? 'Portfolio' }} - {{ $profile->tagline ?? 'Developer Portfolio' }}">
    <title>@yield('page_title', ($profile->full_name ?? 'Portfolio') . ' | Portfolio')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --dev-primary: #10b981;
            --dev-secondary: #06b6d4;
            --dev-accent: #f59e0b;
            --dev-bg: #0f172a;
            --dev-bg-alt: #1e293b;
            --dev-text: #e2e8f0;
            --dev-heading: #f8fafc;
            --dev-border: #334155;
            --dev-glow: rgba(16, 185, 129, 0.15);
            --dev-font: 'JetBrains Mono', monospace;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--dev-font);
            background-color: var(--dev-bg);
            color: var(--dev-text);
            line-height: 1.7;
            font-size: 14px;
            overflow-x: hidden;
        }

        ::selection {
            background: var(--dev-primary);
            color: var(--dev-bg);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--dev-bg); }
        ::-webkit-scrollbar-thumb { background: var(--dev-border); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--dev-primary); }

        h1, h2, h3, h4, h5, h6 {
            color: var(--dev-heading);
            font-family: var(--dev-font);
            font-weight: 600;
        }

        a { color: var(--dev-primary); text-decoration: none; transition: all 0.3s ease; }
        a:hover { color: var(--dev-secondary); text-shadow: 0 0 8px var(--dev-glow); }

        .dev-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--dev-border);
            padding: 0.75rem 0;
            transition: all 0.3s ease;
        }

        .dev-nav .nav-brand {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dev-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dev-nav .nav-brand::before { content: '>_ '; opacity: 0.5; }

        .dev-nav .nav-link {
            color: var(--dev-text);
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dev-nav .nav-link::before {
            content: '//';
            color: var(--dev-primary);
            opacity: 0.5;
            margin-right: 0.25rem;
        }

        .dev-nav .nav-link:hover,
        .dev-nav .nav-link.active {
            color: var(--dev-primary);
        }

        .dev-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background: var(--dev-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .dev-nav .nav-link:hover::after,
        .dev-nav .nav-link.active::after {
            transform: scaleX(1);
        }

        .dev-section {
            padding: 6rem 0;
            position: relative;
        }

        .dev-section-alt {
            background: var(--dev-bg-alt);
        }

        .dev-section-header {
            margin-bottom: 3.5rem;
        }

        .dev-section-header .section-label {
            color: var(--dev-primary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 0.5rem;
            display: block;
        }

        .dev-section-header h2 {
            font-size: 2rem;
            position: relative;
            display: inline-block;
        }

        .dev-section-header h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--dev-primary);
            margin-top: 0.75rem;
        }

        .dev-card {
            background: var(--dev-bg-alt);
            border: 1px solid var(--dev-border);
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dev-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 8px;
            padding: 1px;
            background: linear-gradient(135deg, var(--dev-primary), transparent, var(--dev-secondary));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dev-card:hover::before { opacity: 1; }

        .dev-card:hover {
            box-shadow: 0 0 20px var(--dev-glow), 0 8px 32px rgba(0, 0, 0, 0.3);
            transform: translateY(-4px);
        }

        .dev-terminal {
            background: #1a1a2e;
            border: 1px solid var(--dev-border);
            border-radius: 8px;
            overflow: hidden;
        }

        .dev-terminal-header {
            background: var(--dev-border);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dev-terminal-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dev-terminal-dot:nth-child(1) { background: #ef4444; }
        .dev-terminal-dot:nth-child(2) { background: #f59e0b; }
        .dev-terminal-dot:nth-child(3) { background: #10b981; }

        .dev-terminal-body {
            padding: 1.5rem;
            font-size: 0.9rem;
        }

        .dev-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: transparent;
            border: 1px solid var(--dev-primary);
            color: var(--dev-primary);
            font-family: var(--dev-font);
            font-size: 0.85rem;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dev-btn:hover {
            background: var(--dev-primary);
            color: var(--dev-bg);
            box-shadow: 0 0 20px var(--dev-glow);
        }

        .dev-btn-filled {
            background: var(--dev-primary);
            color: var(--dev-bg);
        }

        .dev-btn-filled:hover {
            background: transparent;
            color: var(--dev-primary);
        }

        .dev-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--dev-primary);
            border-radius: 4px;
            font-size: 0.75rem;
            margin: 0.25rem;
        }

        .dev-comment {
            color: #64748b;
            font-style: italic;
        }

        .dev-keyword { color: #c084fc; }
        .dev-string { color: #34d399; }
        .dev-function { color: #60a5fa; }
        .dev-number { color: #f59e0b; }

        .dev-footer {
            background: var(--dev-bg-alt);
            border-top: 1px solid var(--dev-border);
            padding: 3rem 0 1.5rem;
        }

        .dev-footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid var(--dev-border);
            border-radius: 4px;
            color: var(--dev-text);
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .dev-footer .social-links a:hover {
            border-color: var(--dev-primary);
            color: var(--dev-primary);
            box-shadow: 0 0 10px var(--dev-glow);
        }

        .dev-footer .copyright {
            color: #64748b;
            font-size: 0.8rem;
            border-top: 1px solid var(--dev-border);
            padding-top: 1.5rem;
            margin-top: 2rem;
        }

        .dev-back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 44px;
            height: 44px;
            background: var(--dev-primary);
            color: var(--dev-bg);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .dev-back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .dev-back-to-top:hover {
            box-shadow: 0 0 20px var(--dev-glow);
            transform: translateY(-2px);
        }

        .dev-cursor-blink::after {
            content: '|';
            animation: blink 1s step-end infinite;
            color: var(--dev-primary);
        }

        @keyframes blink {
            50% { opacity: 0; }
        }

        @keyframes typewriter {
            from { width: 0; }
            to { width: 100%; }
        }

        .dev-glow-text {
            text-shadow: 0 0 10px var(--dev-glow), 0 0 20px var(--dev-glow);
        }

        .dev-page-body {
            padding-top: 65px;
            min-height: 100vh;
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="dev-nav" id="mainNav">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="nav-brand">{{ $profile->full_name ?? 'dev' }}</a>
                <div class="d-none d-lg-flex align-items-center gap-1">
                    <a href="{{ route('home') }}#about" class="nav-link">About</a>
                    <a href="{{ route('home') }}#skills" class="nav-link">Skills</a>
                    <a href="{{ route('home') }}#experience" class="nav-link">Experience</a>
                    <a href="{{ route('home') }}#projects" class="nav-link">Projects</a>
                    <a href="{{ route('home.blog') }}" class="nav-link">Blog</a>
                    <a href="{{ route('home.contact') }}" class="nav-link">Contact</a>
                </div>
                <button class="btn btn-sm d-lg-none" style="color: var(--dev-primary); border: 1px solid var(--dev-border);" onclick="document.querySelector('.dev-nav-links').classList.toggle('d-none')">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            <div class="dev-nav-links d-lg-none d-none mt-3">
                <a href="{{ route('home') }}#about" class="nav-link d-block py-2">About</a>
                <a href="{{ route('home') }}#skills" class="nav-link d-block py-2">Skills</a>
                <a href="{{ route('home') }}#experience" class="nav-link d-block py-2">Experience</a>
                <a href="{{ route('home') }}#projects" class="nav-link d-block py-2">Projects</a>
                <a href="{{ route('home.blog') }}" class="nav-link d-block py-2">Blog</a>
                <a href="{{ route('home.contact') }}" class="nav-link d-block py-2">Contact</a>
            </div>
        </div>
    </nav>

    <main class="dev-page-body">
        @yield('content')
    </main>

    <footer class="dev-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5 style="color: var(--dev-primary);" class="mb-3">{{ $profile->full_name ?? '' }}</h5>
                    <p style="color: #94a3b8;">{{ $profile->tagline ?? '' }}</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <div class="social-links mt-3 mt-lg-0">
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
                <span class="dev-comment">// &copy; {{ date('Y') }} {{ $profile->full_name ?? '' }}. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <button class="dev-back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.scrollY > 300);
        });

        document.querySelectorAll('.dev-nav .nav-link[href*="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const hash = href.split('#')[1];
                if (!hash) return;
                const target = document.querySelector('#' + hash);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        const sections = document.querySelectorAll('.dev-section[id]');
        const navLinks = document.querySelectorAll('.dev-nav .nav-link');
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
