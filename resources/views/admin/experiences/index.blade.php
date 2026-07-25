@extends('layouts.admin')

@section('page_title', 'Work Experience')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Experience</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Work Experience</h4>
        <p class="text-muted mb-0">Manage your professional work history.</p>
    </div>
    <a href="{{ route('admin.experiences.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
        <i class="bi bi-plus-lg"></i> Add Experience
    </a>
</div>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Position</th>
                        <th>Location</th>
                        <th>Duration</th>
                        <th>Technologies</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($experiences as $experience)
                        <tr>
                            <td class="fw-semibold">{{ $experience->company_name }}</td>
                            <td>{{ $experience->position }}</td>
                            <td>
                                @if($experience->location)
                                    <i class="bi bi-geo-alt me-1 text-muted"></i>{{ $experience->location }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }}
                                    —
                                    @if($experience->is_current)
                                        Present
                                    @else
                                        {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'N/A' }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                @php
                                    $techItems = is_array($experience->technologies) ? $experience->technologies : (is_string($experience->technologies) ? explode(',', $experience->technologies) : []);
                                @endphp
                                @if(count($techItems) > 0)
                                    @foreach($techItems as $tech)
                                        <span class="badge bg-light text-dark me-1 mb-1">{{ trim($tech) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.experiences.edit', $experience) }}" class="btn btn-sm btn-outline-primary">
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
                                                    Are you sure you want to delete your experience at <strong>{{ $experience->company_name }}</strong>? This action cannot be undone.
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button @click="show = false" class="btn btn-light">Cancel</button>
                                                    <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST">
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
                                <i class="bi bi-briefcase display-4 d-block mb-2" style="color:#e2e8f0;"></i>
                                No experience entries found. <a href="{{ route('admin.experiences.create') }}" class="text-decoration-none" style="color:#6366f1;">Add your first experience</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
