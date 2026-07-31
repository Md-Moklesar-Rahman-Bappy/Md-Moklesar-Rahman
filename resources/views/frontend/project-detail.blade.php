@extends('layouts.frontend')

@section('page_title', $project->title)

@section('content')
<article class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('home') }}" style="color: var(--dev-primary);" class="mb-4 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i>Back to Portfolio
                </a>

                @if($project->category)
                    <span class="dev-tag mb-3">{{ $project->category->name }}</span>
                @endif

                <h1 class="display-6 fw-bold mb-3">{{ $project->title }}</h1>

                @if($project->client_name)
                    <p class="mb-4" style="color: #94a3b8;"><strong>Client:</strong> {{ $project->client_name }}</p>
                @endif

                @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $project->title }}">
                @endif

                <div class="mb-4">
                    <h5>Description</h5>
                    <div class="fs-5 lh-lg" style="color: var(--dev-text); line-height: 1.9;">{!! clean($project->description) !!}</div>
                </div>

                @if($project->technologies && count($project->technologies))
                    <div class="mb-4">
                        <h5>Technologies Used</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                                <span class="dev-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($project->features && count($project->features))
                    <div class="mb-4">
                        <h5>Key Features</h5>
                        <ul class="list-unstyled">
                            @foreach($project->features as $feature)
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill me-2" style="color: var(--dev-primary);"></i>{{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex gap-3 mt-4">
                    @if($project->live_url)
                        <a href="{{ $project->live_url }}" target="_blank" class="dev-btn">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Live Demo
                        </a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="dev-btn dev-btn-outline">
                            <i class="bi bi-github me-1"></i>Source Code
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if($project->projectImages && $project->projectImages->count())
            <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                    <h3 class="mb-4">Project Gallery</h3>
                    <div class="row g-3">
                        @foreach($project->projectImages as $image)
                            <div class="col-md-6">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded" alt="{{ $image->alt_text ?? $project->title }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</article>

@if($relatedProjects && $relatedProjects->count())
<section class="dev-section dev-section-alt" style="padding: 4rem 0;">
    <div class="container">
        <h3 class="mb-4">Related Projects</h3>
        <div class="row g-4">
            @foreach($relatedProjects as $related)
                <div class="col-md-4">
                    <div class="dev-card h-100 d-flex flex-column">
                        @if($related->thumbnail)
                            <div style="margin: -1.5rem -1.5rem 1rem; overflow: hidden; border-radius: 8px 8px 0 0;">
                                <img src="{{ asset('storage/' . $related->thumbnail) }}" class="w-100" alt="{{ $related->title }}" style="height: 140px; object-fit: cover;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="margin: -1.5rem -1.5rem 1rem; height: 140px; background: var(--dev-bg); border-radius: 8px 8px 0 0;">
                                <i class="bi bi-folder" style="font-size: 2.5rem; color: var(--dev-primary);"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column p-0">
                            <h6>
                                <a href="{{ route('home.project', $related->slug) }}" style="color: var(--dev-heading);">{{ $related->title }}</a>
                            </h6>
                            <p class="small mt-auto" style="color: #64748b;">{{ Str::limit($related->short_description, 80) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
