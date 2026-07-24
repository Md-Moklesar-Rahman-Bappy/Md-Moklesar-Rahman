@php
    $fullName = $profile->full_name ?? 'Creative';
    $tagline = $profile->tagline ?? 'Turning Ideas Into Reality';
    $designation = $profile->designation ?? 'Creative Developer';
    $profileImage = $profile->profile_image ?? null;
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="hero" class="cre-split-hero" style="padding-top: 5rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                <div style="display: inline-block; padding: 0.4rem 1rem; background: rgba(225,29,72,0.08); border-radius: 20px; color: var(--cre-primary); font-size: 0.85rem; font-weight: 500; margin-bottom: 1.5rem;">
                    <i class="bi bi-stars me-1"></i> Creative Portfolio
                </div>

                <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 1.5rem;">
                    Hello, I'm<br>
                    <span class="cre-gradient-text">{{ $fullName }}</span>
                </h1>

                <p style="font-size: 1.15rem; max-width: 460px; margin-bottom: 0.5rem;">
                    {{ $tagline }}
                </p>

                <p style="color: var(--cre-secondary); font-weight: 600; font-size: 1rem; margin-bottom: 2rem;">
                    {{ $designation }}
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="#projects" class="cre-btn">
                        <i class="bi bi-folder2-open"></i> My Work
                    </a>
                    <a href="#contact" class="cre-btn cre-btn-outline">
                        <i class="bi bi-chat-heart"></i> Let's Talk
                    </a>
                </div>

                @if($socialLinks->count())
                    <div class="d-flex gap-3">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                               style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: rgba(225,29,72,0.08); border-radius: 50%; color: var(--cre-text); font-size: 1.1rem; transition: all 0.3s;"
                               onmouseover="this.style.background='var(--cre-gradient)'; this.style.color='#fff'; this.style.transform='translateY(-3px)'"
                               onmouseout="this.style.background='rgba(225,29,72,0.08)'; this.style.color='var(--cre-text)'; this.style.transform='translateY(0)'">
                                <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-6 text-center mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="300">
                @if($profileImage)
                    <div style="position: relative; display: inline-block;">
                        <div style="position: absolute; inset: -20px; background: var(--cre-gradient); border-radius: 30px; opacity: 0.15; transform: rotate(6deg);"></div>
                        <div style="position: absolute; inset: -10px; border: 3px solid var(--cre-primary); border-radius: 24px; opacity: 0.2; transform: rotate(-3deg);"></div>
                        <img src="{{ $profileImage }}" alt="{{ $fullName }}"
                             style="width: 400px; height: 400px; object-fit: cover; border-radius: 24px; box-shadow: var(--cre-shadow-lg); position: relative;">
                        <div style="position: absolute; bottom: 20px; right: -20px; background: #fff; padding: 0.75rem 1.25rem; border-radius: 14px; box-shadow: var(--cre-shadow-lg); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-palette-fill" style="color: var(--cre-primary); font-size: 1.2rem;"></i>
                            <span style="font-weight: 700; font-size: 0.85rem;">Creative Mind</span>
                        </div>
                    </div>
                @else
                    <div style="width: 400px; height: 400px; margin: 0 auto; background: var(--cre-gradient); border-radius: 24px; display: flex; align-items: center; justify-content: center; opacity: 0.1;">
                        <i class="bi bi-brush" style="font-size: 6rem; color: var(--cre-primary);"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
