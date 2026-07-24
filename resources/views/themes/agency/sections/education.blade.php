<section id="education" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Education</h2>
            <p class="section-subtitle mx-auto">My academic background and qualifications</p>
        </div>
        <div class="row g-4 mt-4">
            @foreach($profile->educations ?? [] as $edu)
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="bg-white rounded-4 p-5 h-100" style="box-shadow: 0 5px 20px rgba(0,0,0,0.04); border-left: 4px solid var(--primary);">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; background: var(--bg-light); color: var(--primary);">
                            <i class="bi bi-mortarboard-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $edu->degree ?? '' }}</h5>
                            <p class="mb-1" style="color: var(--primary); font-weight: 600;">{{ $edu->institution ?? '' }}</p>
                            <p class="text-muted mb-2"><small>{{ $edu->start_date ?? '' }} - {{ $edu->end_date ?? 'Present' }}</small></p>
                            @if($edu->description)
                            <p class="text-muted mb-0">{{ $edu->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(empty($profile->educations))
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <i class="bi bi-mortarboard fs-1 text-muted"></i>
                <p class="text-muted mt-3">Education details coming soon.</p>
            </div>
            @endif
        </div>
    </div>
</section>
