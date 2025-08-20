@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header dengan Search --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
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
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="ti ti-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" 
                                       placeholder="Cari nama, email, atau telepon..." id="searchInput">
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

    {{-- Bulk Actions Bar (Hidden by default) --}}
    <div class="card border-0 shadow-sm mb-3" id="bulkActionsBar" style="display: none;">
        <div class="card-body py-2">
            <div class="row align-items-center">
                <div class="col">
                    <small class="text-muted">
                        <span id="selectedCount">0</span> akun dipilih
                    </small>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-sm me-2" id="bulkDeleteBtn" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                        <i class="ti ti-trash me-1"></i>Hapus Terpilih
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="clearSelection()">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
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
                                <th class="border-top-0">Email</th>
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
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-mail text-primary me-1 f-14"></i>
                                            <span class="text-dark f-14">{{ $user->email }}</span>
                                        </div>
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
                                        <button type="button" class="btn btn-outline-primary btn-sm me-1"
                                                data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"
                                                title="Lihat Detail">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm me-1" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}"
                                                title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm me-1" 
                                                data-bs-toggle="modal" data-bs-target="#deactivateModal{{ $user->id }}"
                                                title="Nonaktifkan Akun">
                                            <i class="ti ti-user-off"></i>
                                        </button>
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
                            <small class="text-muted">
                                Menampilkan {{ $users->count() }} dari {{ $users->count() }} penduduk
                            </small>
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
                    <p class="text-muted mb-4">Data penduduk akan muncul di sini setelah ditambahkan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Bulk Delete Confirmation Modal --}}
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light-danger">
                <h5 class="modal-title text-danger" id="bulkDeleteModalLabel">
                    <i class="ti ti-trash me-2"></i>Konfirmasi Hapus Terpilih
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="avtar avtar-xl bg-light-danger text-danger mb-3 mx-auto">
                        <i class="ti ti-trash f-24"></i>
                    </div>
                    <h6 class="mb-2">Hapus Akun Penduduk Terpilih</h6>
                    <p class="text-muted mb-0">Apakah Anda yakin ingin menghapus <strong id="bulkDeleteCount">0</strong> akun penduduk yang dipilih?</p>
                    <small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="bulkDeleteForm" action="{{ route('users.bulkDestroy') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>Hapus Terpilih
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modals for each user --}}
@foreach ($users as $user)
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light-danger">
                    <h5 class="modal-title text-danger" id="deleteModalLabel{{ $user->id }}">
                        <i class="ti ti-trash me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="avtar avtar-xl bg-light-danger text-danger mb-3 mx-auto">
                            <i class="ti ti-trash f-24"></i>
                        </div>
                        <h6 class="mb-2">Hapus Akun Penduduk</h6>
                        <p class="text-muted mb-0">Apakah Anda yakin ingin menghapus akun penduduk <strong>{{ $user->name }}</strong>?</p>
                        <small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ url('/users') }}/{{ $user->id }}" method="POST" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Deactivate Confirmation Modal --}}
    <div class="modal fade" id="deactivateModal{{ $user->id }}" tabindex="-1" aria-labelledby="deactivateModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light-warning">
                    <h5 class="modal-title text-warning" id="deactivateModalLabel{{ $user->id }}">
                        <i class="ti ti-user-off me-2"></i>Konfirmasi Nonaktifkan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="avtar avtar-xl bg-light-warning text-warning mb-3 mx-auto">
                            <i class="ti ti-user-off f-24"></i>
                        </div>
                        <h6 class="mb-2">Nonaktifkan Akun Penduduk</h6>
                        <p class="text-muted mb-0">Apakah Anda yakin ingin menonaktifkan akun penduduk <strong>{{ $user->name }}</strong>?</p>
                        <small class="text-warning">Akun akan diubah statusnya menjadi nonaktif.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ url('/users') }}/{{ $user->id }}/deactivate" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-user-off me-1"></i>Nonaktifkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

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
                            <small class="text-muted">ID: {{ $user->id }}</small>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    // Handle "Select All" checkbox
    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    // Handle individual checkboxes
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsVisibility();
        });
    });

    // Update "Select All" state based on individual checkboxes
    function updateSelectAllState() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        selectAllCheckbox.checked = checkedCount === userCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
    }

    // Show/hide bulk actions bar
    function updateBulkActionsVisibility() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActionsBar.style.display = 'block';
            selectedCountSpan.textContent = checkedBoxes.length;
        } else {
            bulkActionsBar.style.display = 'none';
        }
    }

    // Update bulk delete modal when opened
    document.getElementById('bulkDeleteModal').addEventListener('show.bs.modal', function() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const userIds = Array.from(checkedBoxes).map(cb => cb.value);
        
        document.getElementById('bulkDeleteCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteIds').value = JSON.stringify(userIds);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});

// Clear selection
function clearSelection() {
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('selectAll').checked = false;
    document.getElementById('bulkActionsBar').style.display = 'none';
}
</script>

@endsection