@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h4>
        <p class="text-muted mb-0">Here's an overview of your portfolio.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.projects.create') }}" class="quick-action-btn" style="background:#6366f1;color:#fff;">
            <i class="bi bi-plus-lg"></i> Add Project
        </a>
        <a href="{{ route('admin.blog.create') }}" class="quick-action-btn" style="background:#10b981;color:#fff;">
            <i class="bi bi-pencil-square"></i> Write Blog
        </a>
        <a href="{{ route('admin.messages.index') }}" class="quick-action-btn" style="background:#f59e0b;color:#fff;">
            <i class="bi bi-envelope"></i> Messages
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                        <i class="bi bi-folder"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['projects'] }}</div>
                        <div class="stat-label">Total Projects</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(16,185,129,0.12);color:#10b981;">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['blog_posts'] }}</div>
                        <div class="stat-label">Blog Posts</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <div class="stat-value">
                            {{ $stats['messages'] }}
                            @if($stats['unread_messages'] > 0)
                                <span class="badge bg-danger rounded-pill ms-1" style="font-size:0.65rem;vertical-align:middle;">{{ $stats['unread_messages'] }} new</span>
                            @endif
                        </div>
                        <div class="stat-label">Messages</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(236,72,153,0.12);color:#ec4899;">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
                        <div class="stat-label">Total Views</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body text-center py-3">
                <div class="stat-value" style="font-size:1.3rem;">{{ $stats['skills'] }}</div>
                <div class="stat-label">Skills</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body text-center py-3">
                <div class="stat-value" style="font-size:1.3rem;">{{ $stats['experiences'] }}</div>
                <div class="stat-label">Experiences</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body text-center py-3">
                <div class="stat-value" style="font-size:1.3rem;">{{ $stats['services'] }}</div>
                <div class="stat-label">Services</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body text-center py-3">
                <div class="stat-value" style="font-size:1.3rem;">{{ $stats['certifications'] }}</div>
                <div class="stat-label">Certifications</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Content Overview</h6>
                <div style="position:relative;height:280px;">
                    <canvas id="contentChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Visitors (Last 7 Days)</h6>
                <div style="position:relative;height:280px;">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Recent Messages</h6>
                    <a href="{{ route('admin.messages.index') }}" class="text-decoration-none small" style="color:#6366f1;">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['recent_messages'] as $message)
                                <tr>
                                    <td>{{ $message->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($message->subject ?? '', 30) }}</td>
                                    <td>{{ $message->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No messages yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Recent Projects</h6>
                    <a href="{{ route('admin.projects.index') }}" class="text-decoration-none small" style="color:#6366f1;">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['recent_projects'] as $project)
                                <tr>
                                    <td>{{ Str::limit($project->title ?? '', 35) }}</td>
                                    <td>
                                        <span class="badge {{ ($project->is_published ?? false) ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                            {{ ($project->is_published ?? false) ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $project->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No projects yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const textColor = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    const gridColor = document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';

    new Chart(document.getElementById('contentChart'), {
        type: 'bar',
        data: {
            labels: ['Projects', 'Blog Posts', 'Skills', 'Services'],
            datasets: [{
                label: 'Count',
                data: [
                    {{ $stats['projects'] }},
                    {{ $stats['blog_posts'] }},
                    {{ $stats['skills'] }},
                    {{ $stats['services'] }}
                ],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(236, 72, 153, 0.8)'
                ],
                borderColor: [
                    '#6366f1', '#10b981', '#f59e0b', '#ec4899'
                ],
                borderWidth: 2,
                borderRadius: 8,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: textColor, stepSize: 1 },
                    grid: { color: gridColor }
                },
                x: {
                    ticks: { color: textColor },
                    grid: { display: false }
                }
            }
        }
    });

    new Chart(document.getElementById('visitorsChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Visitors',
                data: [12, 19, 8, 15, 22, 14, 10],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: textColor },
                    grid: { color: gridColor }
                },
                x: {
                    ticks: { color: textColor },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush
