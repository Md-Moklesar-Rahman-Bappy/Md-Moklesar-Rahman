<section id="about" class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">About</h2>
                <div class="row mt-5">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        @if($profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="{{ $profile->full_name }}" class="w-100" style="filter: grayscale(30%);">
                        @endif
                        <div class="mt-4">
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid #f3f4f6;">
                                <small class="text-muted">Experience</small>
                                <small class="fw-medium">{{ $profile->experience_years ?? '0' }} years</small>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid #f3f4f6;">
                                <small class="text-muted">Projects</small>
                                <small class="fw-medium">{{ count($profile->projects ?? []) }}</small>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid #f3f4f6;">
                                <small class="text-muted">Location</small>
                                <small class="fw-medium">{{ $profile->location ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        @foreach($profile->aboutSections ?? [] as $section)
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-2" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.75rem; color: var(--text-light);">{{ $section->heading ?? $section->title ?? '' }}</h6>
                            <p class="text-muted">{{ $section->content ?? '' }}</p>
                        </div>
                        @endforeach
                        @if(!empty($profile->aboutSections) && count($profile->aboutSections) === 0)
                        <p class="text-muted">{{ $profile->bio ?? '' }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
