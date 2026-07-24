@extends('layouts.admin')

@section('page_title', 'Add Certification')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.certifications.index') }}" class="text-decoration-none">Certifications</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Certification</h4>
        <p class="text-muted mb-0">Add a new professional certification or credential.</p>
    </div>
    <a href="{{ route('admin.certifications.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
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

<form action="{{ route('admin.certifications.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-award me-2" style="color:#6366f1;"></i>Certification Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Certification Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name') }}" required placeholder="e.g. AWS Solutions Architect">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="organization" class="form-label fw-semibold">Issuing Organization <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('organization') is-invalid @enderror"
                                   id="organization" name="organization"
                                   value="{{ old('organization') }}" required placeholder="e.g. Amazon Web Services">
                            @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="issue_date" class="form-label fw-semibold">Issue Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('issue_date') is-invalid @enderror"
                                   id="issue_date" name="issue_date"
                                   value="{{ old('issue_date') }}" required>
                            @error('issue_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="expiry_date" class="form-label fw-semibold">Expiry Date</label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                   id="expiry_date" name="expiry_date"
                                   value="{{ old('expiry_date') }}">
                            <div class="form-text">Leave empty if no expiry.</div>
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="credential_id" class="form-label fw-semibold">Credential ID</label>
                            <input type="text" class="form-control @error('credential_id') is-invalid @enderror"
                                   id="credential_id" name="credential_id"
                                   value="{{ old('credential_id') }}" placeholder="e.g. ABC123XYZ">
                            @error('credential_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="verification_url" class="form-label fw-semibold">Verification URL</label>
                            <input type="url" class="form-control @error('verification_url') is-invalid @enderror"
                                   id="verification_url" name="verification_url"
                                   value="{{ old('verification_url') }}" placeholder="https://...">
                            @error('verification_url')
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
                    <h6 class="fw-bold mb-4"><i class="bi bi-file-earmark-pdf me-2" style="color:#ef4444;"></i>Certificate File</h6>
                    <input type="file" class="form-control @error('certificate_file') is-invalid @enderror"
                           id="certificate_file" name="certificate_file"
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div class="form-text">PDF, JPG, PNG. Max 5MB.</div>
                    @error('certificate_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                <i class="bi bi-check-lg me-1"></i> Save Certification
            </button>
        </div>
    </div>
</form>
@endsection
