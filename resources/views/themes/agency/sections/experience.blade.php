<section id="experience" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Work Experience</h2>
            <p class="section-subtitle mx-auto">My professional journey and achievements</p>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                @foreach($profile->experiences ?? [] as $exp)
                <div class="d-flex gap-4 mb-5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: var(--primary); color: #fff;">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        @if(!$loop->last)
                        <div class="mx-auto mt-2" style="width: 2px; height: 80px; background: #e2e8f0;"></div>
                        @endif
                    </div>
                    <div class="bg-white rounded-4 p-4 flex-grow-1" style="box-shadow: 0 5px 20px rgba(0,0,0,0.04);">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $exp->position ?? '' }}</h5>
                                <p class="mb-1" style="color: var(--primary); font-weight: 600;">{{ $exp->company_name ?? '' }}</p>
                            </div>
                            <span class="badge px-3 py-2 rounded-pill" style="background: var(--bg-light); color: var(--text-light); font-weight: 500;">{{ $exp->start_date ?? '' }} - {{ $exp->end_date ?? 'Present' }}</span>
                        </div>
                        <p class="text-muted mt-3 mb-0">{{ $exp->description ?? '' }}</p>
                    </div>
                </div>
                @endforeach
                @if(empty($profile->experiences))
                <div class="text-center py-5" data-aos="fade-up">
                    <i class="bi bi-briefcase fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Experience details coming soon.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
