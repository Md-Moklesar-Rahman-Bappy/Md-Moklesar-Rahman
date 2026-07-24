<section id="hero" class="d-flex align-items-center" style="min-height: 100vh; background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <p class="text-muted mb-3" style="font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 500;">{{ $profile->designation ?? '' }}</p>
                <h1 class="display-4 fw-700 mb-4" style="letter-spacing: -1.5px; line-height: 1.1;">
                    {{ $profile->full_name ?? '' }}
                </h1>
                <p class="lead text-muted mb-5" style="max-width: 520px; font-weight: 300; font-size: 1.15rem;">{{ $profile->tagline ?? '' }}</p>
                <div class="d-flex gap-4 align-items-center">
                    <a href="#contact" class="min-link fw-medium">Get in touch</a>
                    <span style="color: #e5e7eb;">|</span>
                    <a href="#projects" class="min-link fw-medium">View work</a>
                </div>
                @if($profile->socialLinks && count($profile->socialLinks) > 0)
                <div class="d-flex gap-4 mt-5">
                    @foreach($profile->socialLinks as $link)
                    <a href="{{ $link->url }}" class="text-muted" style="font-size: 0.8rem; text-transform: lowercase;" target="_blank">{{ $link->platform }}</a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
