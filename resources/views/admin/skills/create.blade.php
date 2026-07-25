@extends('layouts.admin')

@section('page_title', 'Add Skill')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.skills.index') }}" class="text-decoration-none">Skills</a></li>
        <li class="breadcrumb-item active">Add Skill</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Skill</h4>
        <p class="text-muted mb-0">Add a new skill to your portfolio.</p>
    </div>
    <a href="{{ route('admin.skills.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Skills
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

<form action="{{ route('admin.skills.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-4"><i class="bi bi-lightning me-2" style="color:#6366f1;"></i>Skill Information</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label fw-semibold">Skill Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name') }}" required
                                   placeholder="e.g. Laravel, React, PHP">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label fw-semibold">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="icon" class="form-label fw-semibold">Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon"
                                   value="{{ old('icon') }}"
                                   placeholder="e.g. bi bi-code-slash">
                            <div class="form-text">Bootstrap Icons class. <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer" style="color:#6366f1;">Browse icons</a></div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="color" class="form-label fw-semibold">Color</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                       id="color" name="color"
                                       value="{{ old('color', '#6366f1') }}">
                                <input type="text" class="form-control" value="{{ old('color', '#6366f1') }}"
                                       id="colorText" oninput="document.getElementById('color').value=this.value">
                            </div>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="percentage" class="form-label fw-semibold">Proficiency: <span id="percVal">{{ old('percentage', 50) }}</span>%</label>
                            <input type="range" class="form-range @error('percentage') is-invalid @enderror"
                                   id="percentage" name="percentage"
                                   min="0" max="100" step="5"
                                   value="{{ old('percentage', 50) }}"
                                   oninput="document.getElementById('percVal').textContent=this.value">
                            @error('percentage')
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
                        <div class="mb-2" style="font-size:2rem;color:{{ old('color', '#6366f1') }};">
                            <i class="{{ old('icon', 'bi bi-check2-circle') }}"></i>
                        </div>
                        <div class="fw-bold">{{ old('name', 'Skill Name') }}</div>
                        <div class="progress mt-2" style="height:6px;">
                            <div class="progress-bar" style="width:{{ old('percentage', 50) }}%;background:{{ old('color', '#6366f1') }};"></div>
                        </div>
                        <small class="text-muted">{{ old('percentage', 50) }}%</small>
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2" style="color:#6366f1;"></i>Tips</h6>
                    <ul class="small text-muted mb-0" style="list-style:none;padding:0;">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Use consistent icon classes</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Group skills by category</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>Set percentage to reflect proficiency</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.skills.index') }}" class="btn btn-light px-4">Cancel</a>
        <button type="submit" class="btn px-4 text-white" style="background:#6366f1;">
            <i class="bi bi-check-lg me-1"></i> Save Skill
        </button>
    </div>
</form>
@endsection
