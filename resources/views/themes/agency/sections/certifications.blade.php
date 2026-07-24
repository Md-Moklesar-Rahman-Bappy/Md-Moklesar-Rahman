<section id="certifications" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Certifications</h2>
            <p class="section-subtitle mx-auto">Professional certifications and achievements</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->certifications ?? [] as $cert)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="bg-white rounded-4 p-4 d-flex align-items-start gap-3 h-100" style="box-shadow: 0 5px 20px rgba(0,0,0,0.04);">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--accent), #fbbf24); color: #fff;">
                        <i class="bi bi-award-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $cert->name ?? '' }}</h6>
                        <p class="text-muted small mb-1">{{ $cert->issuer ?? '' }}</p>
                        <small class="text-muted">{{ $cert->date ?? '' }}</small>
                        @if($cert->url)
                        <div class="mt-2">
                            <a href="{{ $cert->url }}" class="small" style="color: var(--primary);" target="_blank">View Certificate <i class="bi bi-arrow-right"></i></a>
                        </div>
                        @endif
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
