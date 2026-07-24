<section id="contact" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="corp-divider"></div>
                <h2 class="section-title">Contact</h2>
                <p class="section-subtitle">Let's discuss your project requirements</p>
                <div class="bg-white border p-4 mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: var(--primary); color: #fff;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Email</small>
                            <a href="mailto:{{ $profile->email ?? '' }}" class="text-dark text-decoration-none fw-medium">{{ $profile->email ?? '' }}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: var(--primary); color: #fff;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Phone</small>
                            <a href="tel:{{ $profile->phone ?? '' }}" class="text-dark text-decoration-none fw-medium">{{ $profile->phone ?? '' }}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: var(--primary); color: #fff;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Location</small>
                            <span class="fw-medium">{{ $profile->location ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    @foreach($profile->socialLinks ?? [] as $link)
                    <a href="{{ $link->url }}" class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--bg-light); color: var(--primary); border: 1px solid #e2e8f0; transition: all 0.3s;" target="_blank" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff'; this.style.borderColor='var(--primary)'" onmouseout="this.style.background='var(--bg-light)'; this.style.color='var(--primary)'; this.style.borderColor='#e2e8f0'">
                        <i class="bi bi-{{ $link->platform }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7 mt-4 mt-lg-0" data-aos="fade-left">
                <form class="bg-white border p-5">
                    <h5 class="fw-bold mb-4">Send a Message</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Full Name</label>
                            <input type="text" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-medium">Email Address</label>
                            <input type="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium">Subject</label>
                            <input type="text" class="form-control" placeholder="Inquiry Subject" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Your message..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-corp">Send Inquiry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
