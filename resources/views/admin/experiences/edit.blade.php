@extends('layouts.admin')

@section('page_title', 'Edit Experience')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.experiences.index') }}" class="text-decoration-none">Experience</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Experience</h4>
        <p class="text-muted mb-0">Update your experience at <strong>{{ $experience->company_name }}</strong>.</p>
    </div>
    <a href="{{ route('admin.experiences.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Experience
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

<form action="{{ route('admin.experiences.update', $experience) }}" method="POST"
      x-data="{ isCurrent: {{ old('is_current', $experience->is_current) ? 'true' : 'false' }} }">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-briefcase me-2" style="color:#6366f1;"></i>Work Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="company_name" class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                   id="company_name" name="company_name"
                                   value="{{ old('company_name', $experience->company_name) }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position"
                                   value="{{ old('position', $experience->position) }}" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                   id="location" name="location"
                                   value="{{ old('location', $experience->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="technologies" class="form-label fw-semibold">Technologies</label>
                            <input type="text" class="form-control @error('technologies') is-invalid @enderror"
                                   id="technologies" name="technologies"
                                   value="{{ old('technologies', $experience->technologies) }}">
                            <div class="form-text">Comma-separated list.</div>
                            @error('technologies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date" name="start_date"
                                   value="{{ old('start_date', $experience->start_date) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4" x-show="!isCurrent" x-transition>
                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date" name="end_date"
                                   value="{{ old('end_date', $experience->end_date) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_current" name="is_current" value="1"
                                       x-model="isCurrent" {{ old('is_current', $experience->is_current) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_current">Currently Working Here</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5">{{ old('description', $experience->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', $experience->sort_order) }}" min="0">
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
                    <h6 class="fw-bold mb-3">Info</h6>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar3 me-2"></i>Created: {{ $experience->created_at->format('M d, Y') }}
                    </div>
                    <div class="small text-muted">
                        <i class="bi bi-clock-history me-2"></i>Updated: {{ $experience->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.experiences.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Update Experience
        </button>
    </div>
</form>
@endsection
