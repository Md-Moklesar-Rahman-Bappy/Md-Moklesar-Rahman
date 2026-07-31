<section id="certifications" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Certifications</h2>
                <p class="section-subtitle">Credentials and achievements</p>
                @foreach($profile->certifications ?? [] as $cert)
                <div class="min-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-semibold mb-1">{{ $cert->name ?? '' }}</h5>
                            <p class="text-muted small mb-0">{{ $cert->organization ?? '' }}</p>
                        </div>
                        <small class="text-muted">{{ $cert->issue_date ?? '' }}</small>
                    </div>
                    @if($cert->verification_url)
                    <div class="mt-2">
                        <a href="{{ $cert->verification_url }}" class="min-link small" target="_blank">View credential <i class="bi bi-arrow-up-right" style="font-size: 0.7rem;"></i></a>
                    </div>
                    @endif
                </div>
                @endforeach
                @if(empty($profile->certifications))
                <p class="text-muted">Certifications coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
