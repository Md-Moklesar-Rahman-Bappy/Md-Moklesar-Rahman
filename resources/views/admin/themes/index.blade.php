@extends('layouts.admin')

@section('page_title', 'Appearance - Themes')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Themes</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Appearance - Themes</h4>
        <p class="text-muted mb-0">Choose and customize the theme for your portfolio.</p>
    </div>
</div>

<div class="row g-4">
    @forelse($themes as $theme)
        <div class="col-lg-4 col-md-6">
            <div class="glass-card h-100 {{ $theme->is_active ? 'border border-3' : '' }}"
                 style="{{ $theme->is_active ? 'border-color:#6366f1;' : '' }}">
                <div class="position-relative">
                    <div class="rounded-top-3" style="height:180px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-palette display-1 text-white opacity-50"></i>
                    </div>
                    @if($theme->is_active)
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill text-white" style="background:#6366f1;">
                            <i class="bi bi-check-circle me-1"></i> Active Theme
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-1">{{ $theme->name }}</h6>
                    <p class="text-muted small mb-2">{{ $theme->description ?? 'No description available.' }}</p>
                    <div class="d-flex gap-3 mb-3">
                        <small class="text-muted">
                            <i class="bi bi-tag me-1"></i>v{{ $theme->version ?? '1.0' }}
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i>{{ $theme->author ?? 'Unknown' }}
                        </small>
                    </div>
                    <div class="d-flex gap-2">
                        @if($theme->is_active)
                            <a href="{{ route('admin.themes.customize', $theme) }}" class="btn btn-sm text-white flex-grow-1" style="background:#6366f1;">
                                <i class="bi bi-sliders me-1"></i> Customize
                            </a>
                        @else
                            <form action="{{ route('admin.themes.activate', $theme) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                    <i class="bi bi-check-lg me-1"></i> Activate
                                </button>
                            </form>
                        @endif
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#themePreviewModal{{ $theme->id }}" title="Preview">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="themePreviewModal{{ $theme->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title fw-bold">{{ $theme->name }} Preview</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-5" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);min-height:300px;display:flex;align-items:center;justify-content:center;">
                        <div class="text-white">
                            <i class="bi bi-palette display-1 mb-3 d-block opacity-50"></i>
                            <h4>{{ $theme->name }}</h4>
                            <p class="mb-0">{{ $theme->description ?? 'A beautiful theme for your portfolio.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="glass-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-palette display-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No themes available</h5>
                    <p class="text-muted mb-0">Install themes to customize your portfolio's appearance.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
