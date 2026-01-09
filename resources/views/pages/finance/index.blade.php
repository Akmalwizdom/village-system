@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Daftar Transaksi</h4>
                    <p class="text-muted mb-0">Kelola transaksi keuangan desa</p>
                </div>
                <a href="{{ route('finance.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>Tambah Transaksi
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="ti ti-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('finance.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Jenis</label>
                    <select name="type" class="form-select">
                        <option value="">Semua</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                        <tr>
                            <td>{{ $tx->formatted_date }}</td>
                            <td>{{ $tx->category->name }}</td>
                            <td>{{ Str::limit($tx->description, 40) }}</td>
                            <td>{!! $tx->type_label !!}</td>
                            <td class="text-end fw-bold {{ $tx->type === 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $tx->formatted_amount }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('finance.edit', $tx) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('finance.destroy', $tx) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ti ti-file-off f-24 d-block mb-2"></i>
                                    Belum ada transaksi
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($transactions->hasPages())
        <div class="card-footer">
            {{ $transactions->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
