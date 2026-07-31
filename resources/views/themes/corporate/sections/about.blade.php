<section id="about" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="corp-divider"></div>
                <h2 class="section-title">About Me</h2>
                <p class="section-subtitle">Professional Overview</p>
                @if($profile->profile_image)
                <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="About" class="img-fluid mb-4" style="border: 3px solid #e2e8f0;">
                @endif
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold" style="color: var(--primary);">{{ $profile->experience_years ?? '0' }}+</h3>
                        <small class="text-muted">Years Experience</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold" style="color: var(--primary);">{{ count($profile->projects ?? []) }}+</h3>
                        <small class="text-muted">Projects</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold" style="color: var(--primary);">{{ count($profile->testimonials ?? []) }}+</h3>
                        <small class="text-muted">Clients</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 mt-4 mt-lg-0" data-aos="fade-left">
                <h4 class="fw-bold mb-3">Professional Summary</h4>
                @foreach($profile->aboutSections ?? [] as $section)
                <div class="mb-4">
                    <h6 class="fw-bold text-uppercase" style="letter-spacing: 1px; color: var(--primary);">{{ $section->heading ?? $section->title ?? '' }}</h6>
                    <p class="text-muted">{{ $section->content ?? '' }}</p>
                </div>
                @endforeach
                @if(!empty($profile->aboutSections) && count($profile->aboutSections) === 0)
                <p class="text-muted">{{ $profile->bio ?? '' }}</p>
                @endif
                <div class="row g-3 mt-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white border">
                            <i class="bi bi-check-circle-fill me-3" style="color: var(--primary);"></i>
                            <span class="small fw-medium">Professional Development</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white border">
                            <i class="bi bi-check-circle-fill me-3" style="color: var(--primary);"></i>
                            <span class="small fw-medium">Quality Driven Results</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white border">
                            <i class="bi bi-check-circle-fill me-3" style="color: var(--primary);"></i>
                            <span class="small fw-medium">Client Focused Approach</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white border">
                            <i class="bi bi-check-circle-fill me-3" style="color: var(--primary);"></i>
                            <span class="small fw-medium">Strategic Problem Solver</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
