@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Dashboard Keuangan</h4>
                    <p class="text-muted mb-0">Ringkasan keuangan desa</p>
                </div>
                <a href="{{ route('finance.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>Tambah Transaksi
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-success me-3">
                            <i class="ti ti-arrow-up f-24 text-success"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Pemasukan Bulan Ini</p>
                            <h4 class="mb-0 text-success">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-danger me-3">
                            <i class="ti ti-arrow-down f-24 text-danger"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Pengeluaran Bulan Ini</p>
                            <h4 class="mb-0 text-danger">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-primary me-3">
                            <i class="ti ti-wallet f-24 text-primary"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Saldo Bulan Ini</p>
                            <h4 class="mb-0 {{ $balanceThisMonth >= 0 ? 'text-primary' : 'text-danger' }}">
                                Rp {{ number_format($balanceThisMonth, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-warning me-3">
                            <i class="ti ti-report-money f-24 text-warning"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Saldo</p>
                            <h4 class="mb-0 {{ $totalBalance >= 0 ? 'text-warning' : 'text-danger' }}">
                                Rp {{ number_format($totalBalance, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-chart-bar me-2 text-primary"></i>Grafik Keuangan 6 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    <div id="financeChart"></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-bolt me-2 text-primary"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('finance.index') }}" class="btn btn-outline-primary">
                            <i class="ti ti-list me-1"></i>Lihat Semua Transaksi
                        </a>
                        <a href="{{ route('finance.report') }}" class="btn btn-outline-success">
                            <i class="ti ti-file-text me-1"></i>Laporan Bulanan
                        </a>
                        <a href="{{ route('finance.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>Tambah Transaksi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-history me-2 text-primary"></i>Transaksi Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentTransactions->take(5) as $tx)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="d-block fw-medium">{{ Str::limit($tx->description, 25) }}</span>
                                <small class="text-muted">{{ $tx->formatted_date }}</small>
                            </div>
                            <span class="{{ $tx->type === 'income' ? 'text-success' : 'text-danger' }} fw-bold">
                                {{ $tx->type === 'income' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted py-4">
                            Belum ada transaksi
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false },
            background: 'transparent'
        },
        series: [{
            name: 'Pemasukan',
            data: @json(array_column($monthlyData, 'income'))
        }, {
            name: 'Pengeluaran',
            data: @json(array_column($monthlyData, 'expense'))
        }],
        colors: ['#10b981', '#ef4444'],
        xaxis: {
            categories: @json(array_column($monthlyData, 'month')),
            labels: { style: { colors: '#9ca3af' } }
        },
        yaxis: {
            labels: {
                style: { colors: '#9ca3af' },
                formatter: function(val) {
                    return 'Rp ' + (val / 1000000).toFixed(1) + 'Jt';
                }
            }
        },
        legend: {
            labels: { colors: '#e5e7eb' }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(val) {
                    return 'Rp ' + val.toLocaleString('id-ID');
                }
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '60%'
            }
        },
        dataLabels: { enabled: false },
        grid: {
            borderColor: '#374151'
        }
    };

    var chart = new ApexCharts(document.querySelector("#financeChart"), options);
    chart.render();
});
</script>
@endsection
