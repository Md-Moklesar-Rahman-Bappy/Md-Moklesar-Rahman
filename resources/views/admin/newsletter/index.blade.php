@extends('layouts.admin')

@section('page_title', 'Newsletter Subscribers')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Newsletter</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Newsletter Subscribers</h4>
        <p class="text-muted mb-0">Manage your newsletter subscriber list.</p>
    </div>
    <a href="{{ route('admin.newsletter.export') }}" class="quick-action-btn" style="background:#10b981;color:#fff;">
        <i class="bi bi-download"></i> Export CSV
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $totalSubscribers ?? 0 }}</div>
                        <div class="stat-label">Total Subscribers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(16,185,129,0.12);color:#10b981;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $activeSubscribers ?? 0 }}</div>
                        <div class="stat-label">Active</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(239,68,68,0.12);color:#ef4444;">
                        <i class="bi bi-person-x"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $unsubscribedCount ?? 0 }}</div>
                        <div class="stat-label">Unsubscribed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Subscribed Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td class="fw-semibold">
                                <i class="bi bi-envelope me-2 text-muted"></i>{{ $subscriber->email }}
                            </td>
                            <td>{{ $subscriber->name ?? '—' }}</td>
                            <td>
                                @if($subscriber->is_active)
                                    <span class="badge bg-success rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Unsubscribed</span>
                                @endif
                            </td>
                            <td>{{ $subscriber->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.newsletter.destroy', $subscriber) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Remove"
                                            onclick="return confirm('Remove this subscriber?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-megaphone display-4 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No subscribers yet</h5>
                                <p class="text-muted mb-0">Subscribers will appear here when they sign up.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($subscribers, 'links'))
    <div class="mt-4">
        {{ $subscribers->links() }}
    </div>
@endif
@endsection
