@extends('layouts.admin')

@section('page_title', 'Skills Management')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Skills</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Skills Management</h4>
        <p class="text-muted mb-0">Organize and manage your technical skills.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="quick-action-btn" style="background:#f59e0b;color:#fff;" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="bi bi-tags"></i> Skill Categories
        </button>
        <a href="{{ route('admin.skills.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
            <i class="bi bi-plus-lg"></i> Add Skill
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Skills</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(16,185,129,0.12);color:#10b981;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['active'] }}</div>
                        <div class="stat-label">Active Skills</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b;">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['categories'] }}</div>
                        <div class="stat-label">Categories</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(6,182,212,0.12);color:#06b6d4;">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['avg'] }}%</div>
                        <div class="stat-label">Avg Proficiency</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($categories->count())
<div class="mb-4">
    <h6 class="text-muted text-uppercase fw-semibold mb-3" style="font-size:0.75rem;letter-spacing:0.05em;">Categories</h6>
    <div class="row g-3">
        @foreach($categories as $category)
            <div class="col-xl-3 col-md-6">
                <div class="glass-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="rounded d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:{{ $category->color ?? '#6366f1' }};color:#fff;">
                                <i class="{{ $category->icon ?? 'bi bi-tag' }}"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="fw-semibold text-truncate">{{ $category->name }}</div>
                                <small class="text-muted">{{ $category->skills_count }} skills</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3">
                            <div class="progress flex-grow-1" style="height:5px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width:{{ round($category->skills_avg_percentage ?? 0) }}%;background:{{ $category->color ?? '#6366f1' }};"></div>
                            </div>
                            <small class="text-muted fw-semibold">{{ round($category->skills_avg_percentage ?? 0) }}%</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="glass-card">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-list-check me-2" style="color:#6366f1;"></i>All Skills</h6>
            <form action="{{ route('admin.skills.index') }}" method="GET" class="d-flex gap-2" style="min-width:260px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent" style="border-right:0;"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search skills..."
                           value="{{ request('search') }}" style="border-left:0;">
                </div>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.skills.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Skill</th>
                        <th>Category</th>
                        <th style="min-width:180px;">Proficiency</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skills as $skill)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                          style="width:34px;height:34px;background:rgba(99,102,241,0.1);color:{{ $skill->color ?? '#6366f1' }};font-size:0.9rem;">
                                        <i class="{{ $skill->icon ?? 'bi bi-lightning-charge' }}"></i>
                                    </span>
                                    <div>
                                        <div class="fw-semibold">{{ $skill->name }}</div>
                                        <small class="text-muted d-lg-none d-block">
                                            {{ $skill->category?->name ?? 'Uncategorized' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($skill->category)
                                    <span class="badge rounded-pill px-3 py-2 fw-normal"
                                          style="background:rgba(99,102,241,0.1);color:#6366f1;">
                                        {{ $skill->category->name }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:6px;">
                                        <div class="progress-bar" role="progressbar"
                                             style="width:{{ $skill->percentage ?? 0 }}%;background:{{ $skill->color ?? '#6366f1' }};"
                                             aria-valuenow="{{ $skill->percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted fw-semibold" style="min-width:38px;text-align:right;">
                                        {{ $skill->percentage ?? 0 }}%
                                    </small>
                                </div>
                            </td>
                            <td>
                                @if($skill->is_active)
                                    <span class="badge rounded-pill px-3 py-2 fw-normal" style="background:rgba(16,185,129,0.12);color:#10b981;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-2 fw-normal" style="background:#f1f5f9;color:#64748b;">
                                        <i class="bi bi-dash-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <div x-data="{ show: false }" class="d-inline-block">
                                    <button @click="show = true" class="btn btn-sm btn-outline-danger" title="Delete">
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
                                                    Are you sure you want to delete <strong>{{ $skill->name }}</strong>? This action cannot be undone.
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button @click="show = false" class="btn btn-light">Cancel</button>
                                                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST">
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
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-lightning-charge d-block mb-3" style="font-size:2.5rem;color:#e2e8f0;"></i>
                                @if(request()->filled('search'))
                                    <p class="text-muted mb-0">No skills match "<strong>{{ request('search') }}</strong>".</p>
                                @else
                                    <p class="text-muted mb-2">No skills found yet.</p>
                                    <a href="{{ route('admin.skills.create') }}" class="btn btn-sm text-white px-4" style="background:#6366f1;">
                                        <i class="bi bi-plus-lg me-1"></i> Add your first skill
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $skills->links() }}
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="categoryModalLabel">
                    <i class="bi bi-tags me-2" style="color:#f59e0b;"></i>Manage Skill Categories
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" x-data="{ newCategory: '' }">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                        <small>{{ session('success') }}</small>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.skill-categories.store') }}" method="POST" class="mb-4">
                    @csrf
                    <label class="form-label fw-semibold small text-muted text-uppercase" style="font-size:0.75rem;">Add New Category</label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="e.g. Frameworks, Design, Tools"
                               x-model="newCategory" required>
                        <button type="submit" class="btn text-white" style="background:#6366f1;" :disabled="!newCategory.trim()">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>
                </form>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <small>{{ $errors->first() }}</small>
                    </div>
                @endif

                <div class="list-group list-group-flush">
                    @forelse($categories as $category)
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded"
                                      style="width:30px;height:30px;background:{{ $category->color ?? '#6366f1' }};color:#fff;">
                                    <i class="{{ $category->icon ?? 'bi bi-tag' }}" style="font-size:0.8rem;"></i>
                                </span>
                                <div>
                                    <span class="fw-semibold">{{ $category->name }}</span>
                                    <small class="text-muted ms-1">({{ $category->skills_count }} skills)</small>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <form action="{{ route('admin.skill-categories.update', $category) }}" method="POST" class="d-flex gap-1">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ $category->name }}" style="width:150px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Save"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('admin.skill-categories.destroy', $category) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete category &quot;{{ $category->name }}&quot;? Skills will remain but become uncategorized.')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-tags d-block mb-2" style="font-size:1.8rem;color:#e2e8f0;"></i>
                            No categories yet. Create one above.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
