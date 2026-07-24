@php
    $projects = $data['projects'] ?? ($profile->projects ?? collect());
@endphp

<section id="projects" class="fre-section fre-section-alt">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-folder"></i> Projects</span>
            <h2>Featured Projects</h2>
            <p>Some of my recent work that I'm proud of.</p>
        </div>

        @if($projects && count($projects))
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="fre-card h-100 d-flex flex-column" style="padding: 0; overflow: hidden;">
                            @if($project->image ?? $project['image'] ?? null)
                                <img src="{{ $project->image ?? $project['image'] }}" alt="{{ $project->title ?? $project['title'] ?? '' }}"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div style="height: 200px; background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(249,115,22,0.08)); display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-code-slash" style="font-size: 3rem; color: var(--fre-primary); opacity: 0.3;"></i>
                                </div>
                            @endif

                            <div style="padding: 1.5rem;" class="flex-grow-1 d-flex flex-column">
                                <h5 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $project->title ?? $project['title'] ?? '' }}</h5>
                                <p style="color: var(--fre-text); font-size: 0.9rem; flex-grow: 1;">
                                    {{ $project->description ?? $project['description'] ?? '' }}
                                </p>

                                @if($project->technologies ?? $project['technologies'] ?? null)
                                    <div class="mb-3">
                                        @php $techs = is_string($project->technologies ?? $project['technologies']) ? explode(',', $project->technologies ?? $project['technologies']) : ($project->technologies ?? $project['technologies']); @endphp
                                        @foreach($techs->take(4) as $tech)
                                            <span style="display: inline-block; padding: 0.2rem 0.6rem; background: rgba(37,99,235,0.06); color: var(--fre-primary); border-radius: 6px; font-size: 0.7rem; font-weight: 500; margin: 0.15rem;">{{ trim($tech) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-flex gap-2 mt-auto">
                                    @if($project->live_url ?? $project['live_url'] ?? null)
                                        <a href="{{ $project->live_url ?? $project['live_url'] }}" target="_blank" class="fre-btn" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                            <i class="bi bi-box-arrow-up-right"></i> Live
                                        </a>
                                    @endif
                                    @if($project->github_url ?? $project['github_url'] ?? null)
                                        <a href="{{ $project->github_url ?? $project['github_url'] }}" target="_blank" class="fre-btn fre-btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                            <i class="bi bi-github"></i> Code
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Projects coming soon.</p>
            </div>
        @endif
    </div>
</section>
