@php
    $testimonials = $data['testimonials'] ?? ($profile->testimonials ?? collect());
@endphp

<section id="testimonials" class="mod-section">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Testimonials</span>
            <h2>Client Reviews</h2>
            <p>What people say about working with me.</p>
        </div>

        @if($testimonials && count($testimonials))
            <div class="row">
                @foreach($testimonials as $testimonial)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="mod-card h-100 d-flex flex-column">
                            <div class="mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 0.85rem;"></i>
                                @endfor
                            </div>
                            <p style="color: var(--mod-text); font-style: italic; flex-grow: 1; font-size: 0.95rem;">
                                "{{ $testimonial->content ?? $testimonial['content'] ?? '' }}"
                            </p>
                            <div class="d-flex align-items-center gap-3 mt-3 pt-3" style="border-top: 1px solid rgba(0,0,0,0.06);">
                                @if($testimonial->avatar ?? $testimonial['avatar'] ?? null)
                                    <img src="{{ $testimonial->avatar ?? $testimonial['avatar'] }}" alt=""
                                         style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--mod-gradient); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1rem;">
                                        {{ substr($testimonial->name ?? $testimonial['name'] ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <strong style="font-size: 0.95rem;">{{ $testimonial->name ?? $testimonial['name'] ?? '' }}</strong>
                                    <p style="color: var(--mod-primary); font-size: 0.8rem; margin: 0;">{{ $testimonial->position ?? $testimonial['position'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--mod-text);">Testimonials coming soon.</p>
            </div>
        @endif
    </div>
</section>
