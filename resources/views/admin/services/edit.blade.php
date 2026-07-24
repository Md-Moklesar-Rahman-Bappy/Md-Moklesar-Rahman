@extends('layouts.admin')

@section('page_title', 'Edit Service')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}" class="text-decoration-none">Services</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Service</h4>
        <p class="text-muted mb-0">Update <strong>{{ $service->title }}</strong>.</p>
    </div>
    <a href="{{ route('admin.services.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Services
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

<form action="{{ route('admin.services.update', $service) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-gear me-2" style="color:#6366f1;"></i>Service Information</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title', $service->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="slug" class="form-label fw-semibold">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug"
                                   value="{{ old('slug', $service->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="icon" class="form-label fw-semibold">Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon"
                                   value="{{ old('icon', $service->icon) }}">
                            <div class="form-text">Bootstrap Icons class.</div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">Price ($)</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price"
                                   value="{{ old('price', $service->price) }}" step="0.01" min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="features" class="form-label fw-semibold">Features</label>
                            <textarea class="form-control @error('features') is-invalid @enderror"
                                      id="features" name="features" rows="5">{{ old('features', $service->features) }}</textarea>
                            <div class="form-text">One feature per line.</div>
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', $service->sort_order) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-eye me-2" style="color:#f59e0b;"></i>Preview</h6>
                    <div class="text-center p-3 rounded" style="background:#f8fafc;">
                        <div class="mb-2" style="font-size:2rem;color:#6366f1;">
                            <i class="{{ old('icon', $service->icon ?? 'bi bi-gear') }}"></i>
                        </div>
                        <div class="fw-bold">{{ old('title', $service->title) }}</div>
                        <div class="small text-muted mb-2">{{ Str::limit(old('description', $service->description), 60) }}</div>
                        @if(old('price', $service->price))
                            <div class="fw-bold" style="color:#6366f1;">${{ number_format(old('price', $service->price), 2) }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Info</h6>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar3 me-2"></i>Created: {{ $service->created_at->format('M d, Y') }}
                    </div>
                    <div class="small text-muted">
                        <i class="bi bi-clock-history me-2"></i>Updated: {{ $service->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.services.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Update Service
        </button>
    </div>
</form>
@endsection
