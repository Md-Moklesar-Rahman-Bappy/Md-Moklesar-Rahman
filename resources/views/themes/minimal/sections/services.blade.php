<section id="services" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Services</h2>
                <p class="section-subtitle">What I can do for you</p>
                @foreach($profile->services ?? [] as $service)
                <div class="min-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <span class="d-inline-block text-muted" style="font-size: 1.2rem;">
                                @if($service->icon)
                                <i class="bi bi-{{ $service->icon }}"></i>
                                @else
                                <i class="bi bi-arrow-right"></i>
                                @endif
                            </span>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-1">{{ $service->title ?? '' }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $service->description ?? '' }}</p>
                            @if($service->price)
                            <p class="mt-2 mb-0 fw-medium" style="font-size: 0.85rem;">${{ $service->price }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @if(empty($profile->services))
                <p class="text-muted">Services coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
