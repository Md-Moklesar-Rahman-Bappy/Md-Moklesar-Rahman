@php
    $skills = $data['skills'] ?? ($profile->skills ?? collect());
@endphp

<section id="skills" class="cre-section">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-lightning"></i> Skills</span>
            <h2>My Expertise</h2>
            <p>Tools and technologies I use to bring ideas to life.</p>
        </div>

        @if($skills && count($skills))
            @php $grouped = $skills->groupBy('category'); @endphp
            <div class="row">
                @foreach($grouped as $category => $categorySkills)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="cre-card">
                            <div class="cre-icon-blob" style="width: 56px; height: 56px; font-size: 1.3rem;">
                                <i class="bi bi-{{ $loop->first ? 'code-slash' : ($loop->index == 1 ? 'palette' : 'gear') }}"></i>
                            </div>
                            <h5 style="text-align: center; margin-bottom: 1.25rem;">{{ $category ?? 'Skills' }}</h5>
                            <div class="d-flex flex-wrap justify-content-center">
                                @foreach($categorySkills as $skill)
                                    <span class="cre-tag">{{ $skill->name ?? $skill['name'] ?? '' }}</span>
                                @endforeach
                            </div>
                            @if($categorySkills->first()->proficiency ?? $categorySkills->first()['proficiency'] ?? null)
                                <div class="mt-3">
                                    @foreach($categorySkills as $skill)
                                        @php $prof = $skill->proficiency ?? $skill['proficiency'] ?? 0; @endphp
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small style="font-weight: 600;">{{ $skill->name ?? $skill['name'] ?? '' }}</small>
                                                <small style="color: var(--cre-primary); font-weight: 700;">{{ $prof }}%</small>
                                            </div>
                                            <div style="height: 8px; background: rgba(0,0,0,0.05); border-radius: 4px; overflow: hidden;">
                                                <div style="height: 100%; width: {{ $prof }}%; background: var(--cre-gradient); border-radius: 4px;"></div>
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
                <p style="color: var(--cre-text);">Skills coming soon.</p>
            </div>
        @endif
    </div>
</section>
