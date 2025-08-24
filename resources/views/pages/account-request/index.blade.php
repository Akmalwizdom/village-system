@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avtar avtar-l bg-light-primary me-3">
                                    <i class="ti ti-user-plus text-primary f-24"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-dark fw-bold">Permintaan Akun Pengguna</h4>
                                    <p class="text-muted mb-0">Kelola dan review permintaan akun pengguna baru</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ti ti-filter me-1"></i>Filter Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?status=all">Semua Status</a></li>
                                    <li><a class="dropdown-item" href="?status=submitted">Menunggu</a></li>
                                    <li><a class="dropdown-item" href="?status=approved">Disetujui</a></li>
                                    <li><a class="dropdown-item" href="?status=rejected">Ditolak</a></li>
                                </ul>
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
                            <h6 class="mb-2 f-w-400 text-muted">Total Permintaan</h6>
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
                            <h6 class="mb-2 f-w-400 text-muted">Menunggu</h6>
                            <h4 class="mb-0">{{ $users->where('status', 'submitted')->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-warning">
                            <i class="ti ti-clock f-20"></i>
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
                            <h6 class="mb-2 f-w-400 text-muted">Disetujui</h6>
                            <h4 class="mb-0">{{ $users->where('status', 'approved')->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-success">
                            <i class="ti ti-check f-20"></i>
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
                            <h6 class="mb-2 f-w-400 text-muted">Ditolak</h6>
                            <h4 class="mb-0">{{ $users->where('status', 'rejected')->count() }}</h4>
                        </div>
                        <div class="avtar avtar-s bg-light-danger">
                            <i class="ti ti-x f-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-bold">
                <i class="ti ti-user-plus me-2 text-primary"></i>Daftar Permintaan Akun
            </h5>
        </div>
        <div class="card-body p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-top-0 ps-4">Pengguna</th>
                                <th class="border-top-0">Email & Kontak</th>
                                <th class="border-top-0">Tanggal Daftar</th>
                                <th class="border-top-0 text-center">Status</th>
                                <th class="border-top-0 text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-secondary me-3">
                                            <span class="text-muted f-12 f-w-600">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 f-w-500">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="text-primary f-14">{{ $user->email }}</span>
                                        @if($user->phone)
                                            <br><small class="text-muted">
                                                <i class="ti ti-phone me-1"></i>{{ $user->phone }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark f-14">{{ $user->created_at->format('d M Y') }}</span>
                                    <br><small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    @switch($user->status)
                                        @case('submitted')
                                            <span class="badge bg-warning f-12">
                                                <i class="ti ti-clock me-1"></i>Menunggu
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success f-12">
                                                <i class="ti ti-check me-1"></i>Disetujui
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger f-12">
                                                <i class="ti ti-x me-1"></i>Ditolak
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center pe-4">
                                    @if($user->status == 'submitted')
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-success btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#approveModal{{ $user->id }}"
                                                    title="Setujui">
                                                <i class="ti ti-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}"
                                                    title="Tolak">
                                                <i class="ti ti-x"></i>
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"
                                                    title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-info btn-sm me-1"
                                                    data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"
                                                    title="Lihat Detail">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            @if($user->status == 'rejected')
                                                <button type="button" class="btn btn-outline-success btn-sm me-1"
                                                        data-bs-toggle="modal" data-bs-target="#approveModal{{ $user->id }}"
                                                        title="Setujui">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-outline-danger btn-sm me-1" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}"
                                                    title="Hapus">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Info --}}
                <div class="card-footer bg-light border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <small class="text-muted">
                                Menampilkan {{ $users->count() }} dari {{ $users->count() }} permintaan
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avtar avtar-xl bg-light-secondary mb-3 mx-auto">
                        <i class="ti ti-user-plus f-36 text-muted"></i>
                    </div>
                    <h5 class="mb-2">Tidak ada permintaan akun</h5>
                    <p class="text-muted mb-4">Belum ada pengguna yang mengajukan permintaan akun baru</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modals for each user --}}
@foreach ($users as $user)
    {{-- Approve Modal --}}

{{-- Di dalam @foreach ($users as $user) --}}
<div class="modal fade" id="approveModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light-success">
                <h5 class="modal-title text-success">
                    <i class="ti ti-check-circle me-2"></i>Konfirmasi Persetujuan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- Tambahkan form di sini --}}
            <form action="/account-request/approval/{{ $user->id }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted text-center">Anda akan menyetujui permintaan akun dari <strong>{{ $user->name }}</strong>.</p>
                    
                    {{-- TAMBAHKAN BAGIAN INI --}}
                    <div class="mb-3">
                        <label for="resident_id_{{ $user->id }}" class="form-label fw-bold">Hubungkan ke Penduduk:</label>
                        <select class="form-select" name="resident_id" id="resident_id_{{ $user->id }}" required>
                            <option value="" selected disabled>-- Pilih Penduduk --</option>
                            @foreach ($residents as $resident)
                                <option value="{{ $resident->id }}">
                                    {{ $resident->name }} (NIK: {{ $resident->nik }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih data penduduk yang akan dihubungkan dengan akun ini.</small>
                    </div>
                    {{-- BATAS AKHIR PENAMBAHAN --}}

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="status" value="approved">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check me-1"></i>Ya, Setujui & Hubungkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    {{-- Reject Modal --}}
    <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light-danger">
                    <h5 class="modal-title text-danger">
                        <i class="ti ti-x-circle me-2"></i>Konfirmasi Penolakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="avtar avtar-xl bg-light-danger text-danger mb-3 mx-auto">
                        <i class="ti ti-x f-24"></i>
                    </div>
                    <h6 class="mb-2">Tolak Permintaan Akun?</h6>
                    <p class="text-muted mb-3">Anda akan menolak permintaan akun dari:</p>
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="avtar avtar-s bg-primary me-2">
                                <i class="ti ti-user f-16"></i>
                            </div>
                            <div class="text-start">
                                <div class="f-w-600">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger">Pengguna tidak akan mendapatkan akses ke sistem</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form action="/account-request/approval/{{ $user->id }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-x me-1"></i>Ya, Tolak
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
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

    {{-- View Modal --}}
    <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light-primary">
                    <h5 class="modal-title text-primary">
                        <i class="ti ti-user-circle me-2"></i>Detail Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avtar avtar-xl bg-light-primary text-primary mb-3 mx-auto">
                                <i class="ti ti-user f-24"></i>
                            </div>
                            <div class="mt-3">
                            @switch($user->status)
                                @case('submitted')
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @break
                                @case('approved')
                                    <span class="badge bg-success">Telah Disetujui</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">Telah Ditolak</span>
                                    @break
                            @endswitch
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted f-w-500">Nama Lengkap:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="f-w-600">{{ $user->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted f-w-500">Email:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="text-primary">{{ $user->email }}</span>
                                </div>
                            </div>
                            @if($user->phone)
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted f-w-500">Telepon:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span>{{ $user->phone }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted f-w-500">Tanggal Daftar:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span>{{ $user->created_at->format('d F Y, H:i') }} WIB</span>
                                </div>
                            </div>
                            @if($user->updated_at != $user->created_at)
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted f-w-500">Update Terakhir:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span>{{ $user->updated_at->format('d F Y, H:i') }} WIB</span>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted f-w-500">ID Pengguna:</label>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge bg-light-secondary">{{ $user->id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    @if($user->status == 'submitted')
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                                data-bs-toggle="modal" data-bs-target="#approveModal{{ $user->id }}">
                            <i class="ti ti-check me-1"></i>Setujui
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}">
                            <i class="ti ti-x me-1"></i>Tolak
                        </button>
                    @endif
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
            <i class="ti ti-x-circle me-2"></i>
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
    // Auto dismiss toasts
    document.addEventListener('DOMContentLoaded', function() {
        var toasts = document.querySelectorAll('.toast');
        toasts.forEach(function(toast) {
            setTimeout(function() {
                bootstrap.Toast.getOrCreateInstance(toast).hide();
            }, 1000);
        });
    });
</script>
@endpush