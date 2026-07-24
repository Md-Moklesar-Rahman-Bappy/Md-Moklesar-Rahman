<section id="experience" class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Experience</h2>
                <p class="section-subtitle">Professional background</p>
                @foreach($profile->experiences ?? [] as $exp)
                <div class="min-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h5 class="fw-semibold mb-1">{{ $exp->position ?? '' }}</h5>
                            <p class="text-muted small mb-0">{{ $exp->company ?? '' }}</p>
                        </div>
                        <small class="text-muted">{{ $exp->start_date ?? '' }} — {{ $exp->end_date ?? 'Present' }}</small>
                    </div>
                    @if($exp->description)
                    <p class="text-muted mt-3 mb-0" style="font-size: 0.9rem;">{{ $exp->description }}</p>
                    @endif
                </div>
                @endforeach
                @if(empty($profile->experiences))
                <p class="text-muted">Experience details coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
