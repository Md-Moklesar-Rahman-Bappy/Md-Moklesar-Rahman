@php
$themeSlug = $activeTheme?->slug ?? 'developer';
$activeTheme = $activeTheme ?? \App\Models\Theme::where('is_active', true)->first();
@endphp

@extends("themes.{$themeSlug}.layout")

@section('page_title', 'Contact')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold">Get In Touch</h1>
                <p class="lead text-muted">Have a project in mind? Let's work together.</p>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Contact Information</h4>

                        @if($profile)
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0">Email</h6>
                                    <a href="mailto:{{ $profile->email }}" class="text-decoration-none">{{ $profile->email }}</a>
                                </div>
                            </div>

                            @if($profile->phone)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="bi bi-telephone text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Phone</h6>
                                        <a href="tel:{{ $profile->phone }}" class="text-decoration-none">{{ $profile->phone }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($profile->location)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="bi bi-geo-alt text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Location</h6>
                                        <span>{{ $profile->location }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($profile->socialLinks && $profile->socialLinks->count())
                                <hr class="my-4">
                                <h6 class="mb-3">Follow Me</h6>
                                <div class="d-flex gap-2">
                                    @foreach($profile->socialLinks as $link)
                                        <a href="{{ $link->url }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="{{ $link->platform }}">
                                            <i class="bi bi-{{ strtolower($link->platform) }}"></i>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Send a Message</h4>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('home.contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
