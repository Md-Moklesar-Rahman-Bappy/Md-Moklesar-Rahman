@extends('layouts.frontend')

@section('page_title', $post->title)

@section('content')
<article class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('home.blog') }}" style="color: var(--dev-primary);" class="mb-4 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i>Back to Blog
                </a>

                @if($post->category)
                    <span class="dev-tag mb-3">{{ $post->category->name }}</span>
                @endif

                <h1 class="display-6 fw-bold mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center gap-3 mb-4 pb-4" style="color: #94a3b8; border-bottom: 1px solid var(--dev-border);">
                    <span><i class="bi bi-calendar me-1"></i>{{ $post->published_at?->format('F d, Y') }}</span>
                    <span><i class="bi bi-eye me-1"></i>{{ $post->views_count }} views</span>
                    @if($post->reading_time)
                        <span><i class="bi bi-clock me-1"></i>{{ $post->reading_time }} min read</span>
                    @endif
                </div>

                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded mb-4 w-100" alt="{{ $post->title }}">
                @endif

                <div class="blog-content" style="color: var(--dev-text); line-height: 1.9;">
                    {!! clean($post->content) !!}
                </div>

                @if($post->tags && $post->tags->count())
                    <div class="mt-4 pt-4" style="border-top: 1px solid var(--dev-border);">
                        <strong class="me-2" style="color: var(--dev-heading);">Tags:</strong>
                        @foreach($post->tags as $tag)
                            <span class="dev-tag">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</article>

@if($relatedPosts && $relatedPosts->count())
<section class="dev-section dev-section-alt" style="padding: 4rem 0;">
    <div class="container">
        <h3 class="mb-4">Related Posts</h3>
        <div class="row g-4">
            @foreach($relatedPosts as $related)
                <div class="col-md-4">
                    <div class="dev-card h-100 d-flex flex-column">
                        @if($related->featured_image)
                            <div style="margin: -1.5rem -1.5rem 1rem; overflow: hidden; border-radius: 8px 8px 0 0;">
                                <img src="{{ asset('storage/' . $related->featured_image) }}" class="w-100" alt="{{ $related->title }}" style="height: 140px; object-fit: cover;">
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column p-0">
                            <h6>
                                <a href="{{ route('home.blog.show', $related->slug) }}" style="color: var(--dev-heading);">{{ $related->title }}</a>
                            </h6>
                            <small class="mt-auto" style="color: #64748b;">{{ $related->published_at?->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
