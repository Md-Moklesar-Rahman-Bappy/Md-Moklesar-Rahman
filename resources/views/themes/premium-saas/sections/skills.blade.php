<section id="features" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Skills & Expertise</span>
            <h2 class="section-title">Core Capabilities</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Technologies and tools I leverage to build exceptional products</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->skills ?? [] as $skill)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(59,130,246,0.1)); color: var(--primary);">
                        @if($skill->icon)
                        <i class="bi bi-{{ $skill->icon }}"></i>
                        @else
                        <i class="bi bi-tools"></i>
                        @endif
                    </div>
                    <h5 class="fw-bold">{{ $skill->name ?? '' }}</h5>
                    @if($skill->level)
                    <div class="progress mt-3" style="height: 6px; border-radius: 3px; background: #f1f5f9;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $skill->level }}%; background: linear-gradient(90deg, var(--primary), var(--secondary)); border-radius: 3px;"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">{{ $skill->level }}% proficiency</small>
                    @endif
                </div>
            </div>
            @endforeach
            @if(empty($profile->skills))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <p class="text-muted">Skills coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
