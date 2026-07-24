@php
    $services = $data['services'] ?? ($profile->services ?? collect());
@endphp

<section id="services" class="cre-section">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-gem"></i> Services</span>
            <h2>What I Offer</h2>
            <p>Creative services to elevate your digital presence.</p>
        </div>

        @if($services && count($services))
            <div class="row">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="cre-card text-center">
                            <div class="cre-icon-blob">
                                <i class="bi bi-{{ $service->icon ?? $service['icon'] ?? 'star' }}"></i>
                            </div>
                            <h5 style="font-weight: 700; margin-bottom: 0.75rem;">{{ $service->title ?? $service['title'] ?? '' }}</h5>
                            <p style="color: var(--cre-text); font-size: 0.9rem;">{{ $service->description ?? $service['description'] ?? '' }}</p>
                            @if($service->price ?? $service['price'] ?? null)
                                <div style="margin-top: 1rem; font-size: 1.25rem; font-weight: 800;" class="cre-gradient-text">
                                    From ${{ $service->price ?? $service['price'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--cre-text);">Services coming soon.</p>
            </div>
        @endif
    </div>
</section>
