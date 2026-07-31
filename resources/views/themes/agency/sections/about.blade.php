<section id="about" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="agency-line"></div>
                <h2 class="section-title">About Me</h2>
                <p class="section-subtitle">Passionate about creating impactful digital experiences</p>
                @foreach($profile->aboutSections ?? [] as $section)
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $section->heading ?? $section->title ?? '' }}</h5>
                    <p class="text-muted">{{ $section->content ?? '' }}</p>
                </div>
                @endforeach
                @if(!empty($profile->aboutSections) && count($profile->aboutSections) === 0)
                <p class="text-muted lead">{{ $profile->bio ?? '' }}</p>
                @endif
                <div class="d-flex gap-5 mt-4">
                    <div>
                        <h3 class="fw-800" style="color: var(--primary);">{{ $profile->experience_years ?? '0' }}+</h3>
                        <p class="text-muted mb-0">Years Experience</p>
                    </div>
                    <div>
                        <h3 class="fw-800" style="color: var(--primary);">{{ count($profile->projects ?? []) }}+</h3>
                        <p class="text-muted mb-0">Projects Done</p>
                    </div>
                    <div>
                        <h3 class="fw-800" style="color: var(--primary);">{{ count($profile->testimonials ?? []) }}+</h3>
                        <p class="text-muted mb-0">Happy Clients</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="position-relative">
                    <div class="bg-primary-subtle rounded-4" style="width: 100%; height: 450px;"></div>
                    @if($profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="About" class="position-absolute top-50 start-50 translate-middle rounded-4 shadow" style="width: 90%; height: 400px; object-fit: cover;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
