@php
    $fullName = $profile->full_name ?? 'Developer';
    $tagline = $profile->tagline ?? 'Building the future, one line at a time';
    $designation = $profile->designation ?? 'Full Stack Developer';
    $profileImage = $profile->profile_image ?? null;
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="hero" class="dev-section d-flex align-items-center" style="min-height: 100vh; padding-top: 5rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                <div class="dev-terminal mb-4" style="max-width: 600px;">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <span class="ms-2" style="color: #94a3b8; font-size: 0.8rem;">terminal — bash</span>
                    </div>
                    <div class="dev-terminal-body">
                        <div class="mb-2">
                            <span style="color: var(--dev-primary);">visitor</span>
                            <span style="color: #94a3b8;">@</span>
                            <span style="color: var(--dev-secondary);">portfolio</span>
                            <span style="color: #94a3b8;"> $ </span>
                            <span class="dev-cursor-blink">cat about.txt</span>
                        </div>
                        <div class="mt-3">
                            <p class="dev-comment">// {{ $tagline }}</p>
                        </div>
                    </div>
                </div>

                <p class="dev-comment mb-2">&lt;h1&gt;</p>
                <h1 style="font-size: 3rem; font-weight: 700; color: var(--dev-heading); line-height: 1.2;" class="dev-glow-text">
                    {{ $fullName }}
                </h1>
                <p class="dev-comment mb-2">&lt;/h1&gt;</p>

                <div class="my-4">
                    <span class="dev-keyword">const</span>
                    <span style="color: var(--dev-heading);"> role</span>
                    <span style="color: var(--dev-text);"> = </span>
                    <span class="dev-string">"{{ $designation }}"</span>
                    <span style="color: var(--dev-text);">;</span>
                </div>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#projects" class="dev-btn dev-btn-filled">
                        <i class="bi bi-folder2-open"></i> View Projects
                    </a>
                    <a href="#contact" class="dev-btn">
                        <i class="bi bi-terminal-fill"></i> Contact Me
                    </a>
                </div>

                <div class="mt-4">
                    @if($socialLinks->count())
                        <div class="d-flex gap-3">
                            @foreach($socialLinks as $link)
                                <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                   style="color: var(--dev-text); font-size: 1.2rem;"
                                   onmouseover="this.style.color='var(--dev-primary)'" onmouseout="this.style.color='var(--dev-text)'">
                                    <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="300">
                @if($profileImage)
                    <div style="position: relative; display: inline-block;">
                        <div style="position: absolute; inset: -8px; border: 2px solid var(--dev-primary); border-radius: 8px; opacity: 0.3;"></div>
                        <img src="{{ asset('storage/' . $profileImage) }}" alt="{{ $fullName }}"
                             style="width: 300px; height: 300px; object-fit: cover; border-radius: 8px; border: 2px solid var(--dev-border); filter: grayscale(30%);">
                        <div style="position: absolute; bottom: -10px; right: -10px; background: var(--dev-primary); color: var(--dev-bg); padding: 0.25rem 0.75rem; font-size: 0.75rem; border-radius: 4px;">
                            <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> available
                        </div>
                    </div>
                @else
                    <div style="width: 300px; height: 300px; margin: 0 auto; background: var(--dev-bg-alt); border: 2px solid var(--dev-border); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-code" style="font-size: 5rem; color: var(--dev-primary); opacity: 0.5;"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
