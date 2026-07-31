<section id="certifications" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Certifications</span>
            <h2 class="section-title">Professional Credentials</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Verified achievements and industry certifications</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->certifications ?? [] as $cert)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, rgba(251,191,36,0.15), rgba(245,158,11,0.1)); color: #f59e0b;">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <h6 class="fw-bold">{{ $cert->name ?? '' }}</h6>
                    <p class="text-muted small mb-1">{{ $cert->organization ?? '' }}</p>
                    <small class="text-muted">{{ format_date($cert->issue_date) }}</small>
                    @if($cert->verification_url)
                    <div class="mt-3">
                        <a href="{{ $cert->verification_url }}" class="btn btn-sm btn-saas-dark rounded-pill" style="font-size: 0.8rem;" target="_blank">View Credential</a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @if(empty($profile->certifications))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <p class="text-muted">Certifications coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
