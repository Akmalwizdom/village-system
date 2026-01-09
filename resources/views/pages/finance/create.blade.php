@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Tambah Transaksi</h4>
                    <p class="text-muted mb-0">Catat transaksi pemasukan atau pengeluaran</p>
                </div>
                <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-plus me-2 text-primary"></i>Form Transaksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('finance.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Jenis Transaksi <span class="text-danger">*</span></label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="transaction_type" id="type_income" value="income" checked>
                                    <label class="btn btn-outline-success" for="type_income">
                                        <i class="ti ti-arrow-up me-1"></i>Pemasukan
                                    </label>
                                    <input type="radio" class="btn-check" name="transaction_type" id="type_expense" value="expense">
                                    <label class="btn btn-outline-danger" for="type_expense">
                                        <i class="ti ti-arrow-down me-1"></i>Pengeluaran
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="transaction_date" class="form-label fw-medium">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                       id="transaction_date" name="transaction_date" 
                                       value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                                @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="finance_category_id" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('finance_category_id') is-invalid @enderror" 
                                    id="finance_category_id" name="finance_category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                <optgroup label="Pemasukan" id="income_categories">
                                    @foreach($categories['income'] ?? [] as $cat)
                                    <option value="{{ $cat->id }}" {{ old('finance_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Pengeluaran" id="expense_categories" style="display:none;">
                                    @foreach($categories['expense'] ?? [] as $cat)
                                    <option value="{{ $cat->id }}" {{ old('finance_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('finance_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="form-label fw-medium">Jumlah (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   min="1" placeholder="0" required>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-medium">Keterangan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Deskripsi transaksi..." required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reference_number" class="form-label fw-medium">No. Referensi/Bukti</label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                   id="reference_number" name="reference_number" 
                                   value="{{ old('reference_number') }}" placeholder="Opsional">
                            @error('reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i>Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avtar avtar-s bg-light-primary me-3">
                            <i class="ti ti-info-circle text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Petunjuk</h6>
                            <small class="text-muted">
                                Pilih jenis transaksi terlebih dahulu untuk menampilkan kategori yang sesuai.
                                Pastikan mengisi semua field yang wajib (*).
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const incomeRadio = document.getElementById('type_income');
    const expenseRadio = document.getElementById('type_expense');
    const incomeCategories = document.querySelectorAll('#income_categories option');
    const expenseCategories = document.querySelectorAll('#expense_categories option');
    const categorySelect = document.getElementById('finance_category_id');

    function updateCategories() {
        const isIncome = incomeRadio.checked;
        
        incomeCategories.forEach(opt => opt.style.display = isIncome ? '' : 'none');
        expenseCategories.forEach(opt => opt.style.display = isIncome ? 'none' : '');
        
        document.getElementById('income_categories').style.display = isIncome ? '' : 'none';
        document.getElementById('expense_categories').style.display = isIncome ? 'none' : '';
        
        categorySelect.value = '';
    }

    incomeRadio.addEventListener('change', updateCategories);
    expenseRadio.addEventListener('change', updateCategories);
    updateCategories();
});
</script>
@endsection
