@php
    $certifications = $data['certifications'] ?? ($profile->certifications ?? collect());
@endphp

<section id="certifications" class="mod-section mod-section-alt">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Certifications</span>
            <h2>Professional Certifications</h2>
            <p>Validated skills and recognized achievements.</p>
        </div>

        @if($certifications && count($certifications))
            <div class="row">
                @foreach($certifications as $cert)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="mod-card h-100">
                            <div class="d-flex align-items-start gap-3">
                                <div class="mod-icon-circle" style="min-width: 50px; width: 50px; height: 50px; font-size: 1.1rem; background: rgba(245,158,11,0.08); color: #f59e0b;">
                                    <i class="bi bi-patch-check-fill"></i>
                                </div>
                                <div>
                                    <h5 style="font-size: 0.95rem; margin-bottom: 0.25rem;">{{ $cert->name ?? $cert['name'] ?? '' }}</h5>
                                    <p style="color: var(--mod-primary); font-size: 0.85rem; margin-bottom: 0.25rem;">
                                        {{ $cert->issuer ?? $cert['issuer'] ?? '' }}
                                    </p>
                                    <span style="font-size: 0.8rem; color: var(--mod-text);">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $cert->date ?? $cert['date'] ?? '' }}
                                    </span>
                                    @if($cert->credential_url ?? $cert['credential_url'] ?? null)
                                        <div class="mt-2">
                                            <a href="{{ $cert->credential_url ?? $cert['credential_url'] }}" target="_blank"
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
                <p style="color: var(--mod-text);">Certifications coming soon.</p>
            </div>
        @endif
    </div>
</section>
