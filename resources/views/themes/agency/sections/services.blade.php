<section id="services" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Services I Offer</h2>
            <p class="section-subtitle mx-auto">Comprehensive solutions tailored to your needs</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->services ?? [] as $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="bi bi-{{ $service->icon ?? 'gear' }}"></i>
                    </div>
                    <h5 class="fw-bold">{{ $service->title ?? '' }}</h5>
                    <p class="text-muted">{{ $service->description ?? '' }}</p>
                    @if($service->price)
                    <p class="fw-bold mt-3" style="color: var(--primary); font-size: 1.2rem;">Starting at ${{ $service->price }}</p>
                    @endif
                </div>
            </div>
            @endforeach
            @if(empty($profile->services))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <i class="bi bi-hexagon fs-1 text-muted"></i>
                <p class="text-muted mt-3">Services coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
