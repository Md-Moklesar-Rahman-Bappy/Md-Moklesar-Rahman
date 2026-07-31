<section id="projects" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Portfolio</span>
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Innovative solutions delivered with excellence</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->projects ?? [] as $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="feature-card h-100 p-0 overflow-hidden">
                    @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title ?? '' }}" class="w-100" style="height: 220px; object-fit: cover;">
                    @else
                    <div style="height: 220px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-rocket-takeoff-fill text-white" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                    @endif
                    <div class="p-4">
                        <h5 class="fw-bold">{{ $project->title ?? '' }}</h5>
                        <p class="text-muted small mb-3">{{ $project->description ?? '' }}</p>
                        <div class="d-flex gap-2">
                            @if($project->live_url)
                            <a href="{{ $project->live_url }}" class="btn btn-sm btn-saas-dark rounded-pill" style="font-size: 0.8rem; padding: 0.4rem 1rem;" target="_blank">View Live <i class="bi bi-arrow-right ms-1"></i></a>
                            @endif
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" class="btn btn-sm btn-outline-secondary rounded-pill" style="font-size: 0.8rem; padding: 0.4rem 1rem;" target="_blank"><i class="bi bi-github"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->projects))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <p class="text-muted">Projects coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
