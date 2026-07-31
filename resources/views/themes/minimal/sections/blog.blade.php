@php
$blogPosts = $profile->blogPosts ?? collect();
if (method_exists($blogPosts, 'where')) {
    $blogPosts = $blogPosts->where('status', 'published')->latest()->take(3);
}
@endphp

<section id="blog" class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Writing</h2>
                <p class="section-subtitle">Selected thoughts and articles</p>
                @foreach($blogPosts as $post)
                <div class="min-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">{{ $post->created_at?->format('M d, Y') ?? '' }}@if($post->category) &middot; {{ $post->category->name ?? '' }}@endif</p>
                            <h5 class="fw-semibold mb-1">{{ $post->title ?? '' }}</h5>
                            <p class="text-muted small mb-0" style="font-size: 0.9rem;">{{ Str::limit($post->excerpt ?? $post->description ?? '', 150) }}</p>
                        </div>
                        @if($post->slug)
                        <a href="{{ route('home.blog.show', $post->slug) }}" class="min-link small flex-shrink-0 ms-3" target="_blank"><i class="bi bi-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
                @endforeach
                @if($blogPosts->isEmpty())
                <p class="text-muted">Writing coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
