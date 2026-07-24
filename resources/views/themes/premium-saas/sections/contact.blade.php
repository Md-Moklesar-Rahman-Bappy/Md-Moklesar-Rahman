<section id="contact" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 rounded-pill fw-medium" style="font-size: 0.8rem;">Contact</span>
            <h2 class="section-title">Let's Build Something Great</h2>
            <p class="section-subtitle mx-auto" style="max-width: 600px;">Ready to start your next project? Let's talk.</p>
        </div>
        <div class="row g-5 mt-4">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="feature-card h-100">
                    <h5 class="fw-bold mb-4">Get In Touch</h5>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon flex-shrink-0" style="background: linear-gradient(135deg, rgba(124,58,237,0.1), rgba(59,130,246,0.1)); color: var(--primary); width: 50px; height: 50px; font-size: 1.1rem;">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-1">Email</p>
                            <a href="mailto:{{ $profile->email ?? '' }}" class="fw-medium text-decoration-none" style="color: var(--text-dark);">{{ $profile->email ?? '' }}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon flex-shrink-0" style="background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(6,182,212,0.1)); color: var(--secondary); width: 50px; height: 50px; font-size: 1.1rem;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-1">Phone</p>
                            <a href="tel:{{ $profile->phone ?? '' }}" class="fw-medium text-decoration-none" style="color: var(--text-dark);">{{ $profile->phone ?? '' }}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon flex-shrink-0" style="background: linear-gradient(135deg, rgba(6,182,212,0.1), rgba(124,58,237,0.1)); color: var(--accent); width: 50px; height: 50px; font-size: 1.1rem;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-1">Location</p>
                            <span class="fw-medium">{{ $profile->location ?? '' }}</span>
                        </div>
                    </div>
                    <hr style="border-color: #f1f5f9;">
                    <p class="small text-muted mb-3">Follow me on</p>
                    <div class="d-flex gap-2">
                        @foreach($profile->socialLinks ?? [] as $link)
                        <a href="{{ $link->url }}" class="social-link" target="_blank"><i class="bi bi-{{ $link->platform }}"></i></a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="feature-card">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Full Name</label>
                                <input type="text" class="form-control py-3 rounded-3" placeholder="John Doe" required style="border: 1px solid #e2e8f0;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Email Address</label>
                                <input type="email" class="form-control py-3 rounded-3" placeholder="john@example.com" required style="border: 1px solid #e2e8f0;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Subject</label>
                                <input type="text" class="form-control py-3 rounded-3" placeholder="Project Inquiry" required style="border: 1px solid #e2e8f0;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Budget</label>
                                <select class="form-select py-3 rounded-3" style="border: 1px solid #e2e8f0;">
                                    <option>Select budget range</option>
                                    <option>Under $1,000</option>
                                    <option>$1,000 - $5,000</option>
                                    <option>$5,000 - $10,000</option>
                                    <option>$10,000+</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium small">Message</label>
                                <textarea class="form-control py-3 rounded-3" rows="5" placeholder="Tell me about your project..." required style="border: 1px solid #e2e8f0;"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-saas w-100 py-3 rounded-3 fw-semibold">Send Message <i class="bi bi-send ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section py-5" style="position: relative; z-index: 1;">
    <div class="container position-relative" style="z-index: 2;">
        <div class="text-center py-4" data-aos="zoom-in">
            <h3 class="text-white fw-bold mb-3">Ready to Start Your Next Project?</h3>
            <p class="text-white-50 mb-4" style="max-width: 500px; margin: 0 auto;">Let's collaborate and build something amazing together. Get in touch today!</p>
            <a href="#contact" class="btn btn-saas" style="background: #fff; color: var(--primary);">Get Started <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>
