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
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Skills Management</h4>
        <p class="text-muted mb-0">Manage your technical skills and categories.</p>
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

<div class="row g-4 mb-4">
    @forelse($categories ?? [] as $category)
        <div class="col-lg-3 col-md-6">
            <div class="glass-card h-100">
                <div class="card-body">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                            <i class="bi bi-tag"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $category->skills_count ?? $category->skills->count() }}</div>
                            <div class="stat-label">{{ $category->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-lg-3 col-md-6">
            <div class="glass-card h-100">
                <div class="card-body text-center py-3">
                    <div class="stat-value" style="font-size:1.3rem;">{{ $skills->count() ?? 0 }}</div>
                    <div class="stat-label">Total Skills</div>
                </div>
            </div>
        </div>
    @endforelse
</div>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Percentage</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skills as $skill)
                        <tr>
                            <td class="fw-semibold">
                                <span style="color:{{ $skill->color ?? '#6366f1' }};">
                                    <i class="{{ $skill->icon ?? 'bi bi-check2-circle' }} me-1"></i>
                                </span>
                                {{ $skill->name }}
                            </td>
                            <td>
                                @if($skill->category)
                                    <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                                        {{ $skill->category->name }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:6px;width:100px;">
                                        <div class="progress-bar" role="progressbar"
                                             style="width:{{ $skill->percentage }}%;background:{{ $skill->color ?? '#6366f1' }};"
                                             aria-valuenow="{{ $skill->percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted fw-semibold">{{ $skill->percentage }}%</small>
                                </div>
                            </td>
                            <td><code class="small">{{ $skill->icon ?? '—' }}</code></td>
                            <td>
                                @if($skill->is_active)
                                    <span class="badge bg-success rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
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
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-lightning display-4 d-block mb-2" style="color:#e2e8f0;"></i>
                                No skills found. <a href="{{ route('admin.skills.create') }}" class="text-decoration-none" style="color:#6366f1;">Add your first skill</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="categoryModalLabel">
                    <i class="bi bi-tags me-2" style="color:#6366f1;"></i>Manage Skill Categories
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" x-data="{ newCategory: '' }">
                <form action="{{ route('admin.skill-categories.store') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="New category name..."
                               x-model="newCategory" required>
                        <button type="submit" class="btn text-white" style="background:#6366f1;" :disabled="!newCategory.trim()">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>
                </form>

                <div class="list-group list-group-flush">
                    @forelse($categories ?? [] as $category)
                        <div class="list-group-item d-flex align-items-center justify-content-between px-0">
                            <div>
                                <span class="fw-semibold">{{ $category->name }}</span>
                                <small class="text-muted ms-2">({{ $category->skills_count ?? $category->skills->count() }} skills)</small>
                            </div>
                            <div class="d-flex gap-1">
                                <form action="{{ route('admin.skill-categories.update', $category) }}" method="POST" class="d-flex gap-1">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ $category->name }}" style="width:150px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('admin.skill-categories.destroy', $category) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">No categories yet. Create one above.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
