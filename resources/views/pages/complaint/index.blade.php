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
                                <i class="ti ti-message-report text-primary f-24"></i>
                            </div>
                            <div>
                                {{-- Judul dinamis berdasarkan role pengguna --}}
                                @if (Auth::user()->role_id == 1)
                                    <h4 class="mb-1 text-dark fw-bold">Daftar Seluruh Aduan</h4>
                                    <p class="text-muted mb-0">Pantau semua aduan yang dibuat oleh penduduk</p>
                                @else
                                    <h4 class="mb-1 text-dark fw-bold">Daftar Aduan Anda</h4>
                                    <p class="text-muted mb-0">Kelola dan pantau semua aduan yang telah Anda buat</p>
                                @endif
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
                            <i class="ti ti-list me-2 text-primary"></i>Data Aduan
                        </h5>
                        {{-- Tombol "Buat Aduan" hanya untuk penduduk --}}
                        @if (Auth::user()->role_id != 1)
                            <a href="/complaint/create" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>Buat Aduan Baru
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-top-0">NO</th>
                                        {{-- Kolom tambahan "Nama Pelapor" hanya untuk admin --}}
                                        @if (Auth::user()->role_id == 1)
                                            <th class="border-top-0">Nama Pelapor</th>
                                        @endif
                                        <th class="border-top-0">Judul Aduan</th>
                                        <th class="border-top-0">Isi Aduan</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Foto Bukti</th>
                                        <th class="border-top-0">Tanggal Laporan</th>
                                        {{-- Kolom "Aksi" untuk penduduk atau admin --}}
                                        <th class="border-top-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($complaints as $item)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration + $complaints->firstItem() - 1 }}
                                            </td>
                                            {{-- Menampilkan nama pelapor, hanya untuk admin --}}
                                            @if (Auth::user()->role_id == 1)
                                                <td>
                                                    {{ $item->resident->name ?? 'Data Penduduk Tidak Ditemukan' }}
                                                </td>
                                            @endif
                                            <td>
                                                <span class="f-w-600">{{ $item->title }}</span>
                                            </td>
                                            <td>
                                                {{ Str::limit($item->content, 70) }}
                                            </td>
                                            <td>
                                                {!! $item->status_label !!}
                                            </td>
                                            <td>
                                                @if ($item->photo_proof)
                                                    <div class="text-center">
                                                        <img src="{{ Storage::url($item->photo_proof) }}" alt="Foto Bukti"
                                                            width="80" height="60" class="img-thumbnail"
                                                            style="object-fit: cover;">
                                                        <br>
                                                        <small>
                                                            <a href="{{ Storage::url($item->photo_proof) }}" target="_blank"
                                                                class="text-primary text-decoration-none">
                                                                <i class="ti ti-external-link"></i> Detail
                                                            </a>
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                                            </td>
                                            {{-- Tombol aksi dinamis berdasarkan role --}}
                                            <td class="text-center">
                                                @if (Auth::user()->role_id == 1)
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton{{ $item->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Ubah Status
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                            <li>
                                                                <form action="/complaint/{{ $item->id }}/update-status"
                                                                    method="POST" class="d-inline">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    {{-- Ubah value menjadi 'new' --}}
                                                                    <input type="hidden" name="status" value="new">
                                                                    <button type="submit"
                                                                        class="dropdown-item">Baru</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="/complaint/{{ $item->id }}/update-status"
                                                                    method="POST" class="d-inline">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    {{-- Ubah value menjadi 'processing' --}}
                                                                    <input type="hidden" name="status" value="processing">
                                                                    <button type="submit" class="dropdown-item">Sedang
                                                                        Diproses</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="/complaint/{{ $item->id }}/update-status"
                                                                    method="POST" class="d-inline">
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    {{-- Ubah value menjadi 'completed' --}}
                                                                    <input type="hidden" name="status" value="completed">
                                                                    <button type="submit"
                                                                        class="dropdown-item">Selesai</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @else
                                                    {{-- Tombol Aksi untuk Penduduk --}}
                                                    <div class="btn-group" role="group">
                                                        <a href="/complaint/{{ $item->id }}/edit"
                                                            class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $item->id }}"
                                                            title="Hapus">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Modal Hapus --}}
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
                                                        <p>Apakah Anda yakin ingin menghapus aduan dengan judul
                                                            <strong>"{{ $item->title }}"</strong>?</p>
                                                        <small class="text-danger">Tindakan ini tidak dapat
                                                            dibatalkan!</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="/complaint/{{ $item->id }}" method="POST"
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
                                            <td colspan="{{ Auth::user()->role_id == 1 ? 8 : 7 }}"
                                                class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="avtar avtar-xl bg-light-secondary mb-3">
                                                        <i class="ti ti-file-off f-36 text-muted"></i>
                                                    </div>
                                                    @if (Auth::user()->role_id == 1)
                                                        <h6 class="mb-1">Belum Ada Aduan</h6>
                                                        <p class="text-muted mb-4">Saat ini belum ada aduan yang dibuat
                                                            oleh penduduk.</p>
                                                    @else
                                                        <h6 class="mb-1">Anda belum memiliki aduan</h6>
                                                        <p class="text-muted mb-4">Buat aduan pertama Anda sekarang</p>
                                                        <a href="/complaint/create" class="btn btn-primary">
                                                            <i class="ti ti-plus me-1"></i>Buat Aduan
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination Footer --}}
                    @if ($complaints->hasPages())
                        <div class="card-footer bg-light border-0">
                            {{ $complaints->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
