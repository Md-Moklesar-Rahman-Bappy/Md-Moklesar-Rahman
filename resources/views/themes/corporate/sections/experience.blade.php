<section id="experience" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="corp-divider"></div>
                <h2 class="section-title">Experience</h2>
                <p class="section-subtitle">Professional history and career progression</p>
                <a href="#contact" class="btn btn-corp mt-3">Discuss Opportunities</a>
            </div>
            <div class="col-lg-8" data-aos="fade-left">
                @foreach($profile->experiences ?? [] as $exp)
                <div class="exp-block mb-4">
                    <div class="bg-white p-4 border">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $exp->position ?? '' }}</h5>
                                <p class="mb-0 fw-medium" style="color: var(--primary);">{{ $exp->company_name ?? '' }}</p>
                            </div>
                            <span class="badge bg-dark text-white rounded-pill px-3 py-2">{{ $exp->start_date ?? '' }} - {{ $exp->end_date ?? 'Present' }}</span>
                        </div>
                        <p class="text-muted mt-3 mb-0">{{ $exp->description ?? '' }}</p>
                    </div>
                </div>
                @endforeach
                @if(empty($profile->experiences))
                <div class="bg-white p-5 border text-center">
                    <i class="bi bi-briefcase fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Experience details coming soon.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
