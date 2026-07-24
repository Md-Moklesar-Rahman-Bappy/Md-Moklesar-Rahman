<section id="education" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Education</h2>
                <p class="section-subtitle">Academic background</p>
                @foreach($profile->educations ?? [] as $edu)
                <div class="min-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h5 class="fw-semibold mb-1">{{ $edu->degree ?? '' }}</h5>
                            <p class="text-muted small mb-0">{{ $edu->institution ?? '' }}</p>
                        </div>
                        <small class="text-muted">{{ $edu->start_date ?? '' }} — {{ $edu->end_date ?? 'Present' }}</small>
                    </div>
                    @if($edu->description)
                    <p class="text-muted mt-3 mb-0" style="font-size: 0.9rem;">{{ $edu->description }}</p>
                    @endif
                </div>
                @endforeach
                @if(empty($profile->educations))
                <p class="text-muted">Education details coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
