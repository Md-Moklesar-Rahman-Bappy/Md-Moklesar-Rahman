<section id="projects" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle mx-auto">Showcasing my best work and creative solutions</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->projects ?? [] as $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="project-card">
                    @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title ?? '' }}">
                    @else
                    <div style="height: 300px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-folder2-open text-white" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                    @endif
                    <div class="project-overlay">
                        <h5 class="fw-bold">{{ $project->title ?? '' }}</h5>
                        <p class="small mb-3">{{ $project->description ?? '' }}</p>
                        <div class="d-flex gap-2">
                            @if($project->url)
                            <a href="{{ $project->url }}" class="btn btn-sm btn-light rounded-pill" target="_blank"><i class="bi bi-link-45deg"></i> View</a>
                            @endif
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" class="btn btn-sm btn-outline-light rounded-pill" target="_blank"><i class="bi bi-github"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->projects))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <i class="bi bi-folder fs-1 text-muted"></i>
                <p class="text-muted mt-3">Projects coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
