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
                                <h4 class="mb-0">{{ $residents->total() }}</h4>
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
                                <h4 class="mb-0">{{ $residents->where('status', 'active')->count() }}</h4>
                            </div>
                            <div class="avtar avtar-s bg-light-info">
                                <i class="ti ti-check-circle f-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
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
                                        <th class="border-top-0 text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($residents as $item)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration + $residents->firstItem() - 1 }}
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
                                                <span
                                                    class="badge {{ $item->gender == 'male' ? 'bg-light-success border border-success' : 'bg-light-warning border border-warning' }}">
                                                    <i
                                                        class="ti {{ $item->gender == 'male' ? 'ti-user' : 'ti-user-circle' }} me-1"></i>
                                                    @if ($item->gender == 'male')
                                                        Laki-laki
                                                    @else
                                                        Perempuan
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="d-block f-w-500">{{ $item->birth_place }}</span>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($item->birth_date)->format('d M Y') }}</small>
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
                                                @if ($item->phone)
                                                    <a href="tel:{{ $item->phone }}" class="text-decoration-none">
                                                        <i class="ti ti-phone me-1"></i>{{ $item->phone }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="d-flex align-items-center gap-2">
                                                    <i
                                                        class="fas fa-circle {{ $item->status == 'active' ? 'text-success' : 'text-danger' }} f-10"></i>
                                                    @switch($item->status)
                                                        @case('active')
                                                            Aktif
                                                        @break

                                                        @case('moved')
                                                            Pindah
                                                        @break

                                                        @case('deceased')
                                                            Almarhum
                                                        @break

                                                        @default
                                                            {{ ucfirst($item->status) }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a href="/resident/{{ $item->id }}/edit"
                                                        class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->id }}" title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                    @if ($item->user)
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewUserModal{{ $item->user->id }}"
                                                            title="Lihat Detail Akun">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Delete Modal --}}
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-light-danger">
                                                        <h5 class="modal-title text-danger"
                                                            id="deleteModalLabel{{ $item->id }}">
                                                            <i class="ti ti-trash me-2"></i>Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <div
                                                                class="avtar avtar-xl bg-light-danger text-danger mb-3 mx-auto">
                                                                <i class="ti ti-trash f-24"></i>
                                                            </div>
                                                            <h6 class="mb-2">Hapus Data Penduduk</h6>
                                                            <p class="text-muted mb-0">Apakah Anda yakin ingin menghapus
                                                                data penduduk <strong>{{ $item->name }}</strong>?</p>
                                                            <small class="text-danger">Tindakan ini tidak dapat
                                                                dibatalkan!</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="/resident/{{ $item->id }}" method="POST"
                                                            class="d-inline">
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
                                            <td colspan="12" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="avtar avtar-xl bg-light-secondary mb-3 mx-auto">
                                                        <i class="ti ti-users f-36 text-muted"></i>
                                                    </div>
                                                    <h6 class="mb-1">Tidak ada data penduduk</h6>
                                                    <p class="text-muted mb-4">Belum ada data penduduk yang terdaftar dalam
                                                        sistem</p>
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
                    </div>

                    {{-- Pagination Footer --}}
                    @if ($residents->hasPages())
                        <div class="card-footer bg-light border-0">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        Menampilkan {{ $residents->firstItem() }} sampai
                                        {{ $residents->lastItem() }} dari {{ $residents->total() }} data
                                    </small>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    {{ $residents->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal Detail Akun untuk setiap penduduk yang memiliki akun --}}
        @foreach ($residents as $item)
            @if ($item->user)
                <div class="modal fade" id="viewUserModal{{ $item->user->id }}" tabindex="-1"
                    aria-labelledby="viewUserModalLabel{{ $item->user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            {{-- Modal Header --}}
                            <div class="modal-header bg-light-primary border-0">
                                <h5 class="modal-title text-primary fw-bold" id="viewUserModalLabel{{ $item->user->id }}">
                                    <i class="ti ti-user-circle me-2"></i>Detail Akun Penduduk
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            {{-- Modal Body --}}
                            <div class="modal-body p-4">
                                {{-- Profile Header --}}
                                <div class="row mb-4">
                                    <div class="col-auto">
                                        <div class="avtar avtar-xl bg-primary text-white">
                                            <span class="f-24 fw-bold">
                                                {{ strtoupper(substr($item->user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-1 fw-bold">{{ $item->user->name }}</h5>
                                        <p class="text-muted mb-2">{{ $item->user->email }}</p>
                                        <div class="d-flex gap-2">
                                            @if ($item->user->status == 'approved')
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i>Akun Aktif
                                                </span>
                                            @elseif($item->user->status == 'submitted')
                                                <span class="badge bg-warning">
                                                    <i class="ti ti-clock me-1"></i>Menunggu Persetujuan
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="ti ti-x me-1"></i>Tidak Aktif
                                                </span>
                                            @endif

                                            <span class="badge bg-light text-dark border">
                                                <i class="ti ti-id me-1"></i>ID: {{ $item->user->id }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Account Information --}}
                                <div class="row">
                                    {{-- Left Column --}}
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-header bg-transparent border-0 pb-2">
                                                <h6 class="mb-0 text-primary fw-bold">
                                                    <i class="ti ti-user me-2"></i>Informasi Akun
                                                </h6>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="mb-3">
                                                    <label class="text-muted small fw-bold">NAMA LENGKAP</label>
                                                    <p class="mb-0 fw-semibold">{{ $item->user->name }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="text-muted small fw-bold">EMAIL</label>
                                                    <p class="mb-0">
                                                        <i class="ti ti-mail me-1 text-primary"></i>{{ $item->user->email }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="text-muted small fw-bold">NOMOR TELEPON</label>
                                                    <p class="mb-0">
                                                        @if ($item->user->phone)
                                                            <i
                                                                class="ti ti-phone me-1 text-success"></i>{{ $item->user->phone }}
                                                        @else
                                                            <span class="text-muted">
                                                                <i class="ti ti-phone-off me-1"></i>Tidak tersedia
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="text-muted small fw-bold">STATUS AKUN</label>
                                                    <p class="mb-0">
                                                        @switch($item->user->status)
                                                            @case('approved')
                                                                <span class="badge bg-success">
                                                                    <i class="ti ti-check me-1"></i>Disetujui & Aktif
                                                                </span>
                                                            @break

                                                            @case('submitted')
                                                                <span class="badge bg-warning">
                                                                    <i class="ti ti-clock me-1"></i>Menunggu Persetujuan
                                                                </span>
                                                            @break

                                                            @case('rejected')
                                                                <span class="badge bg-danger">
                                                                    <i class="ti ti-x me-1"></i>Ditolak
                                                                </span>
                                                            @break

                                                            @default
                                                                <span class="badge bg-secondary">
                                                                    <i
                                                                        class="ti ti-question-mark me-1"></i>{{ ucfirst($item->user->status) }}
                                                                </span>
                                                        @endswitch
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Right Column --}}
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-header bg-transparent border-0 pb-2">
                                                <h6 class="mb-0 text-info fw-bold">
                                                    <i class="ti ti-clock me-2"></i>Aktivitas Akun
                                                </h6>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="mb-3">
                                                    <label class="text-muted small fw-bold">TANGGAL MENDAFTAR</label>
                                                    <p class="mb-0">
                                                        <i class="ti ti-calendar-plus me-1 text-primary"></i>
                                                        {{ $item->user->created_at->format('d F Y') }}
                                                    </p>
                                                    <small class="text-muted">{{ $item->user->created_at->format('H:i') }}
                                                        WIB</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="text-muted small fw-bold">BERGABUNG SEJAK</label>
                                                    <p class="mb-0">
                                                        <span class="badge bg-light text-dark border">
                                                            <i
                                                                class="ti ti-hourglass me-1"></i>{{ $item->user->created_at->diffForHumans() }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="text-muted small fw-bold">TERAKHIR DIPERBARUI</label>
                                                    <p class="mb-0">
                                                        <i class="ti ti-refresh me-1 text-success"></i>
                                                        {{ $item->user->updated_at->format('d F Y, H:i') }} WIB
                                                    </p>
                                                    <small
                                                        class="text-muted">{{ $item->user->updated_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Connection Info --}}
                                <div class="mt-4 p-3 bg-light-success rounded">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="mb-1 text-success fw-bold">
                                                <i class="ti ti-link me-2"></i>Terhubung dengan Data Penduduk
                                            </h6>
                                            <p class="text-muted mb-0 small">
                                                Akun ini terhubung dengan data penduduk: <strong>{{ $item->name }}</strong>
                                                (NIK: {{ $item->nik }})
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <div class="avtar avtar-s bg-success text-white">
                                                <i class="ti ti-check f-16"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Footer --}}
                            <div class="modal-footer bg-light border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="ti ti-x me-1"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection