@php
    $blogPosts = $data['blog_posts'] ?? ($profile->blogPosts ?? collect());
@endphp

<section id="blog" class="dev-section dev-section-alt">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// latest_posts</span>
            <h2><span style="color: var(--dev-primary);">#</span> Blog</h2>
        </div>

        @if($blogPosts && count($blogPosts))
            <div class="row">
                @foreach($blogPosts->take(3) as $post)
                    <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-card h-100 d-flex flex-column">
                            @if($post->image ?? $post['image'] ?? null)
                                <div style="margin: -1.5rem -1.5rem 1rem; overflow: hidden; border-radius: 8px 8px 0 0;">
                                    <img src="{{ $post->image ?? $post['image'] }}" alt="{{ $post->title ?? $post['title'] ?? '' }}"
                                         style="width: 100%; height: 180px; object-fit: cover;">
                                </div>
                            @endif

                            <div class="mb-2">
                                <span class="dev-tag">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $post->published_date ?? $post['published_date'] ?? $post->created_at ?? '' }}
                                </span>
                                @if($post->category ?? $post['category'] ?? null)
                                    <span class="dev-tag">
                                        {{ $post->category ?? $post['category'] }}
                                    </span>
                                @endif
                            </div>

                            <h5 style="color: var(--dev-heading); font-size: 1rem;">
                                <a href="{{ route('portfolio.blog.show', $post->slug ?? $post['slug'] ?? '#') }}" style="color: var(--dev-heading);">
                                    {{ $post->title ?? $post['title'] ?? '' }}
                                </a>
                            </h5>

                            <p style="color: #94a3b8; font-size: 0.85rem; flex-grow: 1;">
                                {{ \Illuminate\Support\Str::limit($post->excerpt ?? $post['excerpt'] ?? ($post->description ?? $post['description'] ?? ''), 120) }}
                            </p>

                            <a href="{{ route('portfolio.blog.show', $post->slug ?? $post['slug'] ?? '#') }}" class="dev-btn mt-auto" style="font-size: 0.75rem; padding: 0.5rem 1rem; width: fit-content;">
                                <i class="bi bi-arrow-right"></i> Read More
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="dev-terminal" style="max-width: 400px; margin: 0 auto;">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                    </div>
                    <div class="dev-terminal-body text-center">
                        <span class="dev-comment">// blog.posts.empty()</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
