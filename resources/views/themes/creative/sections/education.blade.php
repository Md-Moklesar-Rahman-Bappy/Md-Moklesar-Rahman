@php
    $educations = $data['educations'] ?? ($profile->educations ?? collect());
@endphp

<section id="education" class="cre-section">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-mortarboard"></i> Education</span>
            <h2>Academic Background</h2>
            <p>My educational journey and qualifications.</p>
        </div>

        @if($educations && count($educations))
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @foreach($educations as $edu)
                        <div class="cre-card mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="d-flex align-items-start gap-4">
                                <div class="cre-icon-blob" style="min-width: 60px; width: 60px; height: 60px; font-size: 1.3rem;">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start">
                                        <div>
                                            <h5 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $edu->degree ?? $edu['degree'] ?? '' }}</h5>
                                            <span style="color: var(--cre-primary); font-weight: 600;">
                                                {{ $edu->institution ?? $edu['institution'] ?? '' }}
                                            </span>
                                        </div>
                                        <span style="padding: 0.3rem 1rem; background: var(--cre-gradient-alt); color: #fff; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                            {{ format_date($edu->start_date ?? $edu['start_date'] ?? null) }} — {{ format_date($edu->end_date ?? $edu['end_date'] ?? null) ?: 'Present' }}
                                        </span>
                                    </div>
                                    @if($edu->group_or_field ?? $edu['group_or_field'] ?? null)
                                        <p style="color: var(--cre-text); margin: 0.5rem 0 0; font-size: 0.9rem;">
                                            <i class="bi bi-book me-1"></i>{{ $edu->group_or_field ?? $edu['group_or_field'] }}
                                        </p>
                                    @endif
                                    @if($edu->result ?? $edu['result'] ?? null)
                                        <span style="color: var(--cre-secondary); font-weight: 700; font-size: 0.9rem;">
                                            Grade: {{ $edu->result ?? $edu['result'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--cre-text);">Education details coming soon.</p>
            </div>
        @endif
    </div>
</section>
