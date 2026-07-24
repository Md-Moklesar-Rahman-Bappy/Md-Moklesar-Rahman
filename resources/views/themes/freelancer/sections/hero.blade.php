@php
    $fullName = $profile->full_name ?? 'Freelancer';
    $tagline = $profile->tagline ?? 'Bringing Ideas to Life, One Project at a Time';
    $designation = $profile->designation ?? 'Freelance Developer';
    $profileImage = $profile->profile_image ?? null;
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="hero" class="fre-hero-fullscreen">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem; background: rgba(37,99,235,0.08); border-radius: 25px; color: var(--fre-primary); font-size: 0.85rem; font-weight: 500; margin-bottom: 1.5rem;">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></span>
                    Available for Freelance Work
                </div>

                <h1 style="font-size: 3.25rem; font-weight: 800; line-height: 1.15; margin-bottom: 1.5rem;">
                    Hi, I'm<br>
                    <span style="color: var(--fre-primary);">{{ $fullName }}</span>
                </h1>

                <p style="font-size: 1.2rem; color: var(--fre-text); max-width: 500px; margin-bottom: 0.5rem; line-height: 1.8;">
                    {{ $tagline }}
                </p>

                <p style="color: var(--fre-secondary); font-weight: 700; font-size: 1rem; margin-bottom: 2rem;">
                    {{ $designation }}
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="#contact" class="fre-btn">
                        <i class="bi bi-chat-dots"></i> Let's Work Together
                    </a>
                    <a href="#projects" class="fre-btn fre-btn-outline">
                        <i class="bi bi-folder2-open"></i> View My Work
                    </a>
                </div>

                @if($socialLinks->count())
                    <div class="d-flex gap-3">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                               style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: rgba(37,99,235,0.06); border-radius: 10px; color: var(--fre-text); font-size: 1.1rem; transition: all 0.3s;"
                               onmouseover="this.style.background='var(--fre-primary)'; this.style.color='#fff'; this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.background='rgba(37,99,235,0.06)'; this.style.color='var(--fre-text)'; this.style.transform='translateY(0)'">
                                <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-5 text-center mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="300">
                @if($profileImage)
                    <div style="position: relative; display: inline-block;">
                        <div style="position: absolute; inset: -15px; border: 3px dashed var(--fre-primary); border-radius: 30px; opacity: 0.2; animation: spin 20s linear infinite;"></div>
                        <img src="{{ $profileImage }}" alt="{{ $fullName }}"
                             style="width: 360px; height: 360px; object-fit: cover; border-radius: 24px; box-shadow: var(--fre-shadow-lg); position: relative;">
                    </div>
                @else
                    <div style="width: 360px; height: 360px; margin: 0 auto; background: rgba(37,99,235,0.06); border: 3px dashed rgba(37,99,235,0.2); border-radius: 24px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person" style="font-size: 5rem; color: var(--fre-primary); opacity: 0.3;"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</section>
