@php
    $blogPosts = $data['blog_posts'] ?? ($profile->blogPosts ?? collect());
@endphp

<section id="blog" class="fre-section fre-section-alt">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-journal-text"></i> Blog</span>
            <h2>Latest Articles</h2>
            <p>Insights and tips from my experience.</p>
        </div>

        @if($blogPosts && count($blogPosts))
            <div class="row">
                @foreach($blogPosts->take(3) as $post)
                    <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="fre-card h-100 d-flex flex-column" style="padding: 0; overflow: hidden;">
                            @if($post->featured_image ?? $post['featured_image'] ?? null)
                                <img src="{{ $post->featured_image ?? $post['featured_image'] }}" alt="{{ $post->title ?? $post['title'] ?? '' }}"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                            @endif

                            <div style="padding: 1.5rem;" class="flex-grow-1 d-flex flex-column">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span style="padding: 0.2rem 0.6rem; background: rgba(37,99,235,0.08); color: var(--fre-primary); border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                        {{ $post->published_at ?? $post['published_at'] ?? $post->created_at ?? '' }}
                                    </span>
                                    @if($post->category ?? $post['category'] ?? null)
                                        <span style="padding: 0.2rem 0.6rem; background: rgba(249,115,22,0.08); color: var(--fre-secondary); border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $post->category->name ?? $post['category'] ?? '' }}
                                        </span>
                                    @endif
                                </div>

                                <h5 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem;">
                                    <a href="{{ route('home.blog.show', $post->slug ?? $post['slug'] ?? '#') }}" style="color: var(--fre-heading);">
                                        {{ $post->title ?? $post['title'] ?? '' }}
                                    </a>
                                </h5>

                                <p style="color: var(--fre-text); font-size: 0.9rem; flex-grow: 1;">
                                    {{ \Illuminate\Support\Str::limit($post->excerpt ?? $post['excerpt'] ?? ($post->description ?? $post['description'] ?? ''), 120) }}
                                </p>

                                <a href="{{ route('home.blog.show', $post->slug ?? $post['slug'] ?? '#') }}"
                                   style="font-weight: 600; font-size: 0.9rem; margin-top: auto;">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Blog posts coming soon.</p>
            </div>
        @endif
    </div>
</section>
