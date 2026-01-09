@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Detail Surat</h4>
                    <p class="text-muted mb-0">{{ $letter->template->name }}</p>
                </div>
                <a href="{{ route('letter.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="ti ti-x me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ti ti-file-text me-2 text-primary"></i>Informasi Surat
                    </h5>
                    {!! $letter->status_label !!}
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small">Nomor Surat</label>
                            <p class="fw-bold mb-0">{{ $letter->letter_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Jenis Surat</label>
                            <p class="fw-bold mb-0">
                                <span class="badge bg-primary me-1">{{ $letter->template->code }}</span>
                                {{ $letter->template->name }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small">Keperluan</label>
                        <p class="mb-0">{{ $letter->purpose }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Tanggal Pengajuan</label>
                            <p class="mb-0">{{ $letter->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        @if($letter->approved_at)
                        <div class="col-md-6">
                            <label class="text-muted small">Tanggal Disetujui</label>
                            <p class="mb-0">{{ $letter->approved_at->format('d F Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>

                    @if($letter->status === 'rejected' && $letter->rejection_reason)
                    <div class="alert alert-danger mt-4 mb-0">
                        <h6 class="alert-heading"><i class="ti ti-x me-1"></i>Alasan Penolakan:</h6>
                        <p class="mb-0">{{ $letter->rejection_reason }}</p>
                    </div>
                    @endif

                    @if($letter->approver)
                    <div class="mt-4 pt-3 border-top">
                        <label class="text-muted small">Disetujui oleh</label>
                        <p class="mb-0">{{ $letter->approver->name }}</p>
                    </div>
                    @endif
                </div>

                @if($letter->status === 'approved')
                <div class="card-footer bg-transparent">
                    <div class="d-flex gap-2">
                        <a href="{{ route('letter.preview', $letter) }}" class="btn btn-outline-primary">
                            <i class="ti ti-eye me-1"></i>Preview
                        </a>
                        <a href="{{ route('letter.download', $letter) }}" class="btn btn-primary">
                            <i class="ti ti-download me-1"></i>Download PDF
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="ti ti-user me-2 text-primary"></i>Data Pemohon
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Nama</td>
                            <td class="fw-medium">{{ $letter->resident->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">NIK</td>
                            <td class="fw-medium">{{ $letter->resident->nik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td class="fw-medium">{{ $letter->resident->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if(Auth::user()->role_id == 1 && $letter->status === 'pending')
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="ti ti-settings me-2 text-primary"></i>Aksi Admin
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('letter.approve', $letter) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="ti ti-check me-1"></i>Setujui Surat
                        </button>
                    </form>

                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="ti ti-x me-1"></i>Tolak Surat
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if(Auth::user()->role_id == 1 && $letter->status === 'pending')
<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pengajuan Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('letter.reject', $letter) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required
                                  placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
