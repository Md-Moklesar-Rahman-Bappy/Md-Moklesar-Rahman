@php
    $services = $data['services'] ?? ($profile->services ?? collect());
@endphp

<section id="services" class="dev-section">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// services_offered</span>
            <h2><span style="color: var(--dev-primary);">#</span> Services</h2>
        </div>

        @if($services && count($services))
            <div class="row">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-card h-100 text-center p-4">
                            <div style="width: 70px; height: 70px; margin: 0 auto 1.5rem; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" class="service-icon">
                                <i class="bi bi-{{ $service->icon ?? $service['icon'] ?? 'gear' }}" style="color: var(--dev-primary); font-size: 1.5rem;"></i>
                            </div>
                            <h5 style="color: var(--dev-heading); font-size: 1rem;">{{ $service->title ?? $service['title'] ?? '' }}</h5>
                            <p style="color: #94a3b8; font-size: 0.85rem;">{{ $service->description ?? $service['description'] ?? '' }}</p>
                            @if($service->price ?? $service['price'] ?? null)
                                <div style="color: var(--dev-primary); font-size: 1.25rem; font-weight: 700; margin-top: 1rem;">
                                    <span class="dev-keyword">from</span> ${{ $service->price ?? $service['price'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="dev-terminal" style="max-width: 400px; margin: 0 auto;">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                    </div>
                    <div class="dev-terminal-body text-center">
                        <span class="dev-comment">// services loading...</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
