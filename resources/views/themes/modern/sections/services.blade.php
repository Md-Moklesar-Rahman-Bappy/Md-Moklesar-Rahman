@php
    $services = $data['services'] ?? ($profile->services ?? collect());
@endphp

<section id="services" class="mod-section mod-section-alt">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Services</span>
            <h2>What I Offer</h2>
            <p>Professional services tailored to bring your ideas to life.</p>
        </div>

        @if($services && count($services))
            <div class="row">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="mod-card text-center">
                            <div class="mod-icon-circle mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                                <i class="bi bi-{{ $service->icon ?? $service['icon'] ?? 'gear' }}"></i>
                            </div>
                            <h5 style="font-size: 1.05rem; margin-bottom: 0.75rem;">{{ $service->title ?? $service['title'] ?? '' }}</h5>
                            <p style="color: var(--mod-text); font-size: 0.9rem;">{{ $service->description ?? $service['description'] ?? '' }}</p>
                            @if($service->price ?? $service['price'] ?? null)
                                <div style="margin-top: 1rem; font-size: 1.25rem; font-weight: 700; color: var(--mod-primary);">
                                    From ${{ $service->price ?? $service['price'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--mod-text);">Services information coming soon.</p>
            </div>
        @endif
    </div>
</section>
