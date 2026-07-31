@php
    $certifications = $data['certifications'] ?? ($profile->certifications ?? collect());
@endphp

<section id="certifications" class="cre-section">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-award"></i> Certifications</span>
            <h2>Professional Certifications</h2>
            <p>Validated expertise and recognized achievements.</p>
        </div>

        @if($certifications && count($certifications))
            <div class="row">
                @foreach($certifications as $cert)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="cre-card h-100 text-center">
                            <div class="cre-icon-blob" style="background: var(--cre-gradient-alt);">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                            <h5 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $cert->name ?? $cert['name'] ?? '' }}</h5>
                            <p style="color: var(--cre-primary); font-size: 0.85rem; font-weight: 500; margin-bottom: 0.5rem;">
                                {{ $cert->organization ?? $cert['organization'] ?? '' }}
                            </p>
                            <span style="font-size: 0.8rem; color: var(--cre-text);">
                                <i class="bi bi-calendar3 me-1"></i>{{ format_date($cert->issue_date ?? $cert['issue_date'] ?? null) }}
                            </span>
                            @if($cert->verification_url ?? $cert['verification_url'] ?? null)
                                <div class="mt-3">
                                    <a href="{{ $cert->verification_url ?? $cert['verification_url'] }}" target="_blank"
                                       class="cre-btn cre-btn-outline" style="font-size: 0.75rem; padding: 0.4rem 1rem;">
                                        <i class="bi bi-box-arrow-up-right"></i> Verify
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--cre-text);">Certifications coming soon.</p>
            </div>
        @endif
    </div>
</section>
