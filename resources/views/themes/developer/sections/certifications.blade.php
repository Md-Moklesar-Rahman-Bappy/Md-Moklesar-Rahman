@php
    $certifications = $data['certifications'] ?? ($profile->certifications ?? collect());
@endphp

<section id="certifications" class="dev-section">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// certs_and_badges</span>
            <h2><span style="color: var(--dev-primary);">#</span> Certifications</h2>
        </div>

        @if($certifications && count($certifications))
            <div class="row">
                @foreach($certifications as $cert)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="dev-card h-100">
                            <div class="d-flex align-items-start gap-3">
                                <div style="min-width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-patch-check-fill" style="color: var(--dev-accent); font-size: 1.2rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 style="color: var(--dev-heading); font-size: 0.95rem; margin-bottom: 0.25rem;">
                                        {{ $cert->name ?? $cert['name'] ?? '' }}
                                    </h5>
                                    <p style="color: var(--dev-secondary); font-size: 0.85rem; margin-bottom: 0.25rem;">
                                        {{ $cert->issuer ?? $cert['issuer'] ?? '' }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="dev-tag">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $cert->date ?? $cert['date'] ?? '' }}
                                        </span>
                                        @if($cert->credential_url ?? $cert['credential_url'] ?? null)
                                            <a href="{{ $cert->credential_url ?? $cert['credential_url'] }}" target="_blank"
                                               style="color: var(--dev-primary); font-size: 0.8rem;">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>Verify
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="dev-terminal" style="max-width: 400px; margin: 0 auto;">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                    </div>
                    <div class="dev-terminal-body text-center">
                        <span class="dev-comment">// certifications.render()</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
