<section id="certifications" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="corp-divider mx-auto"></div>
            <h2 class="section-title">Certifications</h2>
            <p class="section-subtitle mx-auto">Professional credentials and qualifications</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->certifications ?? [] as $cert)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="corp-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: var(--primary); color: #fff;">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ $cert->name ?? '' }}</h6>
                            <p class="text-muted small mb-1">{{ $cert->organization ?? '' }}</p>
                            <small class="text-muted">{{ $cert->issue_date ?? '' }}</small>
                            @if($cert->verification_url)
                            <div class="mt-2">
                                <a href="{{ $cert->verification_url }}" class="small fw-medium" style="color: var(--primary);" target="_blank">Verify <i class="bi bi-arrow-right"></i></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->certifications))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <i class="bi bi-award fs-1 text-muted"></i>
                <p class="text-muted mt-3">Certifications coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
