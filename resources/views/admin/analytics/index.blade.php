@extends('layouts.admin')

@section('page_title', 'Analytics Dashboard')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Analytics</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Analytics Dashboard</h4>
        <p class="text-muted mb-0">Monitor your portfolio traffic and visitor insights.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <div class="stat-card">
                    <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ number_format($totalVisitors ?? 0) }}</div>
                        <div class="stat-label">Total Visitors</div>
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
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ number_format($todayViews ?? 0) }}</div>
                        <div class="stat-label">Today's Views</div>
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
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ number_format($uniqueVisitors ?? 0) }}</div>
                        <div class="stat-label">Unique Visitors</div>
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
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $topCountry ?? 'N/A' }}</div>
                        <div class="stat-label">Top Country</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Visitors Over Last 30 Days</h6>
                <div style="position:relative;height:300px;">
                    <canvas id="visitorsLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top Browsers</h6>
                <div style="position:relative;height:300px;">
                    <canvas id="browsersDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-12">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top Countries</h6>
                <div style="position:relative;height:280px;">
                    <canvas id="countriesBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Recent Visitors</h6>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Country</th>
                        <th>Device</th>
                        <th>Browser</th>
                        <th>Page</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVisitors ?? [] as $visitor)
                        <tr>
                            <td><code class="small">{{ $visitor->ip_address ?? '—' }}</code></td>
                            <td>{{ $visitor->country ?? '—' }}</td>
                            <td>{{ $visitor->device ?? '—' }}</td>
                            <td>{{ $visitor->browser ?? '—' }}</td>
                            <td class="text-truncate" style="max-width:200px;">{{ $visitor->page ?? '—' }}</td>
                            <td>{{ $visitor->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No visitor data available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const textColor = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    const gridColor = document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';

    const visitorLabels = @json($visitorLabels ?? []);
    const visitorData = @json($visitorData ?? []);
    const browserLabels = @json($browserLabels ?? ['Chrome', 'Firefox', 'Safari', 'Edge', 'Other']);
    const browserData = @json($browserData ?? []);
    const countryLabels = @json($countryLabels ?? []);
    const countryData = @json($countryData ?? []);

    new Chart(document.getElementById('visitorsLineChart'), {
        type: 'line',
        data: {
            labels: visitorLabels,
            datasets: [{
                label: 'Visitors',
                data: visitorData,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } },
                x: { ticks: { color: textColor, maxRotation: 45 }, grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('browsersDoughnutChart'), {
        type: 'doughnut',
        data: {
            labels: browserLabels,
            datasets: [{
                data: browserData,
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#64748b'],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { color: textColor, padding: 16, usePointStyle: true } }
            }
        }
    });

    new Chart(document.getElementById('countriesBarChart'), {
        type: 'bar',
        data: {
            labels: countryLabels,
            datasets: [{
                label: 'Visitors',
                data: countryData,
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } },
                y: { ticks: { color: textColor }, grid: { display: false } }
            }
        }
    });
});
</script>
@endpush
