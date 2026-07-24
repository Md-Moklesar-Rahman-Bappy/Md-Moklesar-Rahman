@php
    $email = $profile->email ?? '';
    $phone = $profile->phone ?? '';
    $location = $profile->location ?? '';
    $socialLinks = $profile->socialLinks ?? collect();
@endphp

<section id="contact" class="mod-section mod-section-alt">
    <div class="container">
        <div class="mod-section-header" data-aos="fade-up">
            <span class="section-badge">Contact</span>
            <h2>Let's Work Together</h2>
            <p>Have a project in mind? Let's discuss how I can help.</p>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4" data-aos="fade-right" data-aos-delay="100">
                <div class="mod-card h-100">
                    <h5 style="font-size: 1.1rem; margin-bottom: 1.5rem;">Get In Touch</h5>

                    @if($email)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="mod-icon-circle" style="min-width: 44px; width: 44px; height: 44px; font-size: 1rem;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <small style="color: var(--mod-text);">Email</small><br>
                                <a href="mailto:{{ $email }}" style="font-weight: 500;">{{ $email }}</a>
                            </div>
                        </div>
                    @endif

                    @if($phone)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="mod-icon-circle" style="min-width: 44px; width: 44px; height: 44px; font-size: 1rem;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <small style="color: var(--mod-text);">Phone</small><br>
                                <a href="tel:{{ $phone }}" style="font-weight: 500;">{{ $phone }}</a>
                            </div>
                        </div>
                    @endif

                    @if($location)
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="mod-icon-circle" style="min-width: 44px; width: 44px; height: 44px; font-size: 1rem;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <small style="color: var(--mod-text);">Location</small><br>
                                <span style="font-weight: 500;">{{ $location }}</span>
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
                <div class="mod-card">
                    <form action="{{ route('home.contact.submit', $profile->slug ?? '') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0.5rem; display: block;">Your Name</label>
                                <input type="text" name="name" class="form-control" required
                                       style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 0.75rem 1rem;"
                                       placeholder="John Doe">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0.5rem; display: block;">Your Email</label>
                                <input type="email" name="email" class="form-control" required
                                       style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 0.75rem 1rem;"
                                       placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0.5rem; display: block;">Subject</label>
                            <input type="text" name="subject" class="form-control"
                                   style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 0.75rem 1rem;"
                                   placeholder="Project Inquiry">
                        </div>
                        <div class="mb-4">
                            <label style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0.5rem; display: block;">Message</label>
                            <textarea name="message" rows="5" class="form-control" required
                                      style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); padding: 0.75rem 1rem; resize: vertical;"
                                      placeholder="Tell me about your project..."></textarea>
                        </div>
                        <button type="submit" class="mod-btn">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
