@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header dengan Search --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avtar avtar-l bg-light-primary me-3">
                                    <i class="ti ti-users text-primary f-24"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-dark fw-bold">Daftar Akun Penduduk</h4>
                                    <p class="text-muted mb-0">Kelola akun penduduk yang telah terdaftar dalam sistem</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">
                                            <i class="ti ti-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-0 bg-light" 
                                               placeholder="Cari nama, email, atau telepon..." id="searchInput">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        <i class="ti ti-plus me-1"></i>Tambah Penduduk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Total Penduduk</h6>
                            <h4 class="mb-0">{{ $users->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-primary">
                            <i class="ti ti-users f-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Aktif</h6>
                            <h4 class="mb-0">{{ $users->where('status', 'approved')->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-success">
                            <i class="ti ti-user-check f-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Bulan Ini</h6>
                            <h4 class="mb-0">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-warning">
                            <i class="ti ti-calendar-plus f-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-2 f-w-400 text-muted">Minggu Ini</h6>
                            <h4 class="mb-0">{{ $users->where('created_at', '>=', now()->subDays(7))->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-info">
                            <i class="ti ti-clock f-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-list me-2 text-primary"></i>Daftar Penduduk Terdaftar
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="ti ti-download me-2"></i>Export Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="ti ti-file-text me-2"></i>Export PDF</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="ti ti-refresh me-2"></i>Refresh</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0" id="usersTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-top-0 ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th class="border-top-0">Penduduk</th>
                                <th class="border-top-0">Kontak</th>
                                <th class="border-top-0">Tanggal Bergabung</th>
                                <th class="border-top-0 text-center">Status</th>
                                <th class="border-top-0 text-center">Aktivitas Terakhir</th>
                                <th class="border-top-0 text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="user-row">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <div class="avtar avtar-s bg-light-primary">
                                                <span class="text-primary f-12 fw-bold">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" style="font-size: 6px; margin-left: -8px;">
                                                <span class="visually-hidden">Online</span>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-mail text-primary me-1 f-14"></i>
                                            <span class="text-dark f-14">{{ $user->email }}</span>
                                        </div>
                                        @if($user->phone)
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-phone text-success me-1 f-14"></i>
                                                <small class="text-muted">{{ $user->phone }}</small>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-phone-off text-muted me-1 f-14"></i>
                                                <small class="text-muted">Tidak tersedia</small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="text-dark fw-semibold f-14">{{ $user->created_at->format('d M Y') }}</span>
                                        <br><small class="text-muted">{{ $user->created_at->format('H:i') }} WIB</small>
                                        <br><small class="badge bg-light-secondary">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($user->status == 'approved')
                                        <span class="badge bg-light-success border border-success">
                                            <i class="ti ti-check me-1"></i>Aktif
                                        </span>
                                    @elseif($user->status == 'submitted')
                                        <span class="badge bg-light-warning border border-warning">
                                            <i class="ti ti-clock me-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="badge bg-light-danger border border-danger">
                                            <i class="ti ti-x me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="avtar avtar-xs bg-light-success me-2">
                                            <i class="ti ti-clock f-10 text-success"></i>
                                        </div>
                                        <div class="text-start">
                                            <small class="text-dark fw-semibold">{{ $user->updated_at->format('d/m/Y') }}</small>
                                            <br><small class="text-muted">{{ $user->updated_at->format('H:i') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"
                                                title="Lihat Detail">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}"
                                                title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split" 
                                                    data-bs-toggle="dropdown" title="Opsi Lainnya">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="ti ti-message-circle me-2"></i>Kirim Pesan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="ti ti-shield-lock me-2"></i>Reset Password
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" 
                                                       onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                                        <i class="ti ti-trash me-2"></i>Hapus
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination & Actions Bar --}}
                <div class="card-footer bg-light border-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <small class="text-muted me-3">
                                    Menampilkan {{ $users->count() }} dari {{ $users->count() }} penduduk
                                </small>
                                <div class="btn-group btn-group-sm" id="bulkActions" style="display: none;">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-mail me-1"></i>Kirim Email
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm">
                                        <i class="ti ti-edit me-1"></i>Edit Batch
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="ti ti-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avtar avtar-xl bg-light-secondary mb-3 mx-auto">
                        <i class="ti ti-users f-36 text-muted"></i>
                    </div>
                    <h5 class="mb-2">Belum Ada Penduduk Terdaftar</h5>
                    <p class="text-muted mb-4">Mulai tambahkan penduduk untuk mengelola data kependudukan</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="ti ti-plus me-1"></i>Tambah Penduduk Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- View Detail Modals --}}
@foreach ($users as $user)
    <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light-primary">
                    <h5 class="modal-title text-primary">
                        <i class="ti ti-user-circle me-2"></i>Profile Penduduk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avtar avtar-xl bg-light-primary text-primary mb-3 mx-auto">
                                <span class="f-24 fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <h6 class="mb-1">{{ $user->name }}</h6>
                            <small class="text-muted">ID: {{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</small>
                            <div class="mt-3">
                                @if($user->status == 'approved')
                                    <span class="badge bg-light-success text-success border border-success px-3 py-2">
                                        <i class="ti ti-check me-1"></i>Akun Aktif
                                    </span>
                                @else
                                    <span class="badge bg-light-warning text-warning border border-warning px-3 py-2">
                                        <i class="ti ti-clock me-1"></i>Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ti ti-info-circle me-2 text-primary"></i>Informasi Detail
                                    </h6>
                                    <div class="row mb-3">
                                        <div class="col-sm-5">
                                            <strong class="text-muted">Nama Lengkap:</strong>
                                        </div>
                                        <div class="col-sm-7">
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5">
                                            <strong class="text-muted">Email:</strong>
                                        </div>
                                        <div class="col-sm-7">
                                            <span class="text-primary">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5">
                                            <strong class="text-muted">Telepon:</strong>
                                        </div>
                                        <div class="col-sm-7">
                                            <span>{{ $user->phone ?? 'Tidak tersedia' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-5">
                                            <strong class="text-muted">Bergabung:</strong>
                                        </div>
                                        <div class="col-sm-7">
                                            <span>{{ $user->created_at->format('d F Y, H:i') }} WIB</span>
                                            <br><small class="text-success">{{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <strong class="text-muted">Terakhir Update:</strong>
                                        </div>
                                        <div class="col-sm-7">
                                            <span>{{ $user->updated_at->format('d F Y, H:i') }} WIB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                        <i class="ti ti-edit me-1"></i>Edit
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="ti ti-message-circle me-1"></i>Kirim Pesan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Toast Notifications --}}
@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show border-0 shadow-lg" role="alert">
        <div class="toast-header bg-success text-white border-0">
            <i class="ti ti-check-circle me-2"></i>
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body bg-white">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show border-0 shadow-lg" role="alert">
        <div class="toast-header bg-danger text-white border-0">
            <i class="ti ti-alert-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body bg-white">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss toasts
    var toasts = document.querySelectorAll('.toast');
    toasts.forEach(function(toast) {
        setTimeout(function() {
            bootstrap.Toast.getOrCreateInstance(toast).hide();
        }, 5000);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('.user-row');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActions = document.getElementById('bulkActions');

    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleBulkActions();
    });

    userCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            toggleBulkActions();
            
            // Update select all checkbox
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
            selectAllCheckbox.checked = checkedCount === userCheckboxes.length;
        });
    });

    function toggleBulkActions() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActions.style.display = 'block';
        } else {
            bulkActions.style.display = 'none';
        }
    }
});

function confirmDelete(userId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus akun ${userName}?`)) {
        // Handle delete action here
        console.log('Deleting user:', userId);
    }
}
</script>
@endpush