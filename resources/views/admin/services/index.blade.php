@extends('layouts.admin')

@section('page_title', 'Services')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Services</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Services</h4>
        <p class="text-muted mb-0">Manage the services you offer.</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
        <i class="bi bi-plus-lg"></i> Add Service
    </a>
</div>

<div class="row g-4">
    @forelse($services as $service)
        <div class="col-lg-4 col-md-6">
            <div class="glass-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon me-3" style="background:rgba(99,102,241,0.12);color:{{ $service->is_active ? '#6366f1' : '#94a3b8' }};">
                            <i class="{{ $service->icon ?? 'bi bi-gear' }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{ $service->title }}</h6>
                            @if($service->slug)
                                <small class="text-muted">{{ $service->slug }}</small>
                            @endif
                        </div>
                        @if($service->is_active)
                            <span class="badge bg-success rounded-pill">Active</span>
                        @else
                            <span class="badge bg-secondary rounded-pill">Inactive</span>
                        @endif
                    </div>
                    <p class="text-muted small flex-grow-1">{{ Str::limit($service->description, 120) }}</p>
                    @php
                        $featureItems = is_array($service->features) ? $service->features : (is_string($service->features) ? explode("\n", $service->features) : []);
                    @endphp
                    @if(count($featureItems) > 0)
                        <div class="mb-3">
                            @foreach(array_slice($featureItems, 0, 4) as $feature)
                                @if(trim($feature))
                                    <div class="small mb-1"><i class="bi bi-check2 text-success me-2"></i>{{ trim($feature) }}</div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if($service->price)
                        <div class="mb-3">
                            <span class="fw-bold" style="color:#6366f1;font-size:1.1rem;">${{ number_format($service->price, 2) }}</span>
                        </div>
                    @endif
                    <div class="d-flex gap-1 mt-auto">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="bi bi-pencil me-1"></i> Edit
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
                                            Are you sure you want to delete <strong>{{ $service->title }}</strong>? This action cannot be undone.
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button @click="show = false" class="btn btn-light">Cancel</button>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST">
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
                    <i class="bi bi-gear display-4 d-block mb-2" style="color:#e2e8f0;"></i>
                    <p class="text-muted mb-3">No services found.</p>
                    <a href="{{ route('admin.services.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
                        <i class="bi bi-plus-lg"></i> Add Your First Service
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
