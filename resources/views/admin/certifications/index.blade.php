@extends('layouts.admin')

@section('page_title', 'Certifications')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Certifications</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Certifications</h4>
        <p class="text-muted mb-0">Manage your professional certifications and credentials.</p>
    </div>
    <a href="{{ route('admin.certifications.create') }}" class="quick-action-btn text-white" style="background:#6366f1;">
        <i class="bi bi-plus-lg"></i> Add Certification
    </a>
</div>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Organization</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certifications as $certification)
                        <tr>
                            <td class="fw-semibold">{{ $certification->name }}</td>
                            <td>{{ $certification->organization }}</td>
                            <td>{{ $certification->issue_date ? \Carbon\Carbon::parse($certification->issue_date)->format('M d, Y') : '—' }}</td>
                            <td>{{ $certification->expiry_date ? \Carbon\Carbon::parse($certification->expiry_date)->format('M d, Y') : 'No Expiry' }}</td>
                            <td>
                                @php
                                    $isExpired = $certification->expiry_date && \Carbon\Carbon::parse($certification->expiry_date)->isPast();
                                @endphp
                                @if($isExpired)
                                    <span class="badge bg-danger rounded-pill">Expired</span>
                                @elseif($certification->is_active)
                                    <span class="badge bg-success rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    @if($certification->credential_id && $certification->verification_url)
                                        <a href="{{ $certification->verification_url }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill" title="Verify">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.certifications.edit', $certification) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.certifications.destroy', $certification) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete" onclick="return confirm('Delete this certification?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-award display-4 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No certifications yet</h5>
                                <p class="text-muted mb-3">Add your first certification to showcase your credentials.</p>
                                <a href="{{ route('admin.certifications.create') }}" class="quick-action-btn text-white" style="background:#6366f1;">
                                    <i class="bi bi-plus-lg"></i> Add Certification
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($certifications, 'links'))
    <div class="mt-4">
        {{ $certifications->links() }}
    </div>
@endif
@endsection
