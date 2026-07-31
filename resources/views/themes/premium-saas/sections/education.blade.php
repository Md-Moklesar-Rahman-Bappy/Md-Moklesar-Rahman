<section id="education" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Education</span>
            <h2 class="section-title">Academic Background</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Foundation of knowledge and expertise</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->educations ?? [] as $edu)
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="feature-card h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="feature-icon flex-shrink-0" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; width: 55px; height: 55px; font-size: 1.2rem;">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $edu->degree ?? '' }}</h5>
                            <p class="mb-1 fw-medium" style="color: var(--primary);">{{ $edu->institution ?? '' }}</p>
                            <p class="text-muted small mb-2">{{ format_date($edu->start_date) }} - {{ format_date($edu->end_date) ?: 'Present' }}</p>
                            @if($edu->description)
                            <p class="text-muted small mb-0">{{ $edu->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->educations))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <p class="text-muted">Education details coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
