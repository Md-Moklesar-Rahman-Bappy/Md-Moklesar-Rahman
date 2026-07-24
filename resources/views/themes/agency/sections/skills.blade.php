<section id="skills" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Skills & Expertise</h2>
            <p class="section-subtitle mx-auto">Technologies and tools I work with</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->skills ?? [] as $skill)
            <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                <div class="text-center p-4 rounded-4" style="background: #fff; box-shadow: 0 5px 20px rgba(0,0,0,0.04); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.04)'">
                    @if($skill->icon)
                    <div class="mb-3">
                        <i class="bi bi-{{ $skill->icon }} fs-1" style="color: var(--primary);"></i>
                    </div>
                    @endif
                    <h6 class="fw-bold mb-2">{{ $skill->name ?? '' }}</h6>
                    @if($skill->level)
                    <div class="progress mt-3" style="height: 6px; border-radius: 3px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $skill->level }}%; background: linear-gradient(90deg, var(--primary), var(--secondary)); border-radius: 3px;"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">{{ $skill->level }}%</small>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
