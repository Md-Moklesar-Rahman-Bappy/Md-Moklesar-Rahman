<section id="services" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Services</span>
            <h2 class="section-title">What I Offer</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Comprehensive solutions tailored to your business needs</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->services ?? [] as $index => $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="pricing-card h-100 {{ $index === 1 ? 'popular' : '' }}">
                    <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(59,130,246,0.1)); color: var(--primary);">
                        <i class="bi bi-{{ $service->icon ?? 'gear' }}"></i>
                    </div>
                    <h5 class="fw-bold">{{ $service->title ?? '' }}</h5>
                    <p class="text-muted small mb-4">{{ $service->description ?? '' }}</p>
                    @if($service->price)
                    <div class="mb-4">
                        <span class="display-6 fw-bold" style="color: var(--primary);">${{ $service->price }}</span>
                        <span class="text-muted">/project</span>
                    </div>
                    @endif
                    <a href="#contact" class="btn btn-saas-dark w-100 rounded-pill">Get Started</a>
                </div>
            </div>
            @endforeach
            @if(empty($profile->services))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <p class="text-muted">Services coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
