@extends('layouts.admin')

@section('page_title', 'Projects Portfolio')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Projects</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Projects Portfolio</h4>
        <p class="text-muted mb-0">Manage your portfolio projects.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
        <i class="bi bi-plus-lg"></i> Add Project
    </a>
</div>

<div class="glass-card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.projects.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Category</label>
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Search</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search projects..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm w-100 text-white" style="background:#6366f1;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($projects as $project)
        <div class="col-lg-4 col-md-6">
            <div class="glass-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="position-relative mb-3 rounded overflow-hidden" style="height:180px;background:#f1f5f9;">
                        @if($project->thumbnail)
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                                 class="w-100 h-100" style="object-fit:cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="bi bi-folder display-4" style="color:#e2e8f0;"></i>
                            </div>
                        @endif
                        @if($project->is_featured)
                            <span class="badge position-absolute top-0 end-0 m-2" style="background:#f59e0b;color:#fff;">
                                <i class="bi bi-star-fill me-1"></i> Featured
                            </span>
                        @endif
                    </div>
                    <div class="mb-2">
                        @if($project->category)
                            <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:#6366f1;font-size:0.7rem;">
                                {{ $project->category->name }}
                            </span>
                        @endif
                        @if($project->is_published)
                            <span class="badge bg-success rounded-pill" style="font-size:0.7rem;">Published</span>
                        @else
                            <span class="badge bg-secondary rounded-pill" style="font-size:0.7rem;">Draft</span>
                        @endif
                    </div>
                    <h6 class="fw-bold mb-1">{{ $project->title }}</h6>
                    <p class="text-muted small flex-grow-1">{{ Str::limit($project->short_description ?? $project->description, 80) }}</p>
                    @php
                        $techItems = is_array($project->technologies) ? $project->technologies : (is_string($project->technologies) ? explode(',', $project->technologies) : []);
                    @endphp
                    @if(count($techItems) > 0)
                        <div class="mb-3">
                            @foreach(array_slice($techItems, 0, 4) as $tech)
                                <span class="badge bg-light text-dark me-1" style="font-size:0.65rem;">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="d-flex gap-1 mt-auto">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        @if($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        @endif
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
                                            Are you sure you want to delete <strong>{{ $project->title }}</strong>? This action cannot be undone.
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button @click="show = false" class="btn btn-light">Cancel</button>
                                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
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
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="glass-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-folder display-4 d-block mb-2" style="color:#e2e8f0;"></i>
                    <p class="text-muted mb-3">No projects found.</p>
                    <a href="{{ route('admin.projects.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
                        <i class="bi bi-plus-lg"></i> Create Your First Project
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($projects->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $projects->withQueryString()->links() }}
    </div>
@endif
@endsection
