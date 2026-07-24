<section id="hero" class="d-flex align-items-center" style="min-height: 100vh; background: var(--bg-dark);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <p class="text-uppercase fw-bold mb-3" style="color: var(--accent); letter-spacing: 3px; font-size: 0.85rem;">{{ $profile->designation ?? 'Professional' }}</p>
                <h1 class="display-4 fw-900 text-white mb-3" style="line-height: 1.15;">
                    {{ $profile->full_name ?? '' }}
                </h1>
                <p class="lead text-white-50 mb-4" style="max-width: 550px;">{{ $profile->tagline ?? '' }}</p>
                <div class="d-flex gap-3">
                    <a href="#contact" class="btn btn-corp">Contact Me</a>
                    <a href="#experience" class="btn btn-outline-light" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem;">My Experience</a>
                </div>
                <div class="d-flex gap-4 mt-5 pt-3 border-top border-secondary" style="max-width: 500px;">
                    <div>
                        <h4 class="text-white fw-bold mb-0">{{ $profile->experience_years ?? '0' }}+</h4>
                        <small class="text-white-50">Years Experience</small>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">{{ count($profile->projects ?? []) }}+</h4>
                        <small class="text-white-50">Projects Completed</small>
                    </div>
                    <div>
                        <h4 class="text-white fw-bold mb-0">{{ count($profile->testimonials ?? []) }}+</h4>
                        <small class="text-white-50">Clients Served</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-5 mt-lg-0" data-aos="fade-left">
                @if($profile->profile_image)
                <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->full_name }}" class="img-fluid" style="max-width: 380px; border: 4px solid var(--accent);">
                @else
                <div class="mx-auto d-flex align-items-center justify-content-center" style="width: 350px; height: 380px; background: rgba(255,255,255,0.05); border: 4px solid var(--accent);">
                    <i class="bi bi-person-fill text-white" style="font-size: 6rem; opacity: 0.2;"></i>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
