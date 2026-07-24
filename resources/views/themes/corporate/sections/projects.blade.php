<section id="projects" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="corp-divider mx-auto"></div>
            <h2 class="section-title">Projects Portfolio</h2>
            <p class="section-subtitle mx-auto">Demonstrated expertise through delivered projects</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->projects ?? [] as $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="bg-white border h-100 overflow-hidden">
                    @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title ?? '' }}" class="w-100" style="height: 220px; object-fit: cover;">
                    @else
                    <div style="height: 220px; background: var(--bg-dark); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-folder2-open text-white" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                    @endif
                    <div class="p-4">
                        <h5 class="fw-bold">{{ $project->title ?? '' }}</h5>
                        <p class="text-muted small">{{ $project->description ?? '' }}</p>
                        <div class="d-flex gap-2 mt-3">
                            @if($project->url)
                            <a href="{{ $project->url }}" class="btn btn-sm btn-corp" target="_blank">View Project</a>
                            @endif
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" class="btn btn-sm btn-outline-dark" target="_blank"><i class="bi bi-github"></i></a>
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
