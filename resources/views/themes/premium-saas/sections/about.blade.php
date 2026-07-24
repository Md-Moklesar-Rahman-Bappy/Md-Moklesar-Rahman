<section id="about" class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">About Me</span>
                <h2 class="section-title">Building Digital Experiences That Matter</h2>
                <p class="section-subtitle">Innovative solutions for modern challenges</p>
                @foreach($profile->aboutSections ?? [] as $section)
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $section->title ?? '' }}</h5>
                    <p class="text-muted">{{ $section->content ?? '' }}</p>
                </div>
                @endforeach
                @if(!empty($profile->aboutSections) && count($profile->aboutSections) === 0)
                <p class="text-muted">{{ $profile->bio ?? '' }}</p>
                @endif
                <div class="row g-3 mt-4">
                    <div class="col-4">
                        <div class="p-3 rounded-4" style="background: linear-gradient(135deg, rgba(124,58,237,0.05), rgba(59,130,246,0.05));">
                            <h3 class="fw-bold mb-0" style="color: var(--primary);">{{ $profile->experience_years ?? '0' }}+</h3>
                            <small class="text-muted">Years Experience</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-4" style="background: linear-gradient(135deg, rgba(59,130,246,0.05), rgba(6,182,212,0.05));">
                            <h3 class="fw-bold mb-0" style="color: var(--secondary);">{{ count($profile->projects ?? []) }}+</h3>
                            <small class="text-muted">Projects Done</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded-4" style="background: linear-gradient(135deg, rgba(6,182,212,0.05), rgba(124,58,237,0.05));">
                            <h3 class="fw-bold mb-0" style="color: var(--accent);">{{ count($profile->testimonials ?? []) }}+</h3>
                            <small class="text-muted">Happy Clients</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="position-relative">
                    <div class="rounded-4" style="background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(59,130,246,0.1)); height: 450px;"></div>
                    @if($profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="About" class="position-absolute top-50 start-50 translate-middle rounded-4 shadow-lg" style="width: 85%; height: 400px; object-fit: cover;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
