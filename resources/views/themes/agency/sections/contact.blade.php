<section id="contact" class="section-padding">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="agency-line mx-auto"></div>
            <h2 class="section-title">Get In Touch</h2>
            <p class="section-subtitle mx-auto">Have a project in mind? Let's work together</p>
        </div>
        <div class="row g-5 mt-4">
            <div class="col-lg-5" data-aos="fade-right">
                <h5 class="fw-bold mb-4">Contact Information</h5>
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; background: var(--bg-light); color: var(--primary);">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <a href="mailto:{{ $profile->email ?? '' }}" class="text-muted text-decoration-none">{{ $profile->email ?? '' }}</a>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; background: var(--bg-light); color: var(--primary);">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Phone</h6>
                        <a href="tel:{{ $profile->phone ?? '' }}" class="text-muted text-decoration-none">{{ $profile->phone ?? '' }}</a>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; background: var(--bg-light); color: var(--primary);">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Location</h6>
                        <p class="text-muted mb-0">{{ $profile->location ?? '' }}</p>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    @foreach($profile->socialLinks ?? [] as $link)
                    <a href="{{ $link->url }}" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: var(--bg-light); color: var(--primary); transition: all 0.3s;" target="_blank" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff'" onmouseout="this.style.background='var(--bg-light)'; this.style.color='var(--primary)'">
                        <i class="bi bi-{{ $link->platform }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <form class="bg-white rounded-4 p-5" style="box-shadow: 0 5px 30px rgba(0,0,0,0.06);" action="{{ route('home.contact.submit', $profile->slug ?? '') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Your Name</label>
                            <input type="text" name="name" class="form-control py-3 rounded-3" placeholder="John Doe" required>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" name="email" class="form-control py-3 rounded-3" placeholder="john@example.com" required>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Subject</label>
                            <input type="text" name="subject" class="form-control py-3 rounded-3" placeholder="Project Inquiry">
                            @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Message</label>
                            <textarea name="message" class="form-control py-3 rounded-3" rows="5" placeholder="Tell me about your project..." required></textarea>
                            @error('message')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-agency w-100 py-3">Send Message <i class="bi bi-send ms-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
