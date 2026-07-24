@extends('layouts.admin')

@section('page_title', 'Blog Categories')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.blog-posts.index') }}" class="text-decoration-none">Blog</a></li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Blog Categories</h4>
        <p class="text-muted mb-0">Organize your blog posts into categories.</p>
    </div>
    <a href="{{ route('admin.blog-posts.index') }}" class="quick-action-btn" style="background:#e2e8f0;color:#475569;">
        <i class="bi bi-arrow-left"></i> Back to Blog
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Post Count</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr x-data="{ editing: false }">
                                    <td>
                                        <span x-show="!editing" class="fw-semibold">{{ $category->name }}</span>
                                        <form x-show="editing" x-cloak action="{{ route('admin.blog-categories.update', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" class="form-control form-control-sm" name="name"
                                                   value="{{ $category->name }}">
                                        </form>
                                    </td>
                                    <td><code class="small">{{ $category->slug }}</code></td>
                                    <td>{{ $category->parent->name ?? '—' }}</td>
                                    <td>
                                        <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                                            {{ $category->posts_count ?? $category->posts()->count() ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <button x-show="!editing" @click="editing = true" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button x-show="editing" @click="editing = false" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Cancel">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <button x-show="editing" type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Save">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete"
                                                        onclick="return confirm('Delete this category?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No categories yet. Create one to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="glass-card">
            <div class="card-body">
                <h6 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2" style="color:#6366f1;"></i>Add Category</h6>
                @if($errors->any())
                    <div class="alert alert-danger py-2 small">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('admin.blog-categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label fw-semibold">Parent Category</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="">None (Top Level)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn text-white w-100 fw-semibold" style="background:#6366f1;">
                        <i class="bi bi-plus-lg me-1"></i> Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
