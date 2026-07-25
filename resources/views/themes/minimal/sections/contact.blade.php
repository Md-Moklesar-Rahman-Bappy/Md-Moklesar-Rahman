<section id="contact" class="section-padding" style="background: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="min-line"></div>
                <h2 class="section-title">Contact</h2>
                <p class="section-subtitle">Let's connect</p>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <p class="text-muted small mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.7rem;">Email</p>
                        <a href="mailto:{{ $profile->email ?? '' }}" class="min-link">{{ $profile->email ?? '' }}</a>
                    </div>
                    <div class="col-md-6 mb-4">
                        <p class="text-muted small mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.7rem;">Phone</p>
                        <a href="tel:{{ $profile->phone ?? '' }}" class="min-link">{{ $profile->phone ?? '' }}</a>
                    </div>
                    <div class="col-md-6 mb-4">
                        <p class="text-muted small mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.7rem;">Location</p>
                        <span class="fw-medium" style="font-size: 0.95rem;">{{ $profile->location ?? '' }}</span>
                    </div>
                    <div class="col-md-6 mb-4">
                        <p class="text-muted small mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.7rem;">Social</p>
                        <div class="d-flex gap-3">
                            @foreach($profile->socialLinks ?? [] as $link)
                            <a href="{{ $link->url }}" class="min-link" target="_blank">{{ $link->platform }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="mt-5 pt-4" style="border-top: 1px solid #f3f4f6;">
                    <form action="{{ route('home.contact.submit', $profile->slug ?? '') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Name" style="border: none; border-bottom: 1px solid #e5e7eb; border-radius: 0; padding-left: 0; background: transparent;" required>
                                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Email" style="border: none; border-bottom: 1px solid #e5e7eb; border-radius: 0; padding-left: 0; background: transparent;" required>
                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" style="border: none; border-bottom: 1px solid #e5e7eb; border-radius: 0; padding-left: 0; background: transparent;">
                                @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="form-control" rows="4" placeholder="Message" style="border: none; border-bottom: 1px solid #e5e7eb; border-radius: 0; padding-left: 0; background: transparent; resize: none;" required></textarea>
                                @error('message')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn px-0 fw-semibold" style="color: var(--text-dark); border: none; background: none; text-transform: lowercase; border-bottom: 1px solid var(--text-dark); padding-bottom: 2px;">send message <i class="bi bi-arrow-right ms-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
