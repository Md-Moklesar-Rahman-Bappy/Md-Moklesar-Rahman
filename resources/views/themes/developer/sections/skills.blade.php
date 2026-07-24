@php
    $skills = $data['skills'] ?? ($profile->skills ?? collect());
@endphp

<section id="skills" class="dev-section">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// tech_stack</span>
            <h2><span style="color: var(--dev-primary);">#</span> Skills</h2>
        </div>

        @if($skills && count($skills))
            @php
                $grouped = $skills->groupBy('category');
            @endphp
            <div class="row">
                @foreach($grouped as $category => $categorySkills)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-terminal">
                            <div class="dev-terminal-header">
                                <div class="dev-terminal-dot"></div>
                                <div class="dev-terminal-dot"></div>
                                <div class="dev-terminal-dot"></div>
                                <span class="ms-2" style="color: #94a3b8; font-size: 0.8rem;">{{ \Illuminate\Support\Str::slug($category ?? 'skills') }}.json</span>
                            </div>
                            <div class="dev-terminal-body">
                                <div class="dev-keyword mb-3">"{{ $category ?? 'General' }}"</div>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($categorySkills as $skill)
                                        <span class="dev-tag">
                                            {{ $skill->name ?? $skill['name'] ?? '' }}
                                            @if($skill->proficiency ?? $skill['proficiency'] ?? null)
                                                <span class="dev-number" style="font-size: 0.65rem;">{{ $skill->proficiency ?? $skill['proficiency'] }}%</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                                @if($categorySkills->first()->proficiency ?? $categorySkills->first()['proficiency'] ?? null)
                                    <div class="mt-3">
                                        @foreach($categorySkills as $skill)
                                            @php $prof = $skill->proficiency ?? $skill['proficiency'] ?? 0; @endphp
                                            <div class="mb-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span style="font-size: 0.75rem; color: #94a3b8;">{{ $skill->name ?? $skill['name'] ?? '' }}</span>
                                                    <span style="font-size: 0.75rem; color: var(--dev-primary);">{{ $prof }}%</span>
                                                </div>
                                                <div style="height: 4px; background: var(--dev-border); border-radius: 2px; overflow: hidden;">
                                                    <div style="height: 100%; width: {{ $prof }}%; background: linear-gradient(90deg, var(--dev-primary), var(--dev-secondary)); border-radius: 2px; transition: width 1s ease;"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
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
                        <span class="dev-comment">// skills coming soon</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
