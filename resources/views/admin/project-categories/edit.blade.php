@extends('layouts.admin')

@section('page_title', 'Edit Project Category')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-decoration-none">Projects</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.project-categories.index') }}" class="text-decoration-none">Categories</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Project Category</h4>
        <p class="text-muted mb-0">Editing: {{ $projectCategory->name }}</p>
    </div>
    <a href="{{ route('admin.project-categories.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
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

<form action="{{ route('admin.project-categories.update', $projectCategory) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-tag me-2" style="color:#6366f1;"></i>Category Details</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', $projectCategory->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4">{{ old('description', $projectCategory->description) }}</textarea>
                            @error('description')
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
                    <h6 class="fw-bold mb-3">Category Info</h6>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-hash me-2"></i>Slug: <code>{{ $projectCategory->slug }}</code>
                    </div>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar3 me-2"></i>Created: {{ $projectCategory->created_at->format('M d, Y') }}
                    </div>
                    <div class="small text-muted mb-0">
                        <i class="bi bi-clock-history me-2"></i>Updated: {{ $projectCategory->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;">
                        <i class="bi bi-check-lg me-1"></i> Update Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
