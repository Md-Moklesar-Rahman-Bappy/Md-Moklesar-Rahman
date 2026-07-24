@php
    $experiences = $data['experiences'] ?? ($profile->experiences ?? collect());
@endphp

<section id="experience" class="mod-section">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Experience</span>
            <h2>Work History</h2>
            <p>My professional journey and the roles that shaped my career.</p>
        </div>

        @if($experiences && count($experiences))
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @foreach($experiences as $exp)
                        <div class="mod-card mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="d-flex flex-wrap justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 style="font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $exp->position ?? $exp['position'] ?? '' }}</h5>
                                    <span style="color: var(--mod-primary); font-weight: 600;">
                                        {{ $exp->company ?? $exp['company'] ?? '' }}
                                    </span>
                                    @if($exp->location ?? $exp['location'] ?? null)
                                        <span style="color: var(--mod-text); font-size: 0.9rem;">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $exp->location ?? $exp['location'] }}
                                        </span>
                                    @endif
                                </div>
                                <span style="padding: 0.3rem 0.85rem; background: rgba(99,102,241,0.08); color: var(--mod-primary); border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $exp->start_date ?? $exp['start_date'] ?? '' }} — {{ $exp->end_date ?? $exp['end_date'] ?? 'Present' }}
                                </span>
                            </div>

                            @if($exp->description ?? $exp['description'] ?? null)
                                <p style="color: var(--mod-text); margin-top: 0.75rem; margin-bottom: 0;">
                                    {!! nl2br(e($exp->description ?? $exp['description'] ?? '')) !!}
                                </p>
                            @endif

                            @if($exp->technologies ?? $exp['technologies'] ?? null)
                                <div class="mt-3">
                                    @php $techs = is_string($exp->technologies ?? $exp['technologies']) ? explode(',', $exp->technologies ?? $exp['technologies']) : ($exp->technologies ?? $exp['technologies']); @endphp
                                    @foreach($techs as $tech)
                                        <span class="mod-skill-chip" style="font-size: 0.75rem; padding: 0.3rem 0.8rem;">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--mod-text);">Experience details coming soon.</p>
            </div>
        @endif
    </div>
</section>
