@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Preview Surat</h4>
                    <p class="text-muted mb-0">{{ $letter->template->name }} - {{ $letter->letter_number }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('letter.show', $letter) }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                    <a href="{{ route('letter.download', $letter) }}" class="btn btn-primary">
                        <i class="ti ti-download me-1"></i>Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="letter-preview bg-white text-dark p-5 rounded" style="max-width: 800px; margin: 0 auto;">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>

<style>
.letter-preview {
    font-family: 'Times New Roman', serif;
    font-size: 12pt;
    line-height: 1.6;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
</style>
@endsection
