@php
    $projects = $data['projects'] ?? ($profile->projects ?? collect());
@endphp

<section id="projects" class="dev-section dev-section-alt">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// featured_projects</span>
            <h2><span style="color: var(--dev-primary);">#</span> Projects</h2>
        </div>

        @if($projects && count($projects))
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-card h-100 d-flex flex-column">
                            @if($project->thumbnail ?? $project['thumbnail'] ?? null)
                                <div style="margin: -1.5rem -1.5rem 1rem; overflow: hidden; border-radius: 8px 8px 0 0;">
                                    <img src="{{ $project->thumbnail ?? $project['thumbnail'] }}" alt="{{ $project->title ?? $project['title'] ?? '' }}"
                                         style="width: 100%; height: 180px; object-fit: cover; filter: grayscale(40%); transition: filter 0.3s;"
                                         onmouseover="this.style.filter='grayscale(0%)'" onmouseout="this.style.filter='grayscale(40%)'">
                                </div>
                            @else
                                <div style="height: 180px; background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(6,182,212,0.1)); display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 1rem;">
                                    <i class="bi bi-code-slash" style="font-size: 3rem; color: var(--dev-primary); opacity: 0.5;"></i>
                                </div>
                            @endif

                            <h5 style="color: var(--dev-heading); font-size: 1rem;">{{ $project->title ?? $project['title'] ?? '' }}</h5>

                            <p style="color: #94a3b8; font-size: 0.85rem; flex-grow: 1;">
                                {{ $project->description ?? $project['description'] ?? '' }}
                            </p>

                            @if($project->technologies ?? $project['technologies'] ?? null)
                                <div class="mb-3">
                                    @php $techs = $project->technologies ?? $project['technologies'] ?? []; @endphp
                                    @foreach($techs as $tech)
                                        <span class="dev-tag">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="d-flex gap-2 mt-auto">
                                @if($project->live_url ?? $project['live_url'] ?? null)
                                    <a href="{{ $project->live_url ?? $project['live_url'] }}" target="_blank" class="dev-btn dev-btn-filled" style="font-size: 0.75rem; padding: 0.5rem 1rem;">
                                        <i class="bi bi-box-arrow-up-right"></i> Live
                                    </a>
                                @endif
                                @if($project->github_url ?? $project['github_url'] ?? null)
                                    <a href="{{ $project->github_url ?? $project['github_url'] }}" target="_blank" class="dev-btn" style="font-size: 0.75rem; padding: 0.5rem 1rem;">
                                        <i class="bi bi-github"></i> Code
                                    </a>
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
                        <span class="dev-comment">// initializing projects...</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
