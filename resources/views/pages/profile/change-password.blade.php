@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="mb-4">
                <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                </a>
            </div>

            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <h3 class="mb-4 text-center">Ubah Password</h3>
                    <div class="alert alert-info border-0 rounded-3 mb-4" style="background-color: #e7f3ff;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle text-info me-3 mt-1 fa-lg"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Tips Keamanan Password</h6>
                                <small class="text-muted">
                                    Gunakan kombinasi huruf besar, kecil, angka, dan simbol. Minimal 8 karakter.
                                </small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('profile.update-password') }}" method="POST" id="changePasswordForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-shield-alt me-2 text-muted"></i>Password Saat Ini
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" placeholder="Masukkan password Anda saat ini" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password" class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-key me-2 text-muted"></i>Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" name="new_password" placeholder="Masukkan password baru" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2" id="passwordStrength" style="display: none;">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" id="strengthBar"></div>
                                </div>
                                <small id="strengthText" class="text-muted"></small>
                            </div>
                            @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-check-double me-2 text-muted"></i>Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation" 
                                       name="new_password_confirmation" placeholder="Ulangi password baru Anda" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMessage" class="mt-2"></div>
                        </div>

                        <div class="alert alert-warning border-0 rounded-3 mb-4" style="background-color: #fff3cd;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle text-warning me-3 mt-1 fa-lg"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Perhatian!</h6>
                                    <small class="text-muted">
                                        Setelah berhasil mengubah password, Anda akan keluar secara otomatis dan perlu login kembali.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 flex-grow-1" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Ubah Password
                            </button>
                            <button type="reset" class="btn btn-outline-secondary rounded-pill px-4 py-2" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Memberi efek transisi dan hover yang halus pada elemen UI */
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .form-control:focus, .btn:focus {
        border-color: #8A9BFF;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .progress-bar, .alert, .btn {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Inisialisasi elemen-elemen yang akan dimanipulasi
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    const strengthDiv = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const matchMessageDiv = document.getElementById('passwordMatchMessage');
    const changePasswordForm = document.getElementById('changePasswordForm');

    // Notifikasi SweetAlert untuk status session (sukses atau error)
    @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }} Anda akan dialihkan ke halaman login.",
            icon: "success",
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "{{ route('login') }}";
        });
    @endif

    @if($errors->any())
        let errorMessages = `@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach`;
        Swal.fire({
            title: "Oops, terjadi kesalahan!",
            html: `<ul class="list-unstyled text-start">${errorMessages}</ul>`,
            icon: "error",
        });
    @endif

    // Fungsi untuk menampilkan/menyembunyikan password
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        const isPassword = field.type === 'password';
        field.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !isPassword);
        icon.classList.toggle('fa-eye-slash', isPassword);
    }

    // Fungsi untuk memeriksa kekuatan password
    const checkPasswordStrength = () => {
        const password = newPasswordInput.value;
        if (password.length === 0) {
            strengthDiv.style.display = 'none';
            return;
        }
        
        strengthDiv.style.display = 'block';
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[\d!"#$%&'()*+,-./:;<=>?@[\\\]^_`{|}~]/)) strength++;

        const strengthLevels = {
            0: { label: 'Sangat Lemah', color: 'bg-danger', width: '25%' },
            1: { label: 'Lemah', color: 'bg-danger', width: '25%' },
            2: { label: 'Sedang', color: 'bg-warning', width: '50%' },
            3: { label: 'Kuat', color: 'bg-info', width: '75%' },
            4: { label: 'Sangat Kuat', color: 'bg-success', width: '100%' }
        };

        const { label, color, width } = strengthLevels[strength];
        strengthBar.className = `progress-bar ${color}`;
        strengthBar.style.width = width;
        strengthText.textContent = `Kekuatan: ${label}`;
    };

    // Fungsi untuk memeriksa kecocokan password
    const checkPasswordMatch = () => {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (confirmPassword.length === 0) {
            matchMessageDiv.innerHTML = '';
            return;
        }

        if (password === confirmPassword) {
            matchMessageDiv.innerHTML = `<small class="text-success"><i class="fas fa-check-circle me-1"></i>Password cocok.</small>`;
        } else {
            matchMessageDiv.innerHTML = `<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Password tidak cocok.</small>`;
        }
    };

    // Fungsi untuk mereset tampilan form
    window.resetForm = function() {
        strengthDiv.style.display = 'none';
        matchMessageDiv.innerHTML = '';
        const icons = document.querySelectorAll('.fa-eye-slash');
        icons.forEach(icon => {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        });
    }

    // Event listener untuk input password
    newPasswordInput.addEventListener('input', () => {
        checkPasswordStrength();
        checkPasswordMatch();
    });
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    // Konfirmasi sebelum submit form
    changePasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: "Anda yakin ingin mengubah password? Anda akan logout otomatis setelahnya.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah Password!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            // 2. Jika pengguna mengklik "Ya"
            if (result.isConfirmed) {
                const submitBtn = document.getElementById('submitBtn');
                
                // Tampilkan status loading pada tombol
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
                
                // 3. KIRIM FORM SECARA MANUAL!
                this.submit(); 
            }
        });
    });

});
</script>
@endpush