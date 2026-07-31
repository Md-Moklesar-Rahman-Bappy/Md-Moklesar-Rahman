@php
    $educations = $data['educations'] ?? ($profile->educations ?? collect());
@endphp

<section id="education" class="dev-section">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// education_path</span>
            <h2><span style="color: var(--dev-primary);">#</span> Education</h2>
        </div>

        @if($educations && count($educations))
            <div class="row">
                @foreach($educations as $edu)
                    <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-card" style="height: 100%;">
                            <div class="d-flex align-items-start gap-3">
                                <div style="min-width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-mortarboard" style="color: var(--dev-primary); font-size: 1.2rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 style="color: var(--dev-heading); font-size: 1rem; margin-bottom: 0.25rem;">
                                        {{ $edu->degree ?? $edu['degree'] ?? '' }}
                                    </h5>
                                    <p style="color: var(--dev-secondary); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                        {{ $edu->institution ?? $edu['institution'] ?? '' }}
                                    </p>
                                    @if($edu->group_or_field ?? $edu['group_or_field'] ?? null)
                                        <p style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 0.25rem;">
                                            <i class="bi bi-book me-1"></i>{{ $edu->group_or_field ?? $edu['group_or_field'] }}
                                        </p>
                                    @endif
                                    <span class="dev-tag">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ format_date($edu->start_date ?? $edu['start_date'] ?? null) }}
                                        — {{ format_date($edu->end_date ?? $edu['end_date'] ?? null) ?: 'Present' }}
                                    </span>
                                    @if($edu->result ?? $edu['result'] ?? null)
                                        <div class="mt-2">
                                            <span class="dev-number">{{ $edu->result ?? $edu['result'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="dev-terminal" style="max-width: 400px; margin: 0 auto;">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                    </div>
                    <div class="dev-terminal-body text-center">
                        <span class="dev-comment">// education records pending</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
