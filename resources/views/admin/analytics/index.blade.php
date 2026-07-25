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
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm" style="width:auto;" onchange="window.location.href='{{ route('admin.analytics.index') }}?days='+this.value">
            <option value="7" {{ ($days ?? 30) == 7 ? 'selected' : '' }}>Last 7 days</option>
            <option value="30" {{ ($days ?? 30) == 30 ? 'selected' : '' }}>Last 30 days</option>
            <option value="90" {{ ($days ?? 30) == 90 ? 'selected' : '' }}>Last 90 days</option>
            <option value="365" {{ ($days ?? 30) == 365 ? 'selected' : '' }}>Last year</option>
        </select>
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
                        <div class="stat-value">{{ number_format($totalViews ?? 0) }}</div>
                        <div class="stat-label">Total Views</div>
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
                    <div class="stat-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b;">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ number_format(($topCountries ?? collect())->count()) }}</div>
                        <div class="stat-label">Countries</div>
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
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ number_format(($browsers ?? collect())->count()) }}</div>
                        <div class="stat-label">Browsers</div>
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
                <h6 class="fw-bold mb-3">Views Over Last {{ $days ?? 30 }} Days</h6>
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
    <div class="col-lg-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top Countries</h6>
                <div style="position:relative;height:280px;">
                    <canvas id="countriesBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Devices</h6>
                <div style="position:relative;height:280px;">
                    <canvas id="devicesDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-12">
        <div class="glass-card h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top Pages</h6>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th class="text-end">Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topPages ?? [] as $page)
                                <tr>
                                    <td><code class="small">{{ $page->url ?? '—' }}</code></td>
                                    <td class="text-end"><span class="badge bg-primary">{{ number_format($page->views ?? 0) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted">No page data available yet.</td>
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
    const textColor = '#64748b';
    const gridColor = 'rgba(0,0,0,0.06)';

    @php
        $vLabels = $viewsPerDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toArray();
        $vData = $viewsPerDay->pluck('views')->toArray();
        $bLabels = $browsers->pluck('browser')->toArray();
        $bData = $browsers->pluck('views')->toArray();
        $cLabels = $topCountries->pluck('country')->toArray();
        $cData = $topCountries->pluck('views')->toArray();
        $dLabels = $devices->pluck('device')->toArray();
        $dData = $devices->pluck('views')->toArray();
    @endphp

    const visitorLabels = @json($vLabels);
    const visitorData = @json($vData);
    const browserLabels = @json($bLabels);
    const browserData = @json($bData);
    const countryLabels = @json($cLabels);
    const countryData = @json($cData);
    const deviceLabels = @json($dLabels);
    const deviceData = @json($dData);

    new Chart(document.getElementById('visitorsLineChart'), {
        type: 'line',
        data: {
            labels: visitorLabels,
            datasets: [{
                label: 'Views',
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
            labels: browserLabels.length ? browserLabels : ['No Data'],
            datasets: [{
                data: browserData.length ? browserData : [1],
                backgroundColor: browserData.length ? ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#64748b', '#8b5cf6', '#14b8a6'] : ['#e2e8f0'],
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
            labels: countryLabels.length ? countryLabels : ['No Data'],
            datasets: [{
                label: 'Visitors',
                data: countryData.length ? countryData : [0],
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

    new Chart(document.getElementById('devicesDoughnutChart'), {
        type: 'doughnut',
        data: {
            labels: deviceLabels.length ? deviceLabels : ['No Data'],
            datasets: [{
                data: deviceData.length ? deviceData : [1],
                backgroundColor: deviceData.length ? ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#64748b'] : ['#e2e8f0'],
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
});
</script>
@endsection
