@php
    $fullName = $profile->full_name ?? 'Professional';
    $tagline = $profile->tagline ?? 'Crafting Digital Experiences';
    $designation = $profile->designation ?? 'Senior Developer';
    $profileImage = $profile->profile_image ?? null;
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="hero" class="mod-section d-flex align-items-center" style="min-height: 100vh; padding-top: 5rem; background: var(--mod-bg-alt);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                <div style="display: inline-block; padding: 0.4rem 1rem; background: rgba(99,102,241,0.08); border-radius: 20px; color: var(--mod-primary); font-size: 0.85rem; font-weight: 500; margin-bottom: 1.5rem;">
                    <i class="bi bi-hand-wave me-1"></i> Welcome to my portfolio
                </div>

                <h1 style="font-size: 3.5rem; font-weight: 800; line-height: 1.15; margin-bottom: 1.5rem;">
                    Hi, I'm<br>
                    <span style="background: var(--mod-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ $fullName }}
                    </span>
                </h1>

                <p style="font-size: 1.15rem; color: var(--mod-text); max-width: 480px; margin-bottom: 0.5rem;">
                    {{ $tagline }}
                </p>

                <p style="font-size: 1rem; color: var(--mod-primary); font-weight: 600; margin-bottom: 2rem;">
                    {{ $designation }}
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="#projects" class="mod-btn">
                        <i class="bi bi-folder2-open"></i> View Projects
                    </a>
                    <a href="#contact" class="mod-btn mod-btn-outline">
                        <i class="bi bi-chat-dots"></i> Get In Touch
                    </a>
                </div>

                @if($socialLinks->count())
                    <div class="d-flex gap-3">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                               style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: rgba(99,102,241,0.08); border-radius: 10px; color: var(--mod-text); font-size: 1.1rem; transition: all 0.3s;"
                               onmouseover="this.style.background='var(--mod-primary)'; this.style.color='#fff'"
                               onmouseout="this.style.background='rgba(99,102,241,0.08)'; this.style.color='var(--mod-text)'">
                                <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-6 text-center mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="300">
                @if($profileImage)
                    <div style="position: relative; display: inline-block;">
                        <div style="position: absolute; inset: -15px; background: var(--mod-gradient); border-radius: 30px; opacity: 0.12;"></div>
                        <img src="{{ $profileImage }}" alt="{{ $fullName }}"
                             style="width: 380px; height: 380px; object-fit: cover; border-radius: 24px; box-shadow: var(--mod-shadow-lg); position: relative;">
                    </div>
                @else
                    <div style="width: 380px; height: 380px; margin: 0 auto; background: var(--mod-gradient); border-radius: 24px; display: flex; align-items: center; justify-content: center; opacity: 0.15;">
                        <i class="bi bi-person-fill" style="font-size: 6rem; color: var(--mod-primary);"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
