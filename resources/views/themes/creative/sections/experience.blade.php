@php
    $experiences = $data['experiences'] ?? ($profile->experiences ?? collect());
@endphp

<section id="experience" class="cre-section cre-section-alt">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-briefcase"></i> Experience</span>
            <h2>Work History</h2>
            <p>My professional journey and milestones.</p>
        </div>

        @if($experiences && count($experiences))
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @foreach($experiences as $exp)
                        <div class="cre-card mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="d-flex flex-wrap justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 style="font-size: 1.1rem; font-weight: 700;">{{ $exp->position ?? $exp['position'] ?? '' }}</h5>
                                    <span style="color: var(--cre-primary); font-weight: 600;">
                                        <i class="bi bi-building me-1"></i>{{ $exp->company_name ?? $exp['company_name'] ?? '' }}
                                    </span>
                                    @if($exp->location ?? $exp['location'] ?? null)
                                        <span style="color: var(--cre-text); font-size: 0.85rem;">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $exp->location ?? $exp['location'] }}
                                        </span>
                                    @endif
                                </div>
                                <span style="padding: 0.3rem 1rem; background: var(--cre-gradient); color: #fff; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $exp->start_date ?? $exp['start_date'] ?? '' }} — {{ $exp->end_date ?? $exp['end_date'] ?? 'Present' }}
                                </span>
                            </div>

                            @if($exp->description ?? $exp['description'] ?? null)
                                <p style="color: var(--cre-text); margin-top: 0.75rem; margin-bottom: 0;">
                                    {!! nl2br(e($exp->description ?? $exp['description'] ?? '')) !!}
                                </p>
                            @endif

                            @if($exp->technologies ?? $exp['technologies'] ?? null)
                                <div class="mt-3">
                                    @php $techs = is_string($exp->technologies ?? $exp['technologies']) ? explode(',', $exp->technologies ?? $exp['technologies']) : ($exp->technologies ?? $exp['technologies']); @endphp
                                    @foreach($techs as $tech)
                                        <span class="cre-tag">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--cre-text);">Experience details coming soon.</p>
            </div>
        @endif
    </div>
</section>
