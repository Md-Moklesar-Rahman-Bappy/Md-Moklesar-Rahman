@extends('layouts.admin')

@section('page_title', 'Add Education')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.education.index') }}" class="text-decoration-none">Education</a></li>
        <li class="breadcrumb-item active">Add Education</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Education</h4>
        <p class="text-muted mb-0">Add a new education entry.</p>
    </div>
    <a href="{{ route('admin.education.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Education
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

<form action="{{ route('admin.education.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-mortarboard me-2" style="color:#6366f1;"></i>Education Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="institution" class="form-label fw-semibold">Institution <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                   id="institution" name="institution"
                                   value="{{ old('institution') }}" required
                                   placeholder="e.g. University of Technology">
                            @error('institution')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="degree" class="form-label fw-semibold">Degree <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('degree') is-invalid @enderror"
                                   id="degree" name="degree"
                                   value="{{ old('degree') }}" required
                                   placeholder="e.g. Bachelor of Science">
                            @error('degree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="group_or_field" class="form-label fw-semibold">Field of Study / Group</label>
                            <input type="text" class="form-control @error('group_or_field') is-invalid @enderror"
                                   id="group_or_field" name="group_or_field"
                                   value="{{ old('group_or_field') }}"
                                   placeholder="e.g. Computer Science">
                            @error('group_or_field')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="result" class="form-label fw-semibold">Result / GPA</label>
                            <input type="text" class="form-control @error('result') is-invalid @enderror"
                                   id="result" name="result"
                                   value="{{ old('result') }}"
                                   placeholder="e.g. 3.8/4.0 or First Class">
                            @error('result')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date" name="start_date"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date" name="end_date"
                                   value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Additional details about your education...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
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
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Tips</h6>
                    <ul class="small text-muted mb-0" style="list-style:none;padding:0;">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>List most recent education first</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Include relevant coursework if applicable</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Add GPA or honors if notable</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.education.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Save Education
        </button>
    </div>
</form>
@endsection
