@php
    $testimonials = $data['testimonials'] ?? ($profile->testimonials ?? collect());
@endphp

<section id="testimonials" class="fre-section fre-section-alt">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-chat-quote"></i> Testimonials</span>
            <h2>Client Reviews</h2>
            <p>What my happy clients say about my work.</p>
        </div>

        @if($testimonials && count($testimonials))
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach($testimonials as $testimonial)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="fre-card text-center p-5">
                                        <div class="mb-3">
                                            @for($i = 0; $i < 5; $i++)
                                                <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 1rem;"></i>
                                            @endfor
                                        </div>
                                        <p style="font-size: 1.1rem; font-style: italic; color: var(--fre-text); line-height: 1.9; margin-bottom: 1.5rem;">
                                            "{{ $testimonial->content ?? $testimonial['content'] ?? '' }}"
                                        </p>
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            @if($testimonial->avatar ?? $testimonial['avatar'] ?? null)
                                                <img src="{{ $testimonial->avatar ?? $testimonial['avatar'] }}" alt=""
                                                     style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 3px solid var(--fre-primary);">
                                            @else
                                                <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--fre-warm); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.2rem; border: 3px solid var(--fre-primary);">
                                                    {{ substr($testimonial->name ?? $testimonial['name'] ?? 'U', 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="text-start">
                                                <strong style="font-size: 1rem;">{{ $testimonial->name ?? $testimonial['name'] ?? '' }}</strong>
                                                <p style="color: var(--fre-primary); font-size: 0.85rem; margin: 0; font-weight: 500;">
                                                    {{ $testimonial->position ?? $testimonial['position'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(count($testimonials) > 1)
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button class="btn" style="width: 44px; height: 44px; border-radius: 50%; background: rgba(37,99,235,0.08); color: var(--fre-primary);" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <button class="btn" style="width: 44px; height: 44px; border-radius: 50%; background: var(--fre-primary); color: #fff;" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Testimonials coming soon.</p>
            </div>
        @endif
    </div>
</section>
