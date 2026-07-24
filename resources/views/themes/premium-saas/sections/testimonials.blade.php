<section id="testimonials" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Testimonials</span>
            <h2 class="section-title">Client Feedback</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">What people say about working with me</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->testimonials ?? [] as $testimonial)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="testimonial-card h-100">
                    <div class="d-flex align-items-center mb-3">
                        @for($i = 0; $i < 5; $i++)
                        <i class="bi bi-star-fill me-1" style="color: #fbbf24; font-size: 0.85rem;"></i>
                        @endfor
                    </div>
                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.7;">"{{ $testimonial->content ?? '' }}"</p>
                    <div class="d-flex align-items-center">
                        @if($testimonial->avatar)
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" class="rounded-circle me-3" style="width: 48px; height: 48px; object-fit: cover;">
                        @else
                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; font-weight: 700; font-size: 0.9rem;">
                            {{ strtoupper(substr($testimonial->name ?? 'U', 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $testimonial->name ?? '' }}</h6>
                            <small class="text-muted">{{ $testimonial->position ?? '' }}{{ $testimonial->company ? ' at ' . $testimonial->company : '' }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->testimonials))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <p class="text-muted">Testimonials coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
