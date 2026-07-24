<section id="skills" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="corp-divider mx-auto"></div>
            <h2 class="section-title">Professional Skills</h2>
            <p class="section-subtitle mx-auto">Core competencies and technical proficiencies</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->skills ?? [] as $skill)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                <div class="corp-card h-100">
                    <div class="d-flex align-items-center mb-3">
                        @if($skill->icon)
                        <div class="me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: var(--primary); color: #fff;">
                            <i class="bi bi-{{ $skill->icon }}"></i>
                        </div>
                        @endif
                        <h6 class="fw-bold mb-0">{{ $skill->name ?? '' }}</h6>
                    </div>
                    @if($skill->level)
                    <div class="progress" style="height: 4px; background: #e2e8f0;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $skill->level }}%; background: var(--primary);"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Proficiency</small>
                        <small class="fw-bold" style="color: var(--primary);">{{ $skill->level }}%</small>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
