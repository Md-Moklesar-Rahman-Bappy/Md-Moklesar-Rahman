@php
    $services = $data['services'] ?? ($profile->services ?? collect());
@endphp

<section id="services" class="fre-section">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-gear"></i> Services</span>
            <h2>What I Offer</h2>
            <p>Professional freelance services tailored to your needs.</p>
        </div>

        @if($services && count($services))
            <div class="row">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="fre-pricing-card {{ $loop->first ? 'featured' : '' }}">
                            <div class="fre-icon-box">
                                <i class="bi bi-{{ $service->icon ?? $service['icon'] ?? 'star' }}"></i>
                            </div>
                            <h5 style="text-align: center; font-weight: 700; margin-bottom: 0.75rem;">{{ $service->title ?? $service['title'] ?? '' }}</h5>
                            <p style="color: var(--fre-text); text-align: center; font-size: 0.9rem; margin-bottom: 1.5rem;">
                                {{ $service->description ?? $service['description'] ?? '' }}
                            </p>

                            @if($service->price ?? $service['price'] ?? null)
                                <div style="text-align: center; margin-bottom: 1.5rem;">
                                    <span style="font-size: 2.5rem; font-weight: 800; color: var(--fre-primary);">${{ $service->price ?? $service['price'] }}</span>
                                    <span style="color: var(--fre-text); font-size: 0.9rem;">/project</span>
                                </div>
                            @endif

                            <div class="text-center">
                                <a href="#contact" class="fre-btn {{ $loop->first ? '' : 'fre-btn-outline' }}" style="width: 100%; justify-content: center;">
                                    <i class="bi bi-chat-dots"></i> Get Started
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Services coming soon.</p>
            </div>
        @endif
    </div>
</section>
