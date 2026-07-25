@extends('layouts.admin')

@section('page_title', 'Create Blog Category')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.blog-posts.index') }}" class="text-decoration-none">Blog</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}" class="text-decoration-none">Categories</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Create Blog Category</h4>
        <p class="text-muted mb-0">Add a new category to organize your blog posts.</p>
    </div>
    <a href="{{ route('admin.blog-categories.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
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

<form action="{{ route('admin.blog-categories.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-tag me-2" style="color:#6366f1;"></i>Category Details</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name') }}" required
                                   placeholder="Category name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="An optional description for this category...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="parent_id" class="form-label fw-semibold">Parent Category</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">None (Top Level)</option>
                                @foreach($parentCategories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-search me-2" style="color:#f59e0b;"></i>SEO Settings</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title"
                                   value="{{ old('meta_title') }}" maxlength="60"
                                   placeholder="Optional SEO title">
                            <div class="form-text">Recommended: 50-60 characters.</div>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3"
                                      maxlength="160"
                                      placeholder="Optional SEO description...">{{ old('meta_description') }}</textarea>
                            <div class="form-text">Recommended: 150-160 characters.</div>
                            @error('meta_description')
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
                    <h6 class="fw-bold mb-4"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Info</h6>
                    <p class="small text-muted mb-3">
                        Categories help organize your blog posts. You can nest categories by selecting a parent.
                    </p>
                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#6366f1;">
                        <i class="bi bi-check-lg me-1"></i> Create Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
