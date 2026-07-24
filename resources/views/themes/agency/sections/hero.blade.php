<section id="hero" class="d-flex align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, var(--primary) 0%, var(--bg-dark) 100%); position: relative; overflow: hidden;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.05;">
        <div class="position-absolute" style="top: 20%; left: 10%; width: 300px; height: 300px; border: 2px solid #fff; border-radius: 50%;"></div>
        <div class="position-absolute" style="bottom: 10%; right: 15%; width: 200px; height: 200px; border: 2px solid #fff; border-radius: 50%;"></div>
    </div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <p class="text-white-50 mb-3 fw-semibold" style="letter-spacing: 3px; text-transform: uppercase; font-size: 0.9rem;">{{ $profile->designation ?? 'Welcome' }}</p>
                <h1 class="display-3 fw-800 text-white mb-4" style="line-height: 1.1;">
                    Hi, I'm<br>
                    <span style="color: var(--accent);">{{ $profile->full_name ?? '' }}</span>
                </h1>
                <p class="lead text-white-50 mb-4">{{ $profile->tagline ?? '' }}</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#contact" class="btn btn-agency">Get In Touch</a>
                    <a href="#projects" class="btn btn-agency-outline">View Projects</a>
                </div>
                <div class="d-flex gap-4 mt-5">
                    @foreach($profile->socialLinks ?? [] as $link)
                    <a href="{{ $link->url }}" class="text-white-50 fs-4" style="transition: color 0.3s;" target="_blank" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color=''"><i class="bi bi-{{ $link->platform }}"></i></a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0" data-aos="fade-left">
                @if($profile->profile_image)
                <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->full_name }}" class="img-fluid rounded-circle shadow-lg" style="max-width: 400px; border: 6px solid rgba(255,255,255,0.1);">
                @else
                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 400px; height: 400px; background: rgba(255,255,255,0.05); border: 6px solid rgba(255,255,255,0.1);">
                    <i class="bi bi-person-fill text-white" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="var(--bg-light)"/></svg>
    </div>
</section>
