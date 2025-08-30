@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0"><i class="ti ti-file-pencil me-2"></i>Form Tambah Aduan</h5>
                    <small class="text-muted">Lengkapi semua data aduan dengan benar</small>
                </div>
                <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                    <i class="ti ti-message-report f-18"></i>
                </div>
            </div>
            
            <form action="/complaint" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading mb-1"><i class="ti ti-alert-circle me-2"></i>Terdapat kesalahan validasi:</h6>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="ti ti-text-caption me-1"></i>Judul Aduan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" 
                               placeholder="Masukkan judul singkat untuk aduan Anda">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">
                            <i class="ti ti-file-text me-1"></i>Isi Aduan
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="5" 
                                  placeholder="Jelaskan isi aduan Anda secara rinci di sini">{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="photo_proof" class="form-label">
                            <i class="ti ti-camera me-1"></i>Foto Bukti (Opsional)
                        </label>
                        <input type="file" class="form-control @error('photo_proof') is-invalid @enderror" 
                               id="photo_proof" name="photo_proof" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted mt-1 d-block">Ukuran file maksimal 2MB. Format: JPG, PNG, JPEG.</small>
                        @error('photo_proof') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <div class="flex-shrink-0"><i class="ti ti-info-circle f-20"></i></div>
                        <div class="flex-grow-1 ms-3">
                            <strong>Informasi:</strong> Field yang bertanda (*) wajib diisi. Pastikan semua data yang dimasukkan sudah benar.
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-2"></i>Kirim Aduan
                        </button>
                        <a href="/complaint" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection