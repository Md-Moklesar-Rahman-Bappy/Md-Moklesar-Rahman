@php
    $blogPosts = $data['blog_posts'] ?? ($profile->blogPosts ?? collect());
@endphp

<section id="blog" class="cre-section cre-section-alt">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-journal-richtext"></i> Blog</span>
            <h2>Latest Articles</h2>
            <p>Insights, stories, and creative ideas.</p>
        </div>

        @if($blogPosts && count($blogPosts))
            <div class="row">
                @foreach($blogPosts->take(3) as $post)
                    <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="cre-card h-100 d-flex flex-column" style="padding: 0; overflow: hidden;">
                            @if($post->image ?? $post['image'] ?? null)
                                <div style="overflow: hidden;">
                                    <img src="{{ $post->image ?? $post['image'] }}" alt="{{ $post->title ?? $post['title'] ?? '' }}"
                                         style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.4s;"
                                         onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                            @endif

                            <div style="padding: 1.5rem;" class="flex-grow-1 d-flex flex-column">
                                <div class="mb-2">
                                    <span class="cre-tag" style="font-size: 0.7rem;">
                                        {{ $post->published_date ?? $post['published_date'] ?? $post->created_at ?? '' }}
                                    </span>
                                    @if($post->category ?? $post['category'] ?? null)
                                        <span class="cre-tag" style="font-size: 0.7rem; background: rgba(124,58,237,0.08); color: var(--cre-secondary);">
                                            {{ $post->category ?? $post['category'] }}
                                        </span>
                                    @endif
                                </div>

                                <h5 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem;">
                                    <a href="{{ route('home.blog.show', $post->slug ?? $post['slug'] ?? '#') }}" style="color: var(--cre-heading);">
                                        {{ $post->title ?? $post['title'] ?? '' }}
                                    </a>
                                </h5>

                                <p style="color: var(--cre-text); font-size: 0.9rem; flex-grow: 1;">
                                    {{ \Illuminate\Support\Str::limit($post->excerpt ?? $post['excerpt'] ?? ($post->description ?? $post['description'] ?? ''), 120) }}
                                </p>

                                <a href="{{ route('home.blog.show', $post->slug ?? $post['slug'] ?? '#') }}"
                                   style="font-weight: 600; font-size: 0.9rem; margin-top: auto; color: var(--cre-primary);">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--cre-text);">Blog posts coming soon.</p>
            </div>
        @endif
    </div>
</section>
