@php
$activeTheme = $activeTheme ?? \App\Models\Theme::where('is_active', true)->first();
$themeSlug = $activeTheme?->slug ?? 'developer';
@endphp

@extends("themes.{$themeSlug}.layout")

@section('page_title', $post->title)

@section('content')
<article class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('home.blog') }}" class="text-decoration-none mb-4 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i>Back to Blog
                </a>

                @if($post->category)
                    <span class="badge bg-primary mb-3">{{ $post->category->name }}</span>
                @endif

                <h1 class="display-6 fw-bold mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center gap-3 text-muted mb-4 pb-4 border-bottom">
                    <span><i class="bi bi-calendar me-1"></i>{{ $post->published_at?->format('F d, Y') }}</span>
                    <span><i class="bi bi-eye me-1"></i>{{ $post->views_count }} views</span>
                    @if($post->reading_time)
                        <span><i class="bi bi-clock me-1"></i>{{ $post->reading_time }} min read</span>
                    @endif
                </div>

                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $post->title }}">
                @endif

                <div class="blog-content fs-5 lh-lg">
                    {!! clean($post->content) !!}
                </div>

                @if($post->tags && $post->tags->count())
                    <div class="mt-4 pt-4 border-top">
                        <strong class="me-2">Tags:</strong>
                        @foreach($post->tags as $tag)
                            <span class="badge bg-secondary mb-1">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</article>

@if($relatedPosts && $relatedPosts->count())
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-4">Related Posts</h3>
        <div class="row g-4">
            @foreach($relatedPosts as $related)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($related->featured_image)
                            <img src="{{ asset('storage/' . $related->featured_image) }}" class="card-img-top" alt="{{ $related->title }}" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('home.blog.show', $related->slug) }}" class="text-decoration-none text-dark">{{ $related->title }}</a>
                            </h6>
                            <small class="text-muted">{{ $related->published_at?->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
