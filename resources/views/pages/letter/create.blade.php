@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Ajukan Surat Baru</h4>
                    <p class="text-muted mb-0">Pilih jenis surat dan isi keperluan</p>
                </div>
                <a href="{{ route('letter.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="ti ti-file-text me-2 text-primary"></i>Form Pengajuan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('letter.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-medium">Jenis Surat <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                @foreach($templates as $template)
                                <div class="col-md-6">
                                    <input class="btn-check" type="radio" name="letter_template_id" 
                                           id="template_{{ $template->id }}" value="{{ $template->id }}"
                                           {{ old('letter_template_id') == $template->id ? 'checked' : '' }}>
                                    <label class="btn template-card w-100 text-start p-3" for="template_{{ $template->id }}">
                                        <span class="badge bg-primary mb-2">{{ $template->code }}</span>
                                        <span class="d-block fw-medium mb-1">{{ $template->name }}</span>
                                        <small class="text-muted">{{ $template->description }}</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('letter_template_id')
                            <div class="text-danger mt-1"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="purpose" class="form-label fw-medium">Keperluan Surat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" 
                                      id="purpose" name="purpose" rows="4" 
                                      placeholder="Jelaskan keperluan pengajuan surat ini...">{{ old('purpose') }}</textarea>
                            @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: Untuk keperluan melamar pekerjaan di PT ABC</small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('letter.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-send me-1"></i>Ajukan Surat
                            </button>
                        </div>
                    </form>
                </div>
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
                            <td class="fw-medium">{{ $resident->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">NIK</td>
                            <td class="fw-medium">{{ $resident->nik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td class="fw-medium">{{ $resident->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avtar avtar-s bg-light-primary me-3">
                            <i class="ti ti-info-circle text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Informasi</h6>
                            <small class="text-muted">
                                Surat yang diajukan akan diproses oleh admin. Anda akan mendapat notifikasi setelah surat disetujui.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.template-card {
    border: 1px solid #374151;
    border-radius: 8px;
    background-color: transparent;
    color: #e5e7eb;
    transition: all 0.2s ease;
}
.template-card:hover {
    border-color: #10b981;
    background-color: rgba(16, 185, 129, 0.05);
    color: #e5e7eb;
}
.btn-check:checked + .template-card {
    border-color: #10b981;
    background-color: rgba(16, 185, 129, 0.15);
    color: #e5e7eb;
}
</style>
@endsection
