<section id="experience" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Experience</span>
            <h2 class="section-title">Professional Journey</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">My career path and key milestones</p>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                @foreach($profile->experiences ?? [] as $exp)
                <div class="d-flex gap-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="flex-shrink-0 d-flex flex-column align-items-center">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff;">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        @if(!$loop->last)
                        <div style="width: 2px; flex: 1; background: linear-gradient(to bottom, var(--primary), transparent); min-height: 20px;"></div>
                        @endif
                    </div>
                    <div class="feature-card flex-grow-1" style="padding: 1.75rem;">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $exp->position ?? '' }}</h5>
                                <p class="mb-0 fw-medium" style="color: var(--primary);">{{ $exp->company ?? '' }}</p>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(59,130,246,0.1)); color: var(--primary); font-weight: 500;">{{ $exp->start_date ?? '' }} - {{ $exp->end_date ?? 'Present' }}</span>
                        </div>
                        <p class="text-muted mt-2 mb-0">{{ $exp->description ?? '' }}</p>
                    </div>
                </div>
                @endforeach
                @if(empty($profile->experiences))
                <div class="text-center py-5" data-aos="fade-up">
                    <p class="text-muted">Experience details coming soon.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
