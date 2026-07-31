@php
    $skills = $data['skills'] ?? ($profile->skills ?? collect());
@endphp

<section id="skills" class="fre-section">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-tools"></i> Skills</span>
            <h2>My Skills</h2>
            <p>Technologies and tools I'm proficient in.</p>
        </div>

        @if($skills && count($skills))
            @php $grouped = $skills->groupBy(fn($skill) => $skill->category->name ?? $skill['category'] ?? 'Uncategorized'); @endphp
            <div class="row">
                @foreach($grouped as $category => $categorySkills)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="fre-card">
                            <h5 style="font-weight: 700; margin-bottom: 1.25rem; color: var(--fre-primary);">
                                {{ $category ?? 'Skills' }}
                            </h5>
                            @foreach($categorySkills as $skill)
                                @php $prof = $skill->percentage ?? $skill['percentage'] ?? null; @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span style="font-weight: 600; font-size: 0.9rem;">{{ $skill->name ?? $skill['name'] ?? '' }}</span>
                                        @if($prof)
                                            <span style="color: var(--fre-primary); font-weight: 700; font-size: 0.85rem;">{{ $prof }}%</span>
                                        @endif
                                    </div>
                                    @if($prof)
                                        <div class="fre-progress">
                                            <div class="fre-progress-fill" style="width: {{ $prof }}%;"></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Skills data coming soon.</p>
            </div>
        @endif
    </div>
</section>
