@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Profile Header Card -->
            <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-5">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="profile-avatar mb-3">
                                <div class="avatar-circle bg-white text-primary d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border-radius: 50%; font-size: 2.5rem; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="mb-2 fw-bold">{{ Auth::user()->name }}</h2>
                            <p class="mb-2 opacity-75">
                                <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                            </p>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-calendar-alt me-2"></i>Bergabung {{ Auth::user()->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Details Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-user-circle me-2 text-primary"></i>Detail Profil
                        </h5>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i>Edit Profil
                        </button>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3" style="background-color: #f8f9fa;">
                                <label class="form-label text-muted mb-1 small fw-semibold">NAMA LENGKAP</label>
                                <div class="info-value h6 mb-0 text-dark">{{ Auth::user()->name }}</div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3" style="background-color: #f8f9fa;">
                                <label class="form-label text-muted mb-1 small fw-semibold">EMAIL</label>
                                <div class="info-value h6 mb-0 text-dark">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3" style="background-color: #f8f9fa;">
                                <label class="form-label text-muted mb-1 small fw-semibold">STATUS AKUN</label>
                                <div class="info-value">
                                    @if(Auth::user()->status == 'approved')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    @elseif(Auth::user()->status == 'submitted')
                                        <span class="badge bg-warning px-3 py-2 rounded-pill">
                                            <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">
                                            <i class="fas fa-times-circle me-1"></i>Tidak Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div class="col-md-6">
                            <div class="info-item p-3 rounded-3" style="background-color: #f8f9fa;">
                                <label class="form-label text-muted mb-1 small fw-semibold">BERGABUNG SEJAK</label>
                                <div class="info-value h6 mb-0 text-dark">{{ Auth::user()->created_at->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-cogs me-2 text-primary"></i>Pengaturan Akun
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('profile.change-password') }}" class="btn btn-outline-warning w-100 py-3 rounded-3 text-start">
                                <i class="fas fa-key me-3 fs-5"></i>
                                <div class="d-inline-block">
                                    <div class="fw-semibold">Ubah Password</div>
                                    <small class="text-muted">Perbarui kata sandi akun Anda</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-danger w-100 py-3 rounded-3 text-start" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt me-3 fs-5"></i>
                                <div class="d-inline-block">
                                    <div class="fw-semibold">Keluar</div>
                                    <small class="text-muted">Keluar dari akun Anda</small>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="editProfileModalLabel">
                    <i class="fas fa-user-edit me-2 text-primary"></i>Edit Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" 
                                   value="{{ Auth::user()->name }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-dark">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" 
                                   value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Logout Form (Hidden) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@push('styles')
<style>
    .info-item {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .info-item:hover {
        border-color: #e9ecef;
        transform: translateY(-2px);
    }
    .avatar-circle {
        transition: all 0.3s ease;
    }
    .avatar-circle:hover {
        transform: scale(1.05);
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Success Alert
    @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    // Error Alert
    @if($errors->any())
        Swal.fire({
            title: "Error",
            text: "@foreach ($errors->all() as $error) {{ $error }} {{ $loop->last ? '.' : ',' }} @endforeach",
            icon: "error",
        });
    @endif

    // Confirm Logout
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari Akun?',
            text: "Anda akan keluar dari sesi ini",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
@endpush
@endsection