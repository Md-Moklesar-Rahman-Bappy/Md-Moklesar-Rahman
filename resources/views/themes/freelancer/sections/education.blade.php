@php
    $educations = $data['educations'] ?? ($profile->educations ?? collect());
@endphp

<section id="education" class="fre-section">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-mortarboard"></i> Education</span>
            <h2>Education</h2>
            <p>My academic qualifications and background.</p>
        </div>

        @if($educations && count($educations))
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="fre-timeline">
                        @foreach($educations as $edu)
                            <div class="fre-timeline-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="fre-card">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 style="font-size: 1.1rem; font-weight: 700;">{{ $edu->degree ?? $edu['degree'] ?? '' }}</h5>
                                            <span style="color: var(--fre-primary); font-weight: 600;">
                                                {{ $edu->institution ?? $edu['institution'] ?? '' }}
                                            </span>
                                        </div>
                                        <span style="padding: 0.3rem 0.85rem; background: rgba(16,185,129,0.08); color: var(--fre-accent); border-radius: 8px; font-size: 0.8rem; font-weight: 600;">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $edu->start_date ?? $edu['start_date'] ?? '' }} — {{ $edu->end_date ?? $edu['end_date'] ?? 'Present' }}
                                        </span>
                                    </div>

                                    @if($edu->field_of_study ?? $edu['field_of_study'] ?? null)
                                        <p style="color: var(--fre-text); margin: 0.5rem 0 0; font-size: 0.9rem;">
                                            <i class="bi bi-book me-1"></i>{{ $edu->field_of_study ?? $edu['field_of_study'] }}
                                        </p>
                                    @endif

                                    @if($edu->grade ?? $edu['grade'] ?? null)
                                        <span style="color: var(--fre-secondary); font-weight: 700; font-size: 0.9rem;">
                                            Grade: {{ $edu->grade ?? $edu['grade'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Education details coming soon.</p>
            </div>
        @endif
    </div>
</section>
