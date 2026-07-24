@php
    $bio = $profile->bio ?? '';
    $experienceYears = $profile->experience_years ?? 0;
    $aboutSections = $data['about_sections'] ?? ($profile->aboutSections ?? collect());
@endphp

<section id="about" class="cre-section cre-section-alt">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-person"></i> About Me</span>
            <h2>Know Me Better</h2>
            <p>Passionate about creating beautiful and functional digital experiences.</p>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
                <div style="position: relative; display: inline-block;">
                    <div style="position: absolute; inset: -15px; background: var(--cre-gradient-alt); border-radius: 24px; opacity: 0.1; transform: rotate(-5deg);"></div>
                    <div class="cre-card" style="text-align: center; padding: 3rem 2rem; position: relative;">
                        <h2 style="font-size: 4rem; font-weight: 900; margin-bottom: 0;" class="cre-gradient-text">{{ $experienceYears }}+</h2>
                        <h5 style="font-weight: 600; margin-bottom: 0.5rem;">Years Experience</h5>
                        <p style="color: var(--cre-text); font-size: 0.9rem;">Delivering exceptional results with creativity and passion.</p>

                        <div class="row mt-4 text-center">
                            <div class="col-4">
                                <h4 style="font-weight: 800;" class="cre-gradient-text">100%</h4>
                                <small style="color: var(--cre-text);">Dedication</small>
                            </div>
                            <div class="col-4">
                                <h4 style="font-weight: 800;" class="cre-gradient-text">50+</h4>
                                <small style="color: var(--cre-text);">Projects</small>
                            </div>
                            <div class="col-4">
                                <h4 style="font-weight: 800;" class="cre-gradient-text">30+</h4>
                                <small style="color: var(--cre-text);">Clients</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <p style="font-size: 1.05rem; line-height: 1.9; margin-bottom: 2rem;">
                    {!! nl2br(e($bio)) !!}
                </p>

                @if($aboutSections && count($aboutSections))
                    <div class="row">
                        @foreach($aboutSections as $section)
                            <div class="col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="cre-icon-blob" style="width: 50px; height: 50px; font-size: 1.1rem; margin: 0; min-width: 50px;">
                                        <i class="bi bi-{{ $section['icon'] ?? 'check-circle' }}"></i>
                                    </div>
                                    <div>
                                        <h6 style="font-weight: 700;">{{ $section['title'] ?? '' }}</h6>
                                        <small style="color: var(--cre-text);">{{ $section['description'] ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <a href="#contact" class="cre-btn mt-3">
                    <i class="bi bi-download"></i> Download CV
                </a>
            </div>
        </div>
    </div>
</section>
