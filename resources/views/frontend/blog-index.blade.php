@extends('layouts.frontend')

@section('page_title', 'Blog')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5 fw-bold">Blog</h1>
            <p class="text-muted">Thoughts, stories and ideas.</p>
        </div>
    </div>

    @if($posts->isEmpty())
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="dev-terminal" style="max-width: 400px; margin: 0 auto;">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                    </div>
                    <div class="dev-terminal-body text-center">
                        <span class="dev-comment">// no published posts yet</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="dev-card h-100 d-flex flex-column">
                        @if($post->featured_image)
                            <div style="margin: -1.5rem -1.5rem 1rem; overflow: hidden; border-radius: 8px 8px 0 0;">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-100" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                            </div>
                        @endif
                        <div class="mb-2">
                            @if($post->category)
                                <span class="dev-tag">{{ $post->category->name }}</span>
                            @endif
                            <span class="dev-tag">
                                <i class="bi bi-calendar me-1"></i>{{ $post->published_at?->format('M d, Y') }}
                            </span>
                        </div>
                        <h5 style="color: var(--dev-heading);">
                            <a href="{{ route('home.blog.show', $post->slug) }}" style="color: var(--dev-heading);">{{ $post->title }}</a>
                        </h5>
                        <p class="flex-grow-1" style="color: #94a3b8;">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3" style="border-top: 1px solid var(--dev-border);">
                            <small style="color: #64748b;">
                                <i class="bi bi-eye me-1"></i>{{ $post->views_count }} views
                            </small>
                            <a href="{{ route('home.blog.show', $post->slug) }}" class="dev-btn" style="font-size: 0.75rem; padding: 0.4rem 0.9rem;">
                                Read <i class="bi bi-arrow-right"></i>
                            </a>
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
