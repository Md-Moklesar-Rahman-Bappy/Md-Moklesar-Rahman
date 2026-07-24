@php
    $email = $profile->email ?? '';
    $phone = $profile->phone ?? '';
    $location = $profile->location ?? '';
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="contact" class="cre-section">
    <div class="container">
        <div class="cre-section-header" data-aos="fade-up">
            <span class="section-label"><i class="bi bi-envelope"></i> Contact</span>
            <h2>Let's Connect</h2>
            <p>Have a project in mind? I'd love to hear about it.</p>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4" data-aos="fade-right" data-aos-delay="100">
                <div class="cre-card h-100">
                    <h5 style="font-weight: 700; margin-bottom: 1.5rem;">Contact Information</h5>

                    @if($email)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="cre-icon-blob" style="min-width: 50px; width: 50px; height: 50px; font-size: 1.1rem; margin: 0;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <small style="color: var(--cre-text);">Email</small><br>
                                <a href="mailto:{{ $email }}" style="font-weight: 600;">{{ $email }}</a>
                            </div>
                        </div>
                    @endif

                    @if($phone)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="cre-icon-blob" style="min-width: 50px; width: 50px; height: 50px; font-size: 1.1rem; margin: 0; background: var(--cre-gradient-alt);">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <small style="color: var(--cre-text);">Phone</small><br>
                                <a href="tel:{{ $phone }}" style="font-weight: 600;">{{ $phone }}</a>
                            </div>
                        </div>
                    @endif

                    @if($location)
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="cre-icon-blob" style="min-width: 50px; width: 50px; height: 50px; font-size: 1.1rem; margin: 0; background: linear-gradient(135deg, var(--cre-accent), var(--cre-primary));">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <small style="color: var(--cre-text);">Location</small><br>
                                <span style="font-weight: 600;">{{ $location }}</span>
                            </div>
                        </div>
                    @endif

                    @if($socialLinks->count())
                        <div class="social-links mt-3 pt-3" style="border-top: 1px solid rgba(0,0,0,0.06);">
                            @foreach($socialLinks as $link)
                                <a href="{{ $link->url ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-{{ $link->icon ?? 'link-45deg' }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                <div class="cre-card">
                    <form action="{{ route('portfolio.contact.submit', $profile->slug ?? '') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Your Name</label>
                                <input type="text" name="name" class="form-control" required
                                       style="border-radius: 14px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1.25rem;"
                                       placeholder="John Doe">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Your Email</label>
                                <input type="email" name="email" class="form-control" required
                                       style="border-radius: 14px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1.25rem;"
                                       placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Subject</label>
                            <input type="text" name="subject" class="form-control"
                                   style="border-radius: 14px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1.25rem;"
                                   placeholder="Project Inquiry">
                        </div>
                        <div class="mb-4">
                            <label style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: block;">Message</label>
                            <textarea name="message" rows="5" class="form-control" required
                                      style="border-radius: 14px; border: 2px solid rgba(0,0,0,0.06); padding: 0.75rem 1.25rem; resize: vertical;"
                                      placeholder="Tell me about your project..."></textarea>
                        </div>
                        <button type="submit" class="cre-btn">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
