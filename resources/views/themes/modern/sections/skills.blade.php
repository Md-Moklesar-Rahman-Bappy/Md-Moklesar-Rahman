@php
    $skills = collect($data['skills'] ?? $profile->skills ?? []);
@endphp

<section id="skills" class="mod-section mod-section-alt">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Skills</span>
            <h2>My Expertise</h2>
            <p>Technologies and tools I work with on a daily basis.</p>
        </div>

        @if($skills && count($skills))
            @php $grouped = $skills->groupBy(fn($skill) => $skill->category->name ?? $skill['category'] ?? 'Uncategorized'); @endphp
            <div class="row">
                @foreach($grouped as $category => $categorySkills)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="mod-card">
                            <h5 style="font-size: 1.05rem; margin-bottom: 1.25rem; color: var(--mod-primary);">
                                {{ $category ?? 'Skills' }}
                            </h5>
                            <div class="d-flex flex-wrap">
                                @foreach($categorySkills as $skill)
                                    <span class="mod-skill-chip">{{ $skill->name ?? $skill['name'] ?? '' }}</span>
                                @endforeach
                            </div>
                            @if($categorySkills->first()->percentage ?? $categorySkills->first()['percentage'] ?? null)
                                <div class="mt-3">
                                    @foreach($categorySkills as $skill)
                                        @php $prof = $skill->percentage ?? $skill['percentage'] ?? 0; @endphp
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small style="font-weight: 500;">{{ $skill->name ?? $skill['name'] ?? '' }}</small>
                                                <small style="color: var(--mod-primary); font-weight: 600;">{{ $prof }}%</small>
                                            </div>
                                            <div class="mod-progress-bar">
                                                <div class="progress-fill" style="width: {{ $prof }}%;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--mod-text);">Skills data coming soon.</p>
            </div>
        @endif
    </div>
</section>
