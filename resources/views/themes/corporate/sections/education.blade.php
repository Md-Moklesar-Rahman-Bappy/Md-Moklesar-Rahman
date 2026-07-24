<section id="education" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="corp-divider mx-auto"></div>
            <h2 class="section-title">Education</h2>
            <p class="section-subtitle mx-auto">Academic qualifications and certifications</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->educations ?? [] as $edu)
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="corp-card h-100">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; background: var(--primary); color: #fff; font-size: 1.2rem;">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $edu->degree ?? '' }}</h5>
                            <p class="fw-medium mb-1" style="color: var(--primary);">{{ $edu->institution ?? '' }}</p>
                            <p class="text-muted small mb-2">{{ $edu->start_date ?? '' }} - {{ $edu->end_date ?? 'Present' }}</p>
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
                <i class="bi bi-mortarboard fs-1 text-muted"></i>
                <p class="text-muted mt-3">Education details coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
