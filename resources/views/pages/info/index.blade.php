@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-info me-3">
                            <i class="ti ti-info-circle text-info f-24"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-dark fw-bold">Informasi Layanan Desa</h4>
                            <p class="text-muted mb-0">Panduan layanan yang tersedia di Kantor Desa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Layanan Surat -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avtar avtar-l bg-light-primary mb-3">
                        <i class="ti ti-file-text text-primary f-24"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Pembuatan Surat</h5>
                    <p class="text-muted mb-3">Layanan pembuatan berbagai jenis surat keterangan resmi.</p>
                    <ul class="list-unstyled text-muted small mb-3">
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Surat Keterangan Domisili (SKD)</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Surat Keterangan Catatan Kepolisian (SKCK)</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Surat Keterangan Usaha (SKU)</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Surat Keterangan Tidak Mampu (SKTM)</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Surat Keterangan Pindah (SKP)</li>
                    </ul>
                    <a href="{{ route('letter.create') }}" class="btn btn-primary w-100">
                        <i class="ti ti-plus me-1"></i>Ajukan Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Layanan Pengaduan -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avtar avtar-l bg-light-warning mb-3">
                        <i class="ti ti-message-report text-warning f-24"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Pengaduan Warga</h5>
                    <p class="text-muted mb-3">Sampaikan keluhan, saran, atau aspirasi Anda kepada pemerintah desa.</p>
                    <ul class="list-unstyled text-muted small mb-3">
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Pengaduan infrastruktur</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Saran pembangunan</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Laporan keamanan</li>
                        <li class="mb-1"><i class="ti ti-check text-success me-2"></i>Aspirasi warga</li>
                    </ul>
                    <a href="/complaint" class="btn btn-warning w-100">
                        <i class="ti ti-plus me-1"></i>Buat Pengaduan
                    </a>
                </div>
            </div>
        </div>

        <!-- Jam Operasional -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avtar avtar-l bg-light-success mb-3">
                        <i class="ti ti-clock text-success f-24"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Jam Operasional</h5>
                    <p class="text-muted mb-3">Jadwal pelayanan Kantor Desa untuk warga.</p>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Senin - Kamis</td>
                            <td class="fw-medium text-end">08:00 - 16:00 WIB</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jumat</td>
                            <td class="fw-medium text-end">08:00 - 11:30 WIB</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Sabtu - Minggu</td>
                            <td class="fw-medium text-end text-danger">Libur</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kontak -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avtar avtar-l bg-light-danger mb-3">
                        <i class="ti ti-phone text-danger f-24"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Kontak Desa</h5>
                    <p class="text-muted mb-3">Hubungi kami untuk informasi lebih lanjut.</p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="ti ti-phone text-muted me-2"></i>
                            <span class="text-muted">Telepon:</span>
                            <span class="fw-medium">021-1234567</span>
                        </li>
                        <li class="mb-2">
                            <i class="ti ti-mail text-muted me-2"></i>
                            <span class="text-muted">Email:</span>
                            <span class="fw-medium">desa@example.com</span>
                        </li>
                        <li class="mb-0">
                            <i class="ti ti-map-pin text-muted me-2"></i>
                            <span class="text-muted">Alamat:</span>
                            <span class="fw-medium">Jl. Desa Sejahtera No. 1</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Persyaratan -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avtar avtar-l bg-light-secondary mb-3">
                        <i class="ti ti-list-check text-secondary f-24"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Persyaratan Umum</h5>
                    <p class="text-muted mb-3">Dokumen yang perlu dibawa saat mengurus layanan.</p>
                    <ul class="list-unstyled text-muted small mb-0">
                        <li class="mb-1"><i class="ti ti-point text-primary me-1"></i>KTP asli dan fotokopi</li>
                        <li class="mb-1"><i class="ti ti-point text-primary me-1"></i>Kartu Keluarga (KK)</li>
                        <li class="mb-1"><i class="ti ti-point text-primary me-1"></i>Pas foto 3x4 (2 lembar)</li>
                        <li class="mb-1"><i class="ti ti-point text-primary me-1"></i>Surat pengantar RT/RW</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alur Pelayanan -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="avtar avtar-l bg-light-info mb-3">
                        <i class="ti ti-route text-info f-24"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Alur Pelayanan</h5>
                    <p class="text-muted mb-3">Langkah-langkah mengurus layanan di Kantor Desa.</p>
                    <ol class="list-unstyled text-muted small mb-0">
                        <li class="mb-2 d-flex">
                            <span class="badge bg-primary me-2">1</span>
                            <span>Ambil nomor antrian</span>
                        </li>
                        <li class="mb-2 d-flex">
                            <span class="badge bg-primary me-2">2</span>
                            <span>Serahkan dokumen persyaratan</span>
                        </li>
                        <li class="mb-2 d-flex">
                            <span class="badge bg-primary me-2">3</span>
                            <span>Tunggu proses verifikasi</span>
                        </li>
                        <li class="mb-0 d-flex">
                            <span class="badge bg-primary me-2">4</span>
                            <span>Terima dokumen jadi</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
