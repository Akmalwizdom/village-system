@extends('layouts.app')

@section('title', 'Semua Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="card-title mb-0"><i class="ti ti-bell me-2"></i>Semua Notifikasi</h4>
                </div>

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse ($notifications as $notification)
                            <div class="list-group-item">
                                <div class="d-flex w-100 align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <span class="avtar avtar-s bg-light-secondary text-secondary">
                                            {{-- Icon bisa diganti sesuai tipe notifikasi jika ada --}}
                                            <i class="ti ti-info-circle"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">
                                                {{ $notification->data['notification_title'] ?? 'Status Aduan Diperbarui' }}
                                            </h6>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 text-sm text-muted">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <a href="{{ url('/complaint') }}" class="btn btn-sm btn-link p-0">Lihat Detail Aduan</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="ti ti-bell-off display-4 text-muted mb-3"></i>
                                <h6 class="text-muted">Tidak Ada Notifikasi</h6>
                                <p class="text-muted small mb-0">Semua notifikasi Anda akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Tampilkan link pagination jika ada lebih dari satu halaman --}}
                @if($notifications->hasPages())
                <div class="card-footer bg-white">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Tidak perlu ada @push('scripts') lagi di sini --}}