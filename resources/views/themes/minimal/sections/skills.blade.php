<section id="skills" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Skills</h2>
                <p class="section-subtitle">Technologies and tools I use</p>
                <div class="d-flex flex-wrap" data-aos="fade-up" data-aos-delay="100">
                    @foreach($profile->skills ?? [] as $skill)
                    <span class="skill-tag">{{ $skill->name ?? '' }}@if($skill->level) — {{ $skill->level }}%@endif</span>
                    @endforeach
                </div>
                @if(empty($profile->skills))
                <p class="text-muted mt-4">Skills coming soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>
