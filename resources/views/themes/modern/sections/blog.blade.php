@php
    $blogPosts = $data['blog_posts'] ?? ($profile->blogPosts ?? collect());
@endphp

<section id="blog" class="mod-section">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Blog</span>
            <h2>Latest Articles</h2>
            <p>Thoughts, tutorials, and insights from my experiences.</p>
        </div>

        @if($blogPosts && count($blogPosts))
            <div class="row">
                @foreach($blogPosts->take(3) as $post)
                    <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="mod-card h-100 d-flex flex-column" style="padding: 0; overflow: hidden;">
                            @if($post->featured_image ?? $post['featured_image'] ?? null)
                                <img src="{{ $post->featured_image ?? $post['featured_image'] }}" alt="{{ $post->title ?? $post['title'] ?? '' }}"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                            @endif

                            <div style="padding: 1.5rem;" class="flex-grow-1 d-flex flex-column">
                                <div class="mb-2">
                                    <span style="font-size: 0.8rem; color: var(--mod-primary); font-weight: 500;">
                                        {{ $post->published_at ?? $post['published_at'] ?? $post->created_at ?? '' }}
                                    </span>
                                    @if($post->category ?? $post['category'] ?? null)
                                        <span style="font-size: 0.8rem; color: var(--mod-text);"> · {{ $post->category->name ?? $post['category'] ?? '' }}</span>
                                    @endif
                                </div>

                                <h5 style="font-size: 1.05rem; margin-bottom: 0.5rem;">
                                    <a href="{{ route('home.blog.show', $post->slug ?? $post['slug'] ?? '#') }}" style="color: var(--mod-heading);">
                                        {{ $post->title ?? $post['title'] ?? '' }}
                                    </a>
                                </h5>

                                <p style="color: var(--mod-text); font-size: 0.9rem; flex-grow: 1;">
                                    {{ \Illuminate\Support\Str::limit($post->excerpt ?? $post['excerpt'] ?? ($post->description ?? $post['description'] ?? ''), 120) }}
                                </p>

                                <a href="{{ route('home.blog.show', $post->slug ?? $post['slug'] ?? '#') }}" style="font-weight: 600; font-size: 0.9rem; margin-top: auto;">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--mod-text);">Blog posts coming soon.</p>
            </div>
        @endif
    </div>
</section>
