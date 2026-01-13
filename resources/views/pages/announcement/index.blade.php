@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-l bg-light-primary me-3">
                            <i class="ti ti-speakerphone text-primary f-24"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-dark fw-bold">Pengumuman</h4>
                            <p class="text-muted mb-0">Informasi terbaru dari pemerintah desa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @forelse($events as $event)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="avtar avtar-s me-3" style="background: {{ $event->category_color }}20;">
                            <i class="ti ti-calendar-event" style="color: {{ $event->category_color }};"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ $event->title }}</h6>
                            <small class="text-muted">{{ $event->date_range }}</small>
                        </div>
                    </div>
                    
                    @if($event->location)
                    <div class="d-flex align-items-center mb-2">
                        <i class="ti ti-map-pin text-muted me-2"></i>
                        <small class="text-muted">{{ $event->location }}</small>
                    </div>
                    @endif

                    @if($event->description)
                    <p class="text-muted small mb-3">{{ Str::limit($event->description, 100) }}</p>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        {!! $event->category_badge !!}
                        <a href="{{ route('event.show', $event) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye me-1"></i>Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="avtar avtar-xl bg-light-secondary mx-auto mb-3">
                        <i class="ti ti-speakerphone text-secondary f-36"></i>
                    </div>
                    <h5 class="text-muted">Belum Ada Pengumuman</h5>
                    <p class="text-muted mb-0">Pengumuman terbaru akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($events->hasPages())
    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
            {{ $events->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
