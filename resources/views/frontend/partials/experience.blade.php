@php
    $experiences = $profile->experiences ?? collect();
@endphp

<section id="experience" class="dev-section dev-section-alt">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// work_history</span>
            <h2><span style="color: var(--dev-primary);">#</span> Experience</h2>
        </div>

        @if($experiences && count($experiences))
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    @foreach($experiences as $exp)
                        <div class="dev-terminal mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="dev-terminal-header">
                                <div class="dev-terminal-dot"></div>
                                <div class="dev-terminal-dot"></div>
                                <div class="dev-terminal-dot"></div>
                                <span class="ms-2" style="color: #94a3b8; font-size: 0.8rem;">
                                    {{ \Illuminate\Support\Str::slug($exp->company_name ?? 'company') }}.log
                                </span>
                            </div>
                            <div class="dev-terminal-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="dev-keyword">class</span>
                                        <span style="color: var(--dev-heading); font-weight: 600; font-size: 1.1rem;">
                                            {{ $exp->position }}
                                        </span>
                                    </div>
                                    <span class="dev-tag">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ format_date($exp->start_date) }}
                                        — {{ format_date($exp->end_date) ?: 'Present' }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-building me-1" style="color: var(--dev-primary);"></i>
                                    <span style="color: var(--dev-secondary);">{{ $exp->company_name }}</span>
                                    @if($exp->location)
                                        <span style="color: #64748b;"> | {{ $exp->location }}</span>
                                    @endif
                                </div>

                                @if($exp->description)
                                    <div style="color: #94a3b8; font-size: 0.9rem;">
                                        <span class="dev-comment">// responsibilities</span><br>
                                        {!! nl2br(e($exp->description)) !!}
                                    </div>
                                @endif

                                @if($exp->technologies)
                                    <div class="mt-3">
                                        <span class="dev-comment">// tech_used</span><br>
                                        @foreach($exp->technologies as $tech)
                                            <span class="dev-tag">{{ trim($tech) }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
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
                        <span class="dev-comment">// experience log empty</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
