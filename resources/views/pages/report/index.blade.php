@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Laporan & Analitik</h4>
                    <p class="text-muted mb-0">Statistik dan analisis data kependudukan</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('report.export.excel') }}" class="btn btn-success">
                        <i class="ti ti-file-spreadsheet me-1"></i>Export Excel
                    </a>
                    <a href="{{ route('report.export.pdf') }}" class="btn btn-danger">
                        <i class="ti ti-file-pdf me-1"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-primary me-3">
                            <i class="ti ti-users text-primary f-24"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalResidents) }}</h3>
                            <p class="text-muted mb-0">Total Penduduk Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-info me-3">
                            <i class="ti ti-man text-info f-24"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format($maleCount) }}</h3>
                            <p class="text-muted mb-0">Laki-laki ({{ $totalResidents > 0 ? round($maleCount / $totalResidents * 100, 1) : 0 }}%)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-danger me-3">
                            <i class="ti ti-woman text-danger f-24"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ number_format($femaleCount) }}</h3>
                            <p class="text-muted mb-0">Perempuan ({{ $totalResidents > 0 ? round($femaleCount / $totalResidents * 100, 1) : 0 }}%)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Age Pyramid -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-chart-bar me-2 text-primary"></i>Piramida Umur</h5>
                </div>
                <div class="card-body">
                    <div id="agePyramidChart"></div>
                </div>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-chart-pie me-2 text-primary"></i>Jenis Kelamin</h5>
                </div>
                <div class="card-body">
                    <div id="genderChart"></div>
                </div>
            </div>
        </div>

        <!-- Marital Status -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-heart me-2 text-primary"></i>Status Perkawinan</h5>
                </div>
                <div class="card-body">
                    <div id="maritalChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Religion Distribution -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-building-church me-2 text-primary"></i>Distribusi Agama</h5>
                </div>
                <div class="card-body">
                    <div id="religionChart"></div>
                </div>
            </div>
        </div>

        <!-- Occupation Distribution -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-briefcase me-2 text-primary"></i>Distribusi Pekerjaan (Top 10)</h5>
                </div>
                <div class="card-body">
                    <div id="occupationChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Analysis -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-trending-up me-2 text-primary"></i>Trend 12 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Age Pyramid Chart
    var agePyramidOptions = {
        series: [{
            name: 'Laki-laki',
            data: @json(array_map(fn($g) => -$g['male'], $ageGroups))
        }, {
            name: 'Perempuan',
            data: @json(array_map(fn($g) => $g['female'], $ageGroups))
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            background: 'transparent'
        },
        colors: ['#3b82f6', '#ec4899'],
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '80%'
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 1,
            colors: ["#1f2937"]
        },
        grid: {
            borderColor: '#374151',
            xaxis: {
                lines: { show: false }
            }
        },
        yaxis: {
            labels: {
                style: { colors: '#9ca3af' }
            }
        },
        xaxis: {
            categories: @json(array_map(fn($g) => $g['range'], $ageGroups)),
            labels: {
                style: { colors: '#9ca3af' },
                formatter: function(val) {
                    return Math.abs(val);
                }
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(val) {
                    return Math.abs(val) + ' orang';
                }
            }
        },
        legend: {
            position: 'top',
            labels: { colors: '#9ca3af' }
        }
    };
    new ApexCharts(document.querySelector("#agePyramidChart"), agePyramidOptions).render();

    // Gender Chart
    var genderOptions = {
        series: [{{ $maleCount }}, {{ $femaleCount }}],
        chart: {
            type: 'donut',
            height: 250,
            background: 'transparent'
        },
        labels: ['Laki-laki', 'Perempuan'],
        colors: ['#3b82f6', '#ec4899'],
        legend: {
            position: 'bottom',
            labels: { colors: '#9ca3af' }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#9ca3af'
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val.toFixed(1) + '%';
            }
        }
    };
    new ApexCharts(document.querySelector("#genderChart"), genderOptions).render();

    // Marital Status Chart
    var maritalOptions = {
        series: @json($maritalData->pluck('total')->toArray()),
        chart: {
            type: 'pie',
            height: 250,
            background: 'transparent'
        },
        labels: @json($maritalData->pluck('marital_status')->map(fn($s) => $maritalLabels[$s] ?? $s)->toArray()),
        colors: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
        legend: {
            position: 'bottom',
            labels: { colors: '#9ca3af' }
        }
    };
    new ApexCharts(document.querySelector("#maritalChart"), maritalOptions).render();

    // Religion Chart
    var religionOptions = {
        series: [{
            name: 'Jumlah',
            data: @json($religionData->pluck('total')->toArray())
        }],
        chart: {
            type: 'bar',
            height: 300,
            background: 'transparent'
        },
        colors: ['#10b981'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true
            }
        },
        dataLabels: {
            enabled: true,
            style: { colors: ['#fff'] }
        },
        xaxis: {
            categories: @json($religionData->pluck('religion')->map(fn($r) => $r ?? 'Tidak Diketahui')->toArray()),
            labels: { style: { colors: '#9ca3af' } }
        },
        yaxis: {
            labels: { style: { colors: '#9ca3af' } }
        },
        grid: {
            borderColor: '#374151'
        }
    };
    new ApexCharts(document.querySelector("#religionChart"), religionOptions).render();

    // Occupation Chart
    var occupationOptions = {
        series: [{
            name: 'Jumlah',
            data: @json($occupationData->pluck('total')->toArray())
        }],
        chart: {
            type: 'bar',
            height: 300,
            background: 'transparent'
        },
        colors: ['#f59e0b'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true
            }
        },
        dataLabels: {
            enabled: true,
            style: { colors: ['#fff'] }
        },
        xaxis: {
            categories: @json($occupationData->pluck('occupation')->map(fn($o) => $o ?? 'Tidak Bekerja')->toArray()),
            labels: { style: { colors: '#9ca3af' } }
        },
        yaxis: {
            labels: { style: { colors: '#9ca3af' } }
        },
        grid: {
            borderColor: '#374151'
        }
    };
    new ApexCharts(document.querySelector("#occupationChart"), occupationOptions).render();

    // Trend Chart
    var trendOptions = {
        series: [{
            name: 'Penduduk Baru',
            data: @json($residentTrend->pluck('total')->toArray())
        }, {
            name: 'Pengaduan',
            data: @json($complaintTrend->pluck('total')->toArray())
        }],
        chart: {
            type: 'line',
            height: 300,
            background: 'transparent'
        },
        colors: ['#10b981', '#f59e0b'],
        stroke: {
            curve: 'smooth',
            width: 3
        },
        xaxis: {
            categories: @json($residentTrend->pluck('month')->toArray()),
            labels: { style: { colors: '#9ca3af' } }
        },
        yaxis: {
            labels: { style: { colors: '#9ca3af' } }
        },
        grid: {
            borderColor: '#374151'
        },
        legend: {
            position: 'top',
            labels: { colors: '#9ca3af' }
        },
        tooltip: {
            theme: 'dark'
        }
    };
    new ApexCharts(document.querySelector("#trendChart"), trendOptions).render();
});
</script>
@endsection
