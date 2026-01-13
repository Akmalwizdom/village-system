/**
 * SweetAlert2 Configuration for SiDesa
 * Unified toast, alert, and confirmation dialogs
 */

// Toast preset (auto-dismiss notifications)
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#1f2937',
    color: '#e5e7eb',
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// Success toast
function showSuccess(message) {
    Toast.fire({
        icon: 'success',
        title: message || 'Berhasil!'
    });
}

// Error toast
function showError(message) {
    Toast.fire({
        icon: 'error',
        title: message || 'Terjadi kesalahan!'
    });
}

// Warning toast
function showWarning(message) {
    Toast.fire({
        icon: 'warning',
        title: message || 'Perhatian!'
    });
}

// Info toast
function showInfo(message) {
    Toast.fire({
        icon: 'info',
        title: message || 'Informasi'
    });
}

// Confirmation dialog for delete actions
function confirmDelete(formElement, message) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: message || 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#1f2937',
        color: '#e5e7eb',
        customClass: {
            popup: 'swal-dark'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            formElement.submit();
        }
    });
}

// Generic confirmation dialog
function confirmAction(options) {
    return Swal.fire({
        title: options.title || 'Konfirmasi',
        text: options.text || 'Apakah Anda yakin?',
        icon: options.icon || 'question',
        showCancelButton: true,
        confirmButtonColor: options.confirmColor || '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: options.confirmText || 'Ya',
        cancelButtonText: options.cancelText || 'Batal',
        background: '#1f2937',
        color: '#e5e7eb'
    });
}

// Alert dialog (manual dismiss)
function showAlert(options) {
    Swal.fire({
        title: options.title || 'Informasi',
        text: options.text,
        icon: options.icon || 'info',
        confirmButtonColor: '#10b981',
        confirmButtonText: 'OK',
        background: '#1f2937',
        color: '#e5e7eb'
    });
}
