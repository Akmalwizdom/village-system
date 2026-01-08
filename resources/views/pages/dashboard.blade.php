@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Welcome Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1 fw-bold">Selamat Datang, {{ Auth::user()->name }}!</h4>
                            <p class="text-muted mb-0">
                                @if($isAdmin)
                                    Kelola data desa dan pantau aktivitas sistem
                                @else
                                    Akses layanan dan informasi desa
                                @endif
                            </p>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="badge bg-light-primary border border-primary px-3 py-2">
                                <i class="ti ti-calendar me-1"></i>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isAdmin)
    {{-- Admin Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Total Penduduk</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_residents']) }}</h3>
                        </div>
                        <div class="avtar avtar-l bg-light-primary">
                            <i class="ti ti-users text-primary f-24"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-light-success me-1">
                            <i class="ti ti-check"></i> {{ $stats['active_residents'] }} Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Laki-laki</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['male_residents']) }}</h3>
                        </div>
                        <div class="avtar avtar-l bg-light-info">
                            <i class="ti ti-user text-info f-24"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $malePercent = $stats['total_residents'] > 0 
                                ? round(($stats['male_residents'] / $stats['total_residents']) * 100, 1) 
                                : 0;
                        @endphp
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: {{ $malePercent }}%"></div>
                        </div>
                        <small class="text-muted mt-1 d-block">{{ $malePercent }}% dari total</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Perempuan</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['female_residents']) }}</h3>
                        </div>
                        <div class="avtar avtar-l bg-light-warning">
                            <i class="ti ti-user-circle text-warning f-24"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @php
                            $femalePercent = $stats['total_residents'] > 0 
                                ? round(($stats['female_residents'] / $stats['total_residents']) * 100, 1) 
                                : 0;
                        @endphp
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: {{ $femalePercent }}%"></div>
                        </div>
                        <small class="text-muted mt-1 d-block">{{ $femalePercent }}% dari total</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Total Aduan</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($complaintStats['total']) }}</h3>
                        </div>
                        <div class="avtar avtar-l bg-light-danger">
                            <i class="ti ti-message-report text-danger f-24"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($complaintStats['new'] > 0)
                            <span class="badge bg-danger me-1">{{ $complaintStats['new'] }} Baru</span>
                        @endif
                        @if($complaintStats['processing'] > 0)
                            <span class="badge bg-warning">{{ $complaintStats['processing'] }} Proses</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts and Recent Activity --}}
    <div class="row g-3 mb-4">
        {{-- Complaint Status Chart --}}
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-chart-pie me-2 text-primary"></i>Status Aduan
                    </h5>
                </div>
                <div class="card-body">
                    <div id="complaint-chart"></div>
                </div>
            </div>
        </div>
        
        {{-- Recent Complaints --}}
        <div class="col-md-6 col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-list me-2 text-primary"></i>Aduan Terbaru
                    </h5>
                    <a href="/complaint" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pelapor</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentComplaints as $complaint)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $complaint->resident->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ Str::limit($complaint->title, 30) }}</td>
                                    <td>{!! $complaint->status_label !!}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($complaint->created_at)->diffForHumans() }}
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ti ti-file-off f-24 d-block mb-2"></i>
                                            Belum ada aduan
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($userStats)
    {{-- User Statistics (Admin Only) --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-user-check me-2 text-primary"></i>Statistik Pengguna
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center">
                                <h4 class="mb-1 fw-bold">{{ $userStats['total'] }}</h4>
                                <p class="text-muted mb-0">Total Akun</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light-success rounded text-center">
                                <h4 class="mb-1 fw-bold text-success">{{ $userStats['approved'] }}</h4>
                                <p class="text-muted mb-0">Akun Aktif</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light-warning rounded text-center">
                                <h4 class="mb-1 fw-bold text-warning">{{ $userStats['pending'] }}</h4>
                                <p class="text-muted mb-0">Menunggu Persetujuan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @else
    {{-- User Dashboard --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-5">
                    <div class="avtar avtar-xl bg-light-primary mb-3 mx-auto">
                        <i class="ti ti-message-plus text-primary f-36"></i>
                    </div>
                    <h5 class="mb-2">Buat Aduan Baru</h5>
                    <p class="text-muted mb-4">Sampaikan keluhan atau masukan untuk desa</p>
                    <a href="/complaint/create" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>Buat Aduan
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-5">
                    <div class="avtar avtar-xl bg-light-info mb-3 mx-auto">
                        <i class="ti ti-list-check text-info f-36"></i>
                    </div>
                    <h5 class="mb-2">Aduan Saya</h5>
                    <p class="text-muted mb-4">Lihat status dan riwayat aduan Anda</p>
                    <a href="/complaint" class="btn btn-outline-primary">
                        <i class="ti ti-eye me-1"></i>Lihat Aduan
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- User's Recent Complaints --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-history me-2 text-primary"></i>Aduan Terakhir Saya
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentComplaints as $complaint)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $complaint->title }}</span>
                                    </td>
                                    <td>{!! $complaint->status_label !!}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y') }}
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="ti ti-file-off f-24 d-block mb-2"></i>
                                            Anda belum membuat aduan
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($isAdmin && $complaintStats['total'] > 0)
    // Complaint Status Donut Chart
    var options = {
        series: [{{ $complaintStats['new'] }}, {{ $complaintStats['processing'] }}, {{ $complaintStats['completed'] }}],
        chart: {
            type: 'donut',
            height: 250,
            foreColor: document.body.getAttribute('data-pc-theme') === 'dark' ? '#e5e7eb' : '#343a40'
        },
        labels: ['Baru', 'Diproses', 'Selesai'],
        colors: ['#6c757d', '#ffc107', '#10b981'],
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function() {
                                return {{ $complaintStats['total'] }};
                            }
                        }
                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#complaint-chart"), options);
    chart.render();
    window.dashboardChart = chart;
    @endif
});
</script>
@endpush
@endsection