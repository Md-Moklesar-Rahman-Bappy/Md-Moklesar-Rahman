@php
    $email = $profile->email ?? '';
    $phone = $profile->phone ?? '';
    $location = $profile->location ?? '';
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="contact" class="fre-section">
    <div class="container">
        <div class="fre-section-header" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-envelope"></i> Contact</span>
            <h2>Get In Touch</h2>
            <p>Ready to start a project? Let's talk about it.</p>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4" data-aos="fade-right" data-aos-delay="100">
                <div class="fre-card h-100">
                    <h5 style="font-weight: 700; margin-bottom: 1.5rem;">Contact Info</h5>

                    @if($email)
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="fre-icon-box" style="min-width: 52px; width: 52px; height: 52px; font-size: 1.1rem; margin: 0;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <small style="color: var(--fre-text); font-weight: 500;">Email</small><br>
                                <a href="mailto:{{ $email }}" style="font-weight: 600;">{{ $email }}</a>
                            </div>
                        </div>
                    @endif

                    @if($phone)
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="fre-icon-box" style="min-width: 52px; width: 52px; height: 52px; font-size: 1.1rem; margin: 0; background: rgba(249,115,22,0.08); color: var(--fre-secondary);">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <small style="color: var(--fre-text); font-weight: 500;">Phone</small><br>
                                <a href="tel:{{ $phone }}" style="font-weight: 600;">{{ $phone }}</a>
                            </div>
                        </div>
                    @endif

                    @if($location)
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="fre-icon-box" style="min-width: 52px; width: 52px; height: 52px; font-size: 1.1rem; margin: 0; background: rgba(16,185,129,0.08); color: var(--fre-accent);">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <small style="color: var(--fre-text); font-weight: 500;">Location</small><br>
                                <span style="font-weight: 600;">{{ $location }}</span>
                            </div>
                        </div>
                    @endif

                    @if($socialLinks->count())
                        <div class="pt-3" style="border-top: 1px solid rgba(0,0,0,0.06);">
                            <small style="color: var(--fre-text); font-weight: 600; display: block; margin-bottom: 0.75rem;">Follow Me</small>
                            <div class="social-links">
                                @foreach($socialLinks as $link)
                                    <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="fre-card">
                    <h5 style="font-weight: 700; margin-bottom: 1.5rem;">Send a Message</h5>
                    <form action="{{ route('home.contact.submit', $profile->slug ?? '') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Your Name</label>
                                <input type="text" name="name" class="form-control" required
                                       style="border-radius: 10px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1rem;"
                                       placeholder="John Doe">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Your Email</label>
                                <input type="email" name="email" class="form-control" required
                                       style="border-radius: 10px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1rem;"
                                       placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Subject</label>
                            <input type="text" name="subject" class="form-control"
                                   style="border-radius: 10px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1rem;"
                                   placeholder="Project Inquiry">
                        </div>
                        <div class="mb-4">
                            <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Message</label>
                            <textarea name="message" rows="5" class="form-control" required
                                      style="border-radius: 10px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1rem; resize: vertical;"
                                      placeholder="Tell me about your project..."></textarea>
                        </div>
                        <button type="submit" class="fre-btn">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
