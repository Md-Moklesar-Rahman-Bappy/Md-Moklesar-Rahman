@php
$blogPosts = $profile->blogPosts ?? collect();
if (method_exists($blogPosts, 'where')) {
    $blogPosts = $blogPosts->where('status', 'published')->latest()->take(3);
}
@endphp

<section id="blog" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Latest Blog Posts</h2>
            <p class="section-subtitle mx-auto">Thoughts, tutorials, and industry insights</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($blogPosts as $post)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="bg-white rounded-4 overflow-hidden h-100" style="box-shadow: 0 5px 20px rgba(0,0,0,0.04);">
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title ?? '' }}" class="w-100" style="height: 220px; object-fit: cover;">
                    @else
                    <div style="height: 220px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-pencil-square text-white" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                    @endif
                    <div class="p-4">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <span><i class="bi bi-calendar me-1"></i>{{ $post->created_at?->format('M d, Y') ?? '' }}</span>
                            @if($post->category)
                            <span class="mx-2">|</span>
                            <span style="color: var(--primary);">{{ $post->category }}</span>
                            @endif
                        </div>
                        <h5 class="fw-bold">{{ $post->title ?? '' }}</h5>
                        <p class="text-muted small">{{ Str::limit($post->excerpt ?? $post->description ?? '', 120) }}</p>
                        @if($post->slug)
                        <a href="{{ route('home.blog.show', $post->slug) }}" class="fw-semibold" style="color: var(--primary);">Read More <i class="bi bi-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($blogPosts->count() > 3)
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('home.blog') }}" class="btn btn-agency">View All Posts</a>
        </div>
        @endif
        @if($blogPosts->isEmpty())
        <div class="text-center py-5" data-aos="fade-up">
            <i class="bi bi-journal-richtext fs-1 text-muted"></i>
            <p class="text-muted mt-3">Blog posts coming soon.</p>
        </div>
        @endif
    </div>
</section>
