@php
    $certifications = $data['certifications'] ?? ($profile->certifications ?? collect());
@endphp

<section id="certifications" class="fre-section">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-award"></i> Certifications</span>
            <h2>Certifications</h2>
            <p>Professional certifications and achievements.</p>
        </div>

        @if($certifications && count($certifications))
            <div class="row">
                @foreach($certifications as $cert)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="fre-card h-100">
                            <div class="d-flex align-items-start gap-3">
                                <div style="min-width: 54px; height: 54px; background: linear-gradient(135deg, #f97316, #ef4444); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.2rem;">
                                    <i class="bi bi-patch-check-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $cert->name ?? $cert['name'] ?? '' }}</h5>
                                    <p style="color: var(--fre-primary); font-size: 0.85rem; margin-bottom: 0.25rem; font-weight: 600;">
                                        {{ $cert->organization ?? $cert['organization'] ?? '' }}
                                    </p>
                                    <span style="font-size: 0.8rem; color: var(--fre-text);">
                                        <i class="bi bi-calendar3 me-1"></i>{{ format_date($cert->issue_date ?? $cert['issue_date'] ?? null) }}
                                    </span>
                                    @if($cert->verification_url ?? $cert['verification_url'] ?? null)
                                        <div class="mt-2">
                                            <a href="{{ $cert->verification_url ?? $cert['verification_url'] }}" target="_blank"
                                               style="font-size: 0.8rem; font-weight: 600;">
                                                Verify <i class="bi bi-box-arrow-up-right ms-1"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <p style="color: var(--fre-text);">Certifications coming soon.</p>
            </div>
        @endif
    </div>
</section>
