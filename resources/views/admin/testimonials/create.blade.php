@extends('layouts.admin')

@section('page_title', 'Add Testimonial')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}" class="text-decoration-none">Testimonials</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Testimonial</h4>
        <p class="text-muted mb-0">Add a new client testimonial.</p>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back
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

<form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-chat-quote me-2" style="color:#6366f1;"></i>Testimonial Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="client_name" class="form-label fw-semibold">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                   id="client_name" name="client_name"
                                   value="{{ old('client_name') }}" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="company" class="form-label fw-semibold">Company</label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror"
                                   id="company" name="company"
                                   value="{{ old('company') }}" placeholder="e.g. Acme Inc.">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label fw-semibold">Position</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position"
                                   value="{{ old('position') }}" placeholder="e.g. CEO">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="review" class="form-label fw-semibold">Review <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('review') is-invalid @enderror"
                                      id="review" name="review" rows="5" required
                                      placeholder="Write the client's testimonial...">{{ old('review') }}</textarea>
                            @error('review')
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
                    <h6 class="fw-bold mb-4"><i class="bi bi-star me-2" style="color:#f59e0b;"></i>Rating</h6>
                    <div x-data="{ rating: {{ old('rating', 5) }} }">
                        <input type="hidden" name="rating" :value="rating">
                        <div class="d-flex gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" @click="rating = {{ $i }}" class="btn btn-link p-0 border-0">
                                    <i class="bi fs-3"
                                       :class="rating >= {{ $i }} ? 'bi-star-fill text-warning' : 'bi-star text-muted'"></i>
                                </button>
                            @endfor
                        </div>
                        <small class="text-muted">Click to set rating (1-5)</small>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-image me-2" style="color:#10b981;"></i>Profile Image</h6>
                    <div class="mb-3">
                        <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                               id="profile_image" name="profile_image" accept="image/*"
                               x-data="{ fileName: '' }" @change="fileName = $event.target.files[0]?.name || ''">
                        <div class="form-text">JPEG, PNG, JPG, or WebP. Max 2MB.</div>
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div x-show="fileName" class="text-success small">
                        <i class="bi bi-check-circle me-1"></i> <span x-text="fileName"></span>
                    </div>
                </div>
            </div>

            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Settings</h6>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                               id="sort_order" name="sort_order"
                               value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;">
                <i class="bi bi-check-lg me-1"></i> Save Testimonial
            </button>
        </div>
    </div>
</form>
@endsection
