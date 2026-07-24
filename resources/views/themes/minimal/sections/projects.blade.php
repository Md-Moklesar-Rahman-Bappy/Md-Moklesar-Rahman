<section id="projects" class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Projects</h2>
                <p class="section-subtitle">Selected work</p>
                @foreach($profile->projects ?? [] as $project)
                <div class="project-row" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="row align-items-center">
                        @if($project->image)
                        <div class="col-md-3 mb-3 mb-md-0">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title ?? '' }}" class="w-100" style="height: 120px; object-fit: cover; filter: grayscale(20%);">
                        </div>
                        @endif
                        <div class="{{ $project->image ? 'col-md-6' : 'col-md-9' }}">
                            <h5 class="fw-semibold mb-1">{{ $project->title ?? '' }}</h5>
                            <p class="text-muted small mb-0">{{ $project->description ?? '' }}</p>
                        </div>
                        <div class="col-md-3 text-md-end mt-3 mt-md-0">
                            @if($project->url)
                            <a href="{{ $project->url }}" class="min-link small" target="_blank">View <i class="bi bi-arrow-right"></i></a>
                            @endif
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" class="min-link small ms-3" target="_blank">Code</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @if(empty($profile->projects))
                <p class="text-muted">Projects coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
