@php
    $bio = $profile->bio ?? '';
    $experienceYears = $profile->experience_years ?? 0;
    $aboutSections = $data['about_sections'] ?? ($profile->aboutSections ?? collect());
@endphp

<section id="about" class="fre-section fre-section-alt">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-person"></i> About Me</span>
            <h2>Who I Am</h2>
            <p>Get to know me, my background, and what drives me.</p>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
                @if($profileImage)
                    <img src="{{ $profileImage }}" alt="{{ $profile->full_name ?? '' }}"
                         style="width: 100%; border-radius: var(--fre-radius); box-shadow: var(--fre-shadow-lg);">
                @endif
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <h3 style="font-weight: 800; margin-bottom: 1rem;">
                    {{ $profile->full_name ?? '' }}
                </h3>
                <p style="font-size: 1.05rem; line-height: 1.9; margin-bottom: 2rem;">
                    {!! nl2br(e($bio)) !!}
                </p>

                <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill" style="color: var(--fre-accent);"></i>
                            <span style="font-weight: 600;">{{ $experienceYears }}+ Years Experience</span>
                        </div>
                    </div>
                    @if($profile->email ?? null)
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill" style="color: var(--fre-accent);"></i>
                                <span style="font-weight: 600;">{{ $profile->email }}</span>
                            </div>
                        </div>
                    @endif
                    @if($profile->location ?? null)
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill" style="color: var(--fre-accent);"></i>
                                <span style="font-weight: 600;">{{ $profile->location }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                @if($aboutSections && count($aboutSections))
                    <div class="row">
                        @foreach($aboutSections as $section)
                            <div class="col-sm-6 mb-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="fre-icon-box" style="width: 48px; height: 48px; font-size: 1rem; margin: 0; min-width: 48px;">
                                        <i class="bi bi-{{ $section['icon'] ?? 'check-circle' }}"></i>
                                    </div>
                                    <div>
                                        <h6 style="font-weight: 700; margin-bottom: 0.15rem;">{{ $section['title'] ?? '' }}</h6>
                                        <small style="color: var(--fre-text);">{{ $section['description'] ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <a href="#contact" class="fre-btn mt-3">
                    <i class="bi bi-download"></i> Download CV
                </a>
            </div>
        </div>
    </div>
</section>
