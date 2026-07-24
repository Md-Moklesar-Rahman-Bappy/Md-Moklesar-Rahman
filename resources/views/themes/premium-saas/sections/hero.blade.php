<section id="hero" class="d-flex align-items-center position-relative" style="min-height: 100vh; background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 50%, #06b6d4 100%); overflow: hidden;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.1;">
        <div class="position-absolute" style="top: 10%; left: 5%; width: 400px; height: 400px; background: #fff; border-radius: 50%; filter: blur(80px);"></div>
        <div class="position-absolute" style="bottom: 10%; right: 10%; width: 300px; height: 300px; background: #fff; border-radius: 50%; filter: blur(80px);"></div>
    </div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-up">
                <div class="glass d-inline-block px-4 py-2 mb-4">
                    <span class="text-white small fw-medium"><i class="bi bi-sparkles me-2"></i>{{ $profile->designation ?? 'Innovation Starts Here' }}</span>
                </div>
                <h1 class="display-3 fw-900 text-white mb-4" style="line-height: 1.1; letter-spacing: -1px;">
                    {{ $profile->full_name ?? '' }}
                </h1>
                <p class="lead text-white-50 mb-5" style="max-width: 550px; font-weight: 300;">{{ $profile->tagline ?? '' }}</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#contact" class="btn btn-saas" style="background: #fff; color: var(--primary);">Start a Project <i class="bi bi-arrow-right ms-2"></i></a>
                    <a href="#features" class="btn btn-saas-outline">Explore Features</a>
                </div>
                <div class="d-flex gap-5 mt-5">
                    <div class="glass px-4 py-3 text-center">
                        <h4 class="text-white fw-bold mb-0">{{ $profile->experience_years ?? '0' }}+</h4>
                        <small class="text-white-50">Years Exp</small>
                    </div>
                    <div class="glass px-4 py-3 text-center">
                        <h4 class="text-white fw-bold mb-0">{{ count($profile->projects ?? []) }}+</h4>
                        <small class="text-white-50">Projects</small>
                    </div>
                    <div class="glass px-4 py-3 text-center">
                        <h4 class="text-white fw-bold mb-0">{{ count($profile->testimonials ?? []) }}+</h4>
                        <small class="text-white-50">Clients</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-5 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
                @if($profile->profile_image)
                <div class="glass p-3 d-inline-block">
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->full_name }}" class="rounded-4" style="max-width: 380px; width: 100%;">
                </div>
                @else
                <div class="glass p-5 d-inline-block">
                    <i class="bi bi-person-fill text-white" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#fff"/></svg>
    </div>
</section>
