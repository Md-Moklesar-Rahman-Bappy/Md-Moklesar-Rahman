@php
    $projects = $data['projects'] ?? ($profile->projects ?? collect());
@endphp

<section id="projects" class="cre-section cre-section-alt">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-folder"></i> Projects</span>
            <h2>Featured Work</h2>
            <p>A showcase of my recent creative projects.</p>
        </div>

        @if($projects && count($projects))
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="cre-card h-100 d-flex flex-column" style="padding: 0; overflow: hidden;">
                            @if($project->thumbnail ?? $project['thumbnail'] ?? null)
                                <div style="overflow: hidden;">
                                    <img src="{{ $project->thumbnail ?? $project['thumbnail'] }}" alt="{{ $project->title ?? $project['title'] ?? '' }}"
                                         style="width: 100%; height: 220px; object-fit: cover; transition: transform 0.4s;"
                                         onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                            @else
                                <div style="height: 220px; background: var(--cre-gradient); display: flex; align-items: center; justify-content: center; opacity: 0.15;">
                                    <i class="bi bi-code-slash" style="font-size: 3.5rem; color: var(--cre-primary);"></i>
                                </div>
                            @endif

                            <div style="padding: 1.5rem;" class="flex-grow-1 d-flex flex-column">
                                <h5 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $project->title ?? $project['title'] ?? '' }}</h5>
                                <p style="color: var(--cre-text); font-size: 0.9rem; flex-grow: 1;">
                                    {{ $project->description ?? $project['description'] ?? '' }}
                                </p>

                                @if($project->technologies ?? $project['technologies'] ?? null)
                                    <div class="mb-3">
                                        @php $techs = is_string($project->technologies ?? $project['technologies']) ? explode(',', $project->technologies ?? $project['technologies']) : ($project->technologies ?? $project['technologies']); @endphp
                                        @foreach(collect($techs)->take(4) as $tech)
                                            <span class="cre-tag" style="font-size: 0.7rem;">{{ trim($tech) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-flex gap-2 mt-auto">
                                    @if($project->live_url ?? $project['live_url'] ?? null)
                                        <a href="{{ $project->live_url ?? $project['live_url'] }}" target="_blank" class="cre-btn" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                            <i class="bi bi-box-arrow-up-right"></i> Live
                                        </a>
                                    @endif
                                    @if($project->github_url ?? $project['github_url'] ?? null)
                                        <a href="{{ $project->github_url ?? $project['github_url'] }}" target="_blank" class="cre-btn cre-btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
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
                <p style="color: var(--cre-text);">Projects coming soon.</p>
            </div>
        @endif
    </div>
</section>
