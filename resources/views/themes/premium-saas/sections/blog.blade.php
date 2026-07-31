@php
$blogPosts = collect($profile->blogPosts ?? []);
$blogPosts = $blogPosts->where('status', 'published')->sortByDesc('published_at')->take(3);
@endphp

<section id="blog" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Blog</span>
            <h2 class="section-title">Latest Insights</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Thoughts, tutorials, and industry trends</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($blogPosts as $post)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="feature-card h-100 p-0 overflow-hidden">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title ?? '' }}" class="w-100" style="height: 200px; object-fit: cover;">
                    @else
                    <div style="height: 200px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-pencil-square text-white" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                    @endif
                    <div class="p-4">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $post->created_at?->format('M d, Y') ?? '' }}</span>
                            @if($post->category)
                            <span class="mx-2">·</span>
                            <span style="color: var(--primary);">{{ $post->category->name ?? '' }}</span>
                            @endif
                        </div>
                        <h5 class="fw-bold">{{ $post->title ?? '' }}</h5>
                        <p class="text-muted small">{{ Str::limit($post->excerpt ?? $post->description ?? '', 120) }}</p>
                        @if($post->slug)
                        <a href="{{ route('home.blog.show', $post->slug) }}" class="fw-semibold small" style="color: var(--primary);">Read Article <i class="bi bi-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($blogPosts->isEmpty())
        <div class="text-center py-5" data-aos="fade-up">
            <p class="text-muted">Blog posts coming soon.</p>
        </div>
        @endif
    </div>
</section>
