@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Edit Transaksi</h4>
                    <p class="text-muted mb-0">Perbarui data transaksi</p>
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
                    <h5 class="mb-0"><i class="ti ti-edit me-2 text-primary"></i>Form Edit Transaksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('finance.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Jenis Transaksi</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="transaction_type" id="type_income" value="income" 
                                           {{ $transaction->type === 'income' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success" for="type_income">
                                        <i class="ti ti-arrow-up me-1"></i>Pemasukan
                                    </label>
                                    <input type="radio" class="btn-check" name="transaction_type" id="type_expense" value="expense"
                                           {{ $transaction->type === 'expense' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger" for="type_expense">
                                        <i class="ti ti-arrow-down me-1"></i>Pengeluaran
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="transaction_date" class="form-label fw-medium">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                       id="transaction_date" name="transaction_date" 
                                       value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required>
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
                                    <option value="{{ $cat->id }}" {{ $transaction->finance_category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Pengeluaran" id="expense_categories">
                                    @foreach($categories['expense'] ?? [] as $cat)
                                    <option value="{{ $cat->id }}" {{ $transaction->finance_category_id == $cat->id ? 'selected' : '' }}>
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
                                   id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" 
                                   min="1" required>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-medium">Keterangan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reference_number" class="form-label fw-medium">No. Referensi/Bukti</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number" 
                                   value="{{ old('reference_number', $transaction->reference_number) }}">
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const incomeRadio = document.getElementById('type_income');
    const expenseRadio = document.getElementById('type_expense');
    
    function updateCategories() {
        const isIncome = incomeRadio.checked;
        document.getElementById('income_categories').style.display = isIncome ? '' : 'none';
        document.getElementById('expense_categories').style.display = isIncome ? 'none' : '';
    }

    incomeRadio.addEventListener('change', updateCategories);
    expenseRadio.addEventListener('change', updateCategories);
    updateCategories();
});
</script>
@endsection
