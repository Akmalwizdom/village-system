@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Detail Kegiatan</h4>
                    <p class="text-muted mb-0">{{ $event->category_label }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('event.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                    @if(Auth::user()->role_id == 1)
                    <a href="{{ route('event.edit', $event) }}" class="btn btn-warning">
                        <i class="ti ti-edit me-1"></i>Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 12px; height: 12px; border-radius: 50%; background: {{ $event->category_color }};"></div>
                        <h5 class="mb-0">{{ $event->title }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avtar avtar-s bg-light-primary me-3">
                                    <i class="ti ti-calendar-event text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Waktu</small>
                                    <span class="fw-medium">{{ $event->date_range }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avtar avtar-s bg-light-success me-3">
                                    <i class="ti ti-tag text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Kategori</small>
                                    {!! $event->category_badge !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($event->location)
                    <div class="d-flex align-items-center mb-4">
                        <div class="avtar avtar-s bg-light-warning me-3">
                            <i class="ti ti-map-pin text-warning"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Lokasi</small>
                            <span class="fw-medium">{{ $event->location }}</span>
                        </div>
                    </div>
                    @endif

                    @if($event->description)
                    <hr>
                    <h6 class="mb-3"><i class="ti ti-file-text me-2"></i>Deskripsi</h6>
                    <p class="mb-0">{!! nl2br(e($event->description)) !!}</p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">
                        <i class="ti ti-user me-1"></i>Dibuat oleh {{ $event->creator->name ?? 'Admin' }} 
                        pada {{ $event->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if(Auth::user()->role_id == 1)
            <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-danger mb-3"><i class="ti ti-alert-triangle me-2"></i>Zona Bahaya</h6>
                    <form action="{{ route('event.destroy', $event) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="ti ti-trash me-1"></i>Hapus Kegiatan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
