@php
$themeSlug = $activeTheme?->slug ?? 'developer';
$activeTheme = $activeTheme ?? \App\Models\Theme::where('is_active', true)->first();
@endphp

@extends("themes.{$themeSlug}.layout")

@section('page_title', $project->title)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('home') }}" class="text-decoration-none mb-4 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i>Back to Portfolio
                </a>

                @if($project->category)
                    <span class="badge bg-primary mb-3">{{ $project->category->name }}</span>
                @endif

                <h1 class="display-6 fw-bold mb-3">{{ $project->title }}</h1>

                @if($project->client_name)
                    <p class="text-muted mb-4"><strong>Client:</strong> {{ $project->client_name }}</p>
                @endif

                @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $project->title }}">
                @endif

                <div class="mb-4">
                    <h5>Description</h5>
                    <div class="fs-5 lh-lg">{!! $project->description !!}</div>
                </div>

                @if($project->technologies && count($project->technologies))
                    <div class="mb-4">
                        <h5>Technologies Used</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($project->features && count($project->features))
                    <div class="mb-4">
                        <h5>Key Features</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($project->features as $feature)
                                <li class="list-group-item ps-0">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex gap-3 mt-4">
                    @if($project->live_url)
                        <a href="{{ $project->live_url }}" target="_blank" class="btn btn-primary">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Live Demo
                        </a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-dark">
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
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded shadow-sm" alt="{{ $image->alt_text ?? $project->title }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@if($relatedProjects && $relatedProjects->count())
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-4">Related Projects</h3>
        <div class="row g-4">
            @foreach($relatedProjects as $related)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($related->thumbnail)
                            <img src="{{ asset('storage/' . $related->thumbnail) }}" class="card-img-top" alt="{{ $related->title }}" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-folder text-white" style="font-size: 2.5rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('home.project', $related->slug) }}" class="text-decoration-none text-dark">{{ $related->title }}</a>
                            </h6>
                            <p class="card-text small text-muted">{{ Str::limit($related->short_description, 80) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
