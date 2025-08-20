@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-primary me-3">
                            <i class="ti ti-users text-primary f-24"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-dark fw-bold">Data Penduduk</h4>
                            <p class="text-muted mb-0">Kelola dan pantau data kependudukan desa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-2 f-w-400 text-muted">Total Penduduk</h6>
                        <h4 class="mb-0">{{ $residents->count() }}</h4>
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
                        <h6 class="mb-2 f-w-400 text-muted">Laki-laki</h6>
                        <h4 class="mb-0">{{ $residents->where('gender', 'male')->count() }}</h4>
                    </div>
                    <div class="avtar avtar-s bg-light-success">
                        <i class="ti ti-user f-20"></i>
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
                        <h6 class="mb-2 f-w-400 text-muted">Perempuan</h6>
                        <h4 class="mb-0">{{ $residents->where('gender', 'female')->count() }}</h4>
                    </div>
                    <div class="avtar avtar-s bg-light-warning">
                        <i class="ti ti-user-circle f-20"></i>
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
                        <h6 class="mb-2 f-w-400 text-muted">Status Aktif</h6>
                        {{-- MODIFIKASI: Menggunakan value 'active' --}}
                        <h4 class="mb-0">{{ $residents->where('status', 'active')->count() }}</h4>
                    </div>
                    <div class="avtar avtar-s bg-light-info">
                        <i class="ti ti-check-circle f-20"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="ti ti-list me-2 text-primary"></i>Daftar Penduduk
                </h5>
                <a href="/resident/create" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>Tambah Penduduk
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-top-0">NO</th>
                                <th class="border-top-0">NIK</th>
                                <th class="border-top-0">NAMA</th>
                                <th class="border-top-0">JENIS KELAMIN</th>
                                <th class="border-top-0">TEMPAT, TANGGAL LAHIR</th>
                                <th class="border-top-0">ALAMAT</th>
                                <th class="border-top-0">AGAMA</th>
                                <th class="border-top-0">STATUS PERKAWINAN</th>
                                <th class="border-top-0">PEKERJAAN</th>
                                <th class="border-top-0">TELEPON</th>
                                <th class="border-top-0">STATUS</th>
                                <th class="border-top-0 text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($residents as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <span class="text-primary f-w-600">{{ $item->nik }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="f-w-500">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    {{-- MODIFIKASI: Kondisi berdasarkan value 'L' --}}
                                    <span class="badge {{ $item->gender == 'male' ? 'bg-light-success border border-success' : 'bg-light-warning border border-warning' }}">
                                        <i class="ti {{ $item->gender == 'male' ? 'ti-user' : 'ti-user-circle' }} me-1"></i>
                                        {{-- MODIFIKASI: Menampilkan teks berdasarkan value --}}
                                        @if($item->gender == 'male')
                                            Laki-laki
                                        @else
                                            Perempuan
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <span class="d-block f-w-500">{{ $item->birth_place }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->birth_date)->format('d M Y') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted" title="{{ $item->address }}">
                                        {{ Str::limit($item->address, 30) }}
                                    </span>
                                </td>
                                <td>{{ $item->religion }}</td>
                                <td>
                                    <span class="badge bg-light-info border border-info">
                                        {{-- MODIFIKASI (Penyempurnaan): Menampilkan teks berdasarkan value --}}
                                        @switch($item->marital_status)
                                            @case('single')
                                                Belum Menikah
                                                @break
                                            @case('married')
                                                Menikah
                                                @break
                                            @case('divorced')
                                                Cerai
                                                @break
                                            @case('widowed')
                                                Janda/Duda
                                                @break
                                            @default
                                                {{ $item->marital_status }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>{{ $item->occupation }}</td>
                                <td>
                                    @if($item->phone)
                                        <a href="tel:{{ $item->phone }}" class="text-decoration-none">
                                            <i class="ti ti-phone me-1"></i>{{ $item->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-flex align-items-center gap-2">
                                        {{-- MODIFIKASI: Kondisi warna berdasarkan value --}}
                                        <i class="fas fa-circle {{ $item->status == 'active' ? 'text-success' : 'text-danger' }} f-10"></i>
                                        {{-- MODIFIKASI: Menampilkan teks berdasarkan value --}}
                                        @switch($item->status)
                                            @case('active')
                                                Aktif
                                                @break
                                            @case('moved')
                                                Pindah
                                                @break
                                            @case('divorced') {{-- Sesuai value 'Almarhum' di create.blade.php --}}
                                                Almarhum
                                                @break
                                            @default
                                                {{ $item->status }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="/resident/{{ $item->id }}/edit" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-light-danger">
                                            <h5 class="modal-title text-danger" id="deleteModalLabel{{ $item->id }}">
                                                <i class="ti ti-trash me-2"></i>Konfirmasi Hapus
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <div class="avtar avtar-xl bg-light-danger text-danger mb-3 mx-auto">
                                                    <i class="ti ti-trash f-24"></i>
                                                </div>
                                                <h6 class="mb-2">Hapus Data Penduduk</h6>
                                                <p class="text-muted mb-0">Apakah Anda yakin ingin menghapus data penduduk <strong>{{ $item->name }}</strong>?</p>
                                                <small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="/resident/{{ $item->id }}" method="POST" class="d-inline">
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
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="avtar avtar-xl bg-light-secondary mb-3 mx-auto">
                                            <i class="ti ti-users f-36 text-muted"></i>
                                        </div>
                                        <h6 class="mb-1">Tidak ada data penduduk</h6>
                                        <p class="text-muted mb-4">Belum ada data penduduk yang terdaftar dalam sistem</p>
                                        <a href="/resident/create" class="btn btn-primary">
                                            <i class="ti ti-plus me-1"></i>Tambah Penduduk Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($residents->count() > 10)
                <div class="card-footer bg-light border-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <small class="text-muted">
                                Menampilkan {{ $residents->firstItem() ?? 0 }} sampai {{ $residents->lastItem() ?? 0 }} 
                                dari {{ $residents->total() ?? $residents->count() }} data
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            @if(method_exists($residents, 'links'))
                                {{ $residents->links() }}
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection