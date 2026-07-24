@extends('layouts.admin')

@section('page_title', 'Add Service')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}" class="text-decoration-none">Services</a></li>
        <li class="breadcrumb-item active">Add Service</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Service</h4>
        <p class="text-muted mb-0">Create a new service offering.</p>
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

<form action="{{ route('admin.services.store') }}" method="POST">
    @csrf
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
                                   value="{{ old('title') }}" required
                                   placeholder="e.g. Web Development">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="slug" class="form-label fw-semibold">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug"
                                   value="{{ old('slug') }}"
                                   oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Describe the service...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="icon" class="form-label fw-semibold">Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon"
                                   value="{{ old('icon') }}" placeholder="e.g. bi bi-code-slash">
                            <div class="form-text">Bootstrap Icons class.</div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">Price ($)</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price"
                                   value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="features" class="form-label fw-semibold">Features</label>
                            <textarea class="form-control @error('features') is-invalid @enderror"
                                      id="features" name="features" rows="5"
                                      placeholder="One feature per line...">{{ old('features') }}</textarea>
                            <div class="form-text">Enter one feature per line.</div>
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
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
                            <i class="{{ old('icon', 'bi bi-gear') }}"></i>
                        </div>
                        <div class="fw-bold">{{ old('title', 'Service Title') }}</div>
                        <div class="small text-muted mb-2">{{ Str::limit(old('description', 'Service description goes here...'), 60) }}</div>
                        @if(old('price'))
                            <div class="fw-bold" style="color:#6366f1;">${{ number_format(old('price', 0), 2) }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Tips</h6>
                    <ul class="small text-muted mb-0" style="list-style:none;padding:0;">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Use clear, descriptive titles</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>List key features for each service</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Set price to 0 for custom quotes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.services.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Save Service
        </button>
    </div>
</form>
@endsection
