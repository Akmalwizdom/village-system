@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Pengajuan Surat</h4>
                    <p class="text-muted mb-0">Kelola pengajuan surat keterangan</p>
                </div>
                @if(Auth::user()->role_id != 1 && Auth::user()->resident)
                <a href="{{ route('letter.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>Ajukan Surat
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Surat</th>
                            <th>Jenis Surat</th>
                            @if(Auth::user()->role_id == 1)
                            <th>Pemohon</th>
                            @endif
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($letters as $letter)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $letter->letter_number }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $letter->template->code }}</span>
                                {{ $letter->template->name }}
                            </td>
                            @if(Auth::user()->role_id == 1)
                            <td>{{ $letter->resident->name ?? '-' }}</td>
                            @endif
                            <td>{{ Str::limit($letter->purpose, 30) }}</td>
                            <td>{!! $letter->status_label !!}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $letter->created_at->format('d M Y H:i') }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('letter.show', $letter) }}" class="btn btn-outline-primary" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    @if($letter->status === 'approved')
                                    <a href="{{ route('letter.download', $letter) }}" class="btn btn-outline-success" title="Download PDF">
                                        <i class="ti ti-download"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role_id == 1 ? 7 : 6 }}" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="ti ti-file-off f-24 d-block mb-2"></i>
                                    Belum ada pengajuan surat
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($letters instanceof \Illuminate\Pagination\LengthAwarePaginator && $letters->hasPages())
        <div class="card-footer">
            {{ $letters->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
