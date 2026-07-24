@php
    $experiences = $data['experiences'] ?? ($profile->experiences ?? collect());
@endphp

<section id="experience" class="fre-section fre-section-alt">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-briefcase"></i> Experience</span>
            <h2>Work Experience</h2>
            <p>My professional journey in a timeline.</p>
        </div>

        @if($experiences && count($experiences))
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="fre-timeline">
                        @foreach($experiences as $exp)
                            <div class="fre-timeline-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="fre-card">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 style="font-size: 1.1rem; font-weight: 700;">{{ $exp->position ?? $exp['position'] ?? '' }}</h5>
                                            <span style="color: var(--fre-primary); font-weight: 600;">
                                                {{ $exp->company ?? $exp['company'] ?? '' }}
                                            </span>
                                            @if($exp->location ?? $exp['location'] ?? null)
                                                <span style="color: var(--fre-text); font-size: 0.85rem;">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ $exp->location ?? $exp['location'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <span style="padding: 0.3rem 0.85rem; background: rgba(37,99,235,0.08); color: var(--fre-primary); border-radius: 8px; font-size: 0.8rem; font-weight: 600;">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $exp->start_date ?? $exp['start_date'] ?? '' }} — {{ $exp->end_date ?? $exp['end_date'] ?? 'Present' }}
                                        </span>
                                    </div>

                                    @if($exp->description ?? $exp['description'] ?? null)
                                        <p style="color: var(--fre-text); margin-top: 0.75rem; margin-bottom: 0; font-size: 0.95rem;">
                                            {!! nl2br(e($exp->description ?? $exp['description'] ?? '')) !!}
                                        </p>
                                    @endif

                                    @if($exp->technologies ?? $exp['technologies'] ?? null)
                                        <div class="mt-3 d-flex flex-wrap gap-1">
                                            @php $techs = is_string($exp->technologies ?? $exp['technologies']) ? explode(',', $exp->technologies ?? $exp['technologies']) : ($exp->technologies ?? $exp['technologies']); @endphp
                                            @foreach($techs as $tech)
                                                <span style="padding: 0.2rem 0.6rem; background: rgba(37,99,235,0.06); color: var(--fre-primary); border-radius: 6px; font-size: 0.75rem; font-weight: 500;">{{ trim($tech) }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Experience details coming soon.</p>
            </div>
        @endif
    </div>
</section>
