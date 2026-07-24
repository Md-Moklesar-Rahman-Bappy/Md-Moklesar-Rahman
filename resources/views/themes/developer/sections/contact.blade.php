@php
    $email = $profile->email ?? '';
    $phone = $profile->phone ?? '';
    $location = $profile->location ?? '';
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="contact" class="dev-section">
    <div class="container">
        <div class="dev-section-header" data-aos="fade-up">
            <span class="section-label dev-comment">// get_in_touch</span>
            <h2><span style="color: var(--dev-primary);">#</span> Contact</h2>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4" data-aos="fade-right" data-aos-delay="100">
                <div class="dev-terminal">
                    <div class="dev-terminal-header">
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <div class="dev-terminal-dot"></div>
                        <span class="ms-2" style="color: #94a3b8; font-size: 0.8rem;">contact.json</span>
                    </div>
                    <div class="dev-terminal-body">
                        <div class="dev-keyword mb-3">{ contact_info }</div>

                        @if($email)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="min-width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-envelope" style="color: var(--dev-primary);"></i>
                                </div>
                                <div>
                                    <small style="color: #64748b;">email</small><br>
                                    <a href="mailto:{{ $email }}" style="color: var(--dev-text);">{{ $email }}</a>
                                </div>
                            </div>
                        @endif

                        @if($phone)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="min-width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-telephone" style="color: var(--dev-primary);"></i>
                                </div>
                                <div>
                                    <small style="color: #64748b;">phone</small><br>
                                    <a href="tel:{{ $phone }}" style="color: var(--dev-text);">{{ $phone }}</a>
                                </div>
                            </div>
                        @endif

                        @if($location)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="min-width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-geo-alt" style="color: var(--dev-primary);"></i>
                                </div>
                                <div>
                                    <small style="color: #64748b;">location</small><br>
                                    <span style="color: var(--dev-text);">{{ $location }}</span>
                                </div>
                            </div>
                        @endif

                        @if($socialLinks->count())
                            <div class="mt-4 pt-3" style="border-top: 1px solid var(--dev-border);">
                                <small class="dev-comment">// social_links</small>
                                <div class="d-flex gap-2 mt-2">
                                    @foreach($socialLinks as $link)
                                        <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                           class="dev-btn" style="font-size: 0.8rem; padding: 0.5rem 0.75rem;">
                                            <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="dev-card">
                    <div class="dev-keyword mb-4">// send_message</div>
                    <form action="{{ route('portfolio.contact.submit', $profile->slug ?? '') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 0.5rem; display: block;">name:</label>
                                <input type="text" name="name" class="form-control" required
                                       style="background: var(--dev-bg); border: 1px solid var(--dev-border); color: var(--dev-text); font-family: var(--dev-font); font-size: 0.9rem;"
                                       placeholder="John Doe">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 0.5rem; display: block;">email:</label>
                                <input type="email" name="email" class="form-control" required
                                       style="background: var(--dev-bg); border: 1px solid var(--dev-border); color: var(--dev-text); font-family: var(--dev-font); font-size: 0.9rem;"
                                       placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 0.5rem; display: block;">subject:</label>
                            <input type="text" name="subject" class="form-control"
                                   style="background: var(--dev-bg); border: 1px solid var(--dev-border); color: var(--dev-text); font-family: var(--dev-font); font-size: 0.9rem;"
                                   placeholder="Project Inquiry">
                        </div>
                        <div class="mb-4">
                            <label style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 0.5rem; display: block;">message:</label>
                            <textarea name="message" rows="5" class="form-control" required
                                      style="background: var(--dev-bg); border: 1px solid var(--dev-border); color: var(--dev-text); font-family: var(--dev-font); font-size: 0.9rem; resize: vertical;"
                                      placeholder="Your message here..."></textarea>
                        </div>
                        <button type="submit" class="dev-btn dev-btn-filled">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
