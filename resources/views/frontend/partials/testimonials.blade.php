@php
    $testimonials = $profile->testimonials ?? collect();
@endphp

<section id="testimonials" class="dev-section dev-section-alt">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// client_reviews</span>
            <h2><span style="color: var(--dev-primary);">#</span> Testimonials</h2>
        </div>

        @if($testimonials && count($testimonials))
            <div class="row">
                @foreach($testimonials as $testimonial)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-card h-100 d-flex flex-column">
                            <div class="mb-3">
                                <i class="bi bi-quote" style="font-size: 2rem; color: var(--dev-primary); opacity: 0.5;"></i>
                            </div>
                            <p style="color: #94a3b8; font-size: 0.9rem; flex-grow: 1; font-style: italic;">
                                "{{ $testimonial->review }}"
                            </p>
                            <div class="d-flex align-items-center gap-3 mt-3 pt-3" style="border-top: 1px solid var(--dev-border);">
                                @if($testimonial->profile_image)
                                    <img src="{{ asset('storage/' . $testimonial->profile_image) }}" alt=""
                                         style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--dev-border);">
                                @else
                                    <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="color: var(--dev-primary);"></i>
                                    </div>
                                @endif
                                <div>
                                    <strong style="color: var(--dev-heading); font-size: 0.9rem;">
                                        {{ $testimonial->client_name }}
                                    </strong>
                                    <p style="color: var(--dev-primary); font-size: 0.8rem; margin: 0;">
                                        {{ $testimonial->position ?? ($testimonial->company ?? '') }}
                                    </p>
                                </div>
                            </div>
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
                        <span class="dev-comment">// testimonials.fetch() pending</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
