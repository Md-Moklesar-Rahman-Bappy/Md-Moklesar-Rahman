@php
    $educations = $data['educations'] ?? ($profile->educations ?? collect());
@endphp

<section id="education" class="mod-section mod-section-alt">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Education</span>
            <h2>Academic Background</h2>
            <p>My educational qualifications and academic achievements.</p>
        </div>

        @if($educations && count($educations))
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @foreach($educations as $edu)
                        <div class="mod-card mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="d-flex align-items-start gap-4">
                                <div class="mod-icon-circle" style="min-width: 56px;">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start">
                                        <div>
                                            <h5 style="font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $edu->degree ?? $edu['degree'] ?? '' }}</h5>
                                            <span style="color: var(--mod-primary); font-weight: 600;">
                                                {{ $edu->institution ?? $edu['institution'] ?? '' }}
                                            </span>
                                        </div>
                                        <span style="padding: 0.3rem 0.85rem; background: rgba(99,102,241,0.08); color: var(--mod-primary); border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                            {{ format_date($edu->start_date ?? $edu['start_date'] ?? null) }} — {{ format_date($edu->end_date ?? $edu['end_date'] ?? null) ?: 'Present' }}
                                        </span>
                                    </div>
                                    @if($edu->group_or_field ?? $edu['group_or_field'] ?? null)
                                        <p style="color: var(--mod-text); margin: 0.5rem 0 0; font-size: 0.9rem;">
                                            <i class="bi bi-book me-1"></i>{{ $edu->group_or_field ?? $edu['group_or_field'] }}
                                        </p>
                                    @endif
                                    @if($edu->result ?? $edu['result'] ?? null)
                                        <span style="color: var(--mod-secondary); font-weight: 600; font-size: 0.85rem;">
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
                <p style="color: var(--mod-text);">Education details coming soon.</p>
            </div>
        @endif
    </div>
</section>
