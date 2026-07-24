<section id="testimonials" class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Testimonials</h2>
                <p class="section-subtitle">Kind words from people I've worked with</p>
                @foreach($profile->testimonials ?? [] as $testimonial)
                <div class="min-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <p class="mb-3" style="font-size: 0.95rem; font-style: italic; color: var(--secondary);">"{{ $testimonial->content ?? '' }}"</p>
                    <div class="d-flex align-items-center">
                        @if($testimonial->avatar)
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" class="rounded-circle me-3" style="width: 36px; height: 36px; object-fit: cover; filter: grayscale(30%);">
                        @else
                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #f3f4f6; font-size: 0.75rem; font-weight: 600; color: var(--text-dark);">
                            {{ strtoupper(substr($testimonial->name ?? 'U', 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <small class="fw-semibold">{{ $testimonial->name ?? '' }}</small>
                            <small class="text-muted ms-1">{{ $testimonial->position ?? '' }}{{ $testimonial->company ? ', ' . $testimonial->company : '' }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
                @if(empty($profile->testimonials))
                <p class="text-muted">Testimonials coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
