@php
$themeSlug = $activeTheme?->slug ?? 'developer' ?? 'developer';
$activeTheme = $activeTheme ?? \App\Models\Theme::where('is_active', true)->first();
@endphp

@extends("themes.{$themeSlug}.layout")

@section('page_title', 'Blog')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5 fw-bold">Blog</h1>
            <p class="lead text-muted">Thoughts, stories and ideas.</p>
        </div>
    </div>

    @if($posts->isEmpty())
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>No blog posts published yet.
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--pb-primary, #0d6efd), var(--pb-accent, #6610f2));">
                                <i class="bi bi-pencil-square text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            @if($post->category)
                                <span class="badge bg-primary mb-2 align-self-start">{{ $post->category->name }}</span>
                            @endif
                            <h5 class="card-title">
                                <a href="{{ route('home.blog.show', $post->slug) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>{{ $post->published_at?->format('M d, Y') }}
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-eye me-1"></i>{{ $post->views_count }} views
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
