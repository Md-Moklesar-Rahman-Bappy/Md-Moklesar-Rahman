@php
    $bio = $profile->bio ?? '';
    $experienceYears = $profile->experience_years ?? 0;
    $aboutSections = $profile->aboutSections ?? collect();
@endphp

<section id="about" class="dev-section dev-section-alt">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// about_me</span>
            <h2><span style="color: var(--dev-primary);">#</span> About Me</h2>
        </div>

        <div class="row">
            <div class="col-lg-8" data-aos="fade-right" data-aos-delay="100">
                <div class="dev-terminal">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <span class="ms-2" style="color: #94a3b8; font-size: 0.8rem;">about.md</span>
                    </div>
                    <div class="dev-terminal-body">
                        <p class="mb-0" style="line-height: 2;">
                            <span class="dev-comment"># Who am I?</span><br><br>
                            {!! nl2br(e($bio)) !!}
                        </p>
                    </div>
                </div>

                @if($aboutSections && count($aboutSections))
                    <div class="row mt-4">
                        @foreach($aboutSections as $section)
                            <div class="col-md-6 mb-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="dev-card">
                                    <div class="mb-2">
                                        <i class="bi bi-{{ $section->icon ?? 'chevron-right' }}" style="color: var(--dev-primary);"></i>
                                        <strong style="color: var(--dev-heading);">{{ $section->title ?? '' }}</strong>
                                    </div>
                                    <p class="mb-0" style="color: #94a3b8; font-size: 0.85rem;">
                                        {{ $section->description ?? '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="dev-card text-center">
                    <div class="dev-keyword mb-2">experience.years</div>
                    <h2 style="color: var(--dev-primary); font-size: 3rem; font-weight: 700;">{{ $experienceYears }}+</h2>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Years of Experience</p>
                </div>

                <div class="dev-card mt-3">
                    <div class="dev-keyword mb-3">// quick_stats</div>
                    @if($profile->email ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope" style="color: var(--dev-primary);"></i>
                            <span style="font-size: 0.85rem;">{{ $profile->email }}</span>
                        </div>
                    @endif
                    @if($profile->location ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt" style="color: var(--dev-primary);"></i>
                            <span style="font-size: 0.85rem;">{{ $profile->location }}</span>
                        </div>
                    @endif
                    @if($profile->phone ?? null)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-phone" style="color: var(--dev-primary);"></i>
                            <span style="font-size: 0.85rem;">{{ $profile->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
