@extends('layouts.admin')

@section('page_title', 'Project Categories')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-decoration-none">Projects</a></li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Project Categories</h4>
        <p class="text-muted mb-0">Organize your projects into categories.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Projects
    </a>
</div>

<div class="glass-card mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2" style="color:#6366f1;"></i>Add Category</h6>
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
        <form action="{{ route('admin.project-categories.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name"
                           value="{{ old('name') }}" required placeholder="Category name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                           id="slug" name="slug"
                           value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn w-100 text-white" style="background:#6366f1;">
                        <i class="bi bi-plus-lg me-1"></i> Add Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Project Count</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="fw-semibold">{{ $category->name }}</td>
                            <td><code class="small">{{ $category->slug }}</code></td>
                            <td>
                                <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                                    {{ $category->projects_count ?? $category->projects->count() }} projects
                                </span>
                            </td>
                            <td class="text-end">
                                <div x-data="{ editing: false }">
                                    <button @click="editing = !editing" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <div x-show="editing" x-transition class="mt-2 mb-3 p-3 rounded" style="background:#f8fafc;">
                                        <form action="{{ route('admin.project-categories.update', $category) }}" method="POST" class="row g-2">
                                            @csrf @method('PUT')
                                            <div class="col-8">
                                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $category->name }}">
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-sm btn-primary text-white w-100" style="background:#6366f1;">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div x-data="{ show: false }" class="d-inline-block">
                                    <button @click="show = true" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <div x-show="show" class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5);">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title fw-bold">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" @click="show = false"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete the category <strong>{{ $category->name }}</strong>?
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button @click="show = false" class="btn btn-light">Cancel</button>
                                                    <form action="{{ route('admin.project-categories.destroy', $category) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-tags display-4 d-block mb-2" style="color:#e2e8f0;"></i>
                                No categories found. Create one above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
