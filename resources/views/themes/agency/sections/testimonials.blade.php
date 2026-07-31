<section id="testimonials" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Client Testimonials</h2>
            <p class="section-subtitle mx-auto">What my clients say about working with me</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->testimonials ?? [] as $testimonial)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="testimonial-card h-100">
                    <div class="d-flex align-items-center mb-3">
                        @for($i = 0; $i < 5; $i++)
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        @endfor
                    </div>
                    <p class="text-muted mb-4">{{ $testimonial->review ?? '' }}</p>
                    <div class="d-flex align-items-center">
                        @if($testimonial->profile_image)
                        <img src="{{ asset('storage/' . $testimonial->profile_image) }}" alt="{{ $testimonial->client_name ?? '' }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: var(--bg-light); color: var(--primary); font-weight: 700;">
                            {{ strtoupper(substr($testimonial->client_name ?? 'U', 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $testimonial->client_name ?? '' }}</h6>
                            <small class="text-muted">{{ $testimonial->position ?? '' }}{{ $testimonial->company ? ' at ' . $testimonial->company : '' }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->testimonials))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <i class="bi bi-chat-quote fs-1 text-muted"></i>
                <p class="text-muted mt-3">Testimonials coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
