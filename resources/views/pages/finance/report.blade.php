@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Laporan Keuangan</h4>
                    <p class="text-muted mb-0">{{ $date->translatedFormat('F Y') }}</p>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('finance.report') }}" method="GET" class="d-flex gap-2">
                        <input type="month" name="month" class="form-control" value="{{ $month }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter"></i>
                        </button>
                    </form>
                    <a href="{{ route('finance.export-pdf', ['month' => $month]) }}" class="btn btn-success">
                        <i class="ti ti-download me-1"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body text-center">
                    <i class="ti ti-arrow-up f-32 text-success mb-2"></i>
                    <h6 class="text-muted mb-1">Total Pemasukan</h6>
                    <h4 class="text-success mb-0">Rp {{ number_format($incomeTotal, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
                <div class="card-body text-center">
                    <i class="ti ti-arrow-down f-32 text-danger mb-2"></i>
                    <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                    <h4 class="text-danger mb-0">Rp {{ number_format($expenseTotal, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body text-center">
                    <i class="ti ti-wallet f-32 text-primary mb-2"></i>
                    <h6 class="text-muted mb-1">Saldo</h6>
                    <h4 class="{{ $balance >= 0 ? 'text-primary' : 'text-danger' }} mb-0">
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Income by Category -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-arrow-up me-2 text-success"></i>Pemasukan per Kategori</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($incomeByCategory as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item['category'] }}</span>
                            <span class="text-success fw-bold">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Tidak ada pemasukan</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Expense by Category -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-arrow-down me-2 text-danger"></i>Pengeluaran per Kategori</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($expenseByCategory as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item['category'] }}</span>
                            <span class="text-danger fw-bold">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Tidak ada pengeluaran</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent">
            <h5 class="mb-0"><i class="ti ti-list me-2 text-primary"></i>Daftar Transaksi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-end">Pemasukan</th>
                            <th class="text-end">Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                        <tr>
                            <td>{{ $tx->transaction_date->format('d M Y') }}</td>
                            <td>{{ $tx->category->name }}</td>
                            <td>{{ $tx->description }}</td>
                            <td class="text-end text-success">
                                {{ $tx->type === 'income' ? $tx->formatted_amount : '-' }}
                            </td>
                            <td class="text-end text-danger">
                                {{ $tx->type === 'expense' ? $tx->formatted_amount : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada transaksi di bulan ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td class="text-end text-success">Rp {{ number_format($incomeTotal, 0, ',', '.') }}</td>
                            <td class="text-end text-danger">Rp {{ number_format($expenseTotal, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
