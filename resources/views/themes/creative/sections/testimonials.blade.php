@php
    $testimonials = $data['testimonials'] ?? ($profile->testimonials ?? collect());
@endphp

<section id="testimonials" class="cre-section cre-section-alt">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-chat-quote"></i> Testimonials</span>
            <h2>Client Reviews</h2>
            <p>What my clients say about working with me.</p>
        </div>

        @if($testimonials && count($testimonials))
            <div class="row">
                @foreach($testimonials as $testimonial)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="cre-card h-100 d-flex flex-column">
                            <div class="mb-3">
                                <i class="bi bi-quote" style="font-size: 2.5rem; background: var(--cre-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                            </div>
                            <p style="color: var(--cre-text); font-style: italic; flex-grow: 1; font-size: 0.95rem; line-height: 1.8;">
                                "{{ $testimonial->content ?? $testimonial['content'] ?? '' }}"
                            </p>
                            <div class="d-flex align-items-center gap-3 mt-3 pt-3" style="border-top: 1px solid rgba(0,0,0,0.06);">
                                @if($testimonial->avatar ?? $testimonial['avatar'] ?? null)
                                    <img src="{{ $testimonial->avatar ?? $testimonial['avatar'] }}" alt=""
                                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 3px solid transparent; background: var(--cre-gradient); background-clip: padding-box;">
                                @else
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--cre-gradient); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.1rem;">
                                        {{ substr($testimonial->name ?? $testimonial['name'] ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <strong style="font-weight: 700;">{{ $testimonial->name ?? $testimonial['name'] ?? '' }}</strong>
                                    <p style="color: var(--cre-primary); font-size: 0.8rem; margin: 0; font-weight: 500;">
                                        {{ $testimonial->position ?? $testimonial['position'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--cre-text);">Testimonials coming soon.</p>
            </div>
        @endif
    </div>
</section>
