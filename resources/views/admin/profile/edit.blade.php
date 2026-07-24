@extends('layouts.admin')

@section('page_title', 'Edit Profile')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}" class="text-decoration-none">Profile</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Profile</h4>
        <p class="text-muted mb-0">Update your personal information and preferences.</p>
    </div>
    <a href="{{ route('admin.profile.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Profile
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-person me-2" style="color:#6366f1;"></i>Personal Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                   id="full_name" name="full_name"
                                   value="{{ old('full_name', $profile->full_name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="designation" class="form-label fw-semibold">Designation</label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                   id="designation" name="designation"
                                   value="{{ old('designation', $profile->designation) }}"
                                   placeholder="e.g. Full Stack Developer">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="tagline" class="form-label fw-semibold">Tagline</label>
                            <input type="text" class="form-control @error('tagline') is-invalid @enderror"
                                   id="tagline" name="tagline"
                                   value="{{ old('tagline', $profile->tagline) }}"
                                   placeholder="A short tagline about yourself">
                            @error('tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="bio" class="form-label fw-semibold">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio" name="bio" rows="5"
                                      placeholder="Tell us about yourself...">{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="experience_years" class="form-label fw-semibold">Experience (Years)</label>
                            <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                                   id="experience_years" name="experience_years"
                                   value="{{ old('experience_years', $profile->experience_years) }}"
                                   min="0" max="50">
                            @error('experience_years')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                   id="location" name="location"
                                   value="{{ old('location', $profile->location) }}"
                                   placeholder="e.g. New York, USA">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="website" class="form-label fw-semibold">Website</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror"
                                   id="website" name="website"
                                   value="{{ old('website', $profile->website) }}"
                                   placeholder="https://example.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-envelope me-2" style="color:#10b981;"></i>Contact Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email', $profile->email) }}"
                                   placeholder="you@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone"
                                   value="{{ old('phone', $profile->phone) }}"
                                   placeholder="+1 234 567 890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-image me-2" style="color:#f59e0b;"></i>Media</h6>

                    <div class="mb-3">
                        <label for="profile_image" class="form-label fw-semibold">Profile Image</label>
                        @if($profile->profile_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Profile"
                                     class="rounded-circle" width="80" height="80" style="object-fit:cover;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                               id="profile_image" name="profile_image" accept="image/*">
                        <div class="form-text">JPEG, PNG, JPG, GIF, or WebP. Max 2MB.</div>
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label fw-semibold">Cover Image</label>
                        @if($profile->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $profile->cover_image) }}" alt="Cover"
                                     class="rounded" width="100%" height="100" style="object-fit:cover;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                               id="cover_image" name="cover_image" accept="image/*">
                        <div class="form-text">JPEG, PNG, JPG, GIF, or WebP. Max 4MB.</div>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label for="resume" class="form-label fw-semibold">Resume / CV</label>
                        @if($profile->resume_path)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank"
                                   class="text-decoration-none small" style="color:#6366f1;">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Current Resume
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('resume') is-invalid @enderror"
                               id="resume" name="resume" accept=".pdf,.doc,.docx">
                        <div class="form-text">PDF, DOC, or DOCX. Max 5MB.</div>
                        @error('resume')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Quick Info</h6>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar3 me-2"></i>Created: {{ $profile->created_at->format('M d, Y') }}
                    </div>
                    <div class="small text-muted mb-0">
                        <i class="bi bi-clock-history me-2"></i>Updated: {{ $profile->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.profile.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Update Profile
        </button>
    </div>
</form>
@endsection
