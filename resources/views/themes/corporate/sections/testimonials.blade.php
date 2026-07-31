<section id="testimonials" class="section-padding" style="background: var(--bg-dark);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="corp-divider mx-auto" style="background: var(--accent);"></div>
            <h2 class="section-title text-white">Client Testimonials</h2>
            <p class="section-subtitle text-white-50 mx-auto">Trusted by clients worldwide</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->testimonials ?? [] as $testimonial)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="bg-white p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        @for($i = 0; $i < 5; $i++)
                        <i class="bi bi-star-fill text-warning me-1 small"></i>
                        @endfor
                    </div>
                    <p class="text-muted small mb-4">"{{ $testimonial->review ?? '' }}"</p>
                    <div class="d-flex align-items-center border-top pt-3">
                        @if($testimonial->profile_image)
                        <img src="{{ asset('storage/' . $testimonial->profile_image) }}" alt="" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover;">
                        @else
                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: var(--primary); color: #fff; font-weight: 700; font-size: 0.85rem;">
                            {{ strtoupper(substr($testimonial->client_name ?? 'U', 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0 small">{{ $testimonial->client_name ?? '' }}</h6>
                            <small class="text-muted">{{ $testimonial->position ?? '' }}{{ $testimonial->company ? ', ' . $testimonial->company : '' }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->testimonials))
            <div class="col-12 text-center py-5">
                <i class="bi bi-chat-quote fs-1 text-white-50"></i>
                <p class="text-white-50 mt-3">Testimonials coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
