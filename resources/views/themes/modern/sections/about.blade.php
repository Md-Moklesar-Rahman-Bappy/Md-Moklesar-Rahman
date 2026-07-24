@php
    $bio = $profile->bio ?? '';
    $experienceYears = $profile->experience_years ?? 0;
    $aboutSections = $data['about_sections'] ?? ($profile->aboutSections ?? collect());
@endphp

<section id="about" class="mod-section">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">About Me</span>
            <h2>Get To Know Me</h2>
            <p>A passionate developer dedicated to creating impactful digital solutions.</p>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
                <div class="mod-card" style="text-align: center; padding: 3rem;">
                    <div style="width: 80px; height: 80px; background: var(--mod-gradient); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #fff; font-size: 2rem; font-weight: 800;">
                        {{ $experienceYears }}+
                    </div>
                    <h4 style="margin-bottom: 0.5rem;">Years of Experience</h4>
                    <p style="color: var(--mod-text); margin: 0;">Delivering quality work and building lasting relationships.</p>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <p style="font-size: 1.05rem; line-height: 1.9; margin-bottom: 2rem;">
                    {!! nl2br(e($bio)) !!}
                </p>

                @if($aboutSections && count($aboutSections))
                    <div class="row">
                        @foreach($aboutSections as $section)
                            <div class="col-sm-6 mb-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="mod-icon-circle" style="min-width: 44px; width: 44px; height: 44px; font-size: 1rem;">
                                        <i class="bi bi-{{ $section['icon'] ?? 'check-circle' }}"></i>
                                    </div>
                                    <div>
                                        <h6 style="font-size: 0.95rem; margin-bottom: 0.15rem;">{{ $section['title'] ?? '' }}</h6>
                                        <small style="color: var(--mod-text);">{{ $section['description'] ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($profile->email ?? null)
                    <div class="mt-4">
                        <a href="mailto:{{ $profile->email }}" class="mod-btn mod-btn-outline" style="font-size: 0.85rem;">
                            <i class="bi bi-envelope"></i> {{ $profile->email }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
