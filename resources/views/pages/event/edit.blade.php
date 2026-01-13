@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Edit Kegiatan</h4>
                    <p class="text-muted mb-0">Perbarui data kegiatan</p>
                </div>
                <a href="{{ route('event.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="ti ti-edit me-2 text-primary"></i>Form Edit Kegiatan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('event.update', $event) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="form-label fw-medium">Judul Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $event->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $event->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-medium">Lokasi</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location', $event->location) }}">
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_all_day" name="is_all_day" value="1" 
                                       {{ old('is_all_day', $event->is_all_day) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_all_day">Sepanjang hari</label>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-medium">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 time-field">
                                <label for="start_time" class="form-label fw-medium">Waktu Mulai</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" 
                                       value="{{ old('start_time', $event->start_date->format('H:i')) }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-medium">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6 time-field">
                                <label for="end_time" class="form-label fw-medium">Waktu Selesai</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" 
                                       value="{{ old('end_time', $event->end_date ? $event->end_date->format('H:i') : '') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-medium">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('event.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const allDayCheckbox = document.getElementById('is_all_day');
    const timeFields = document.querySelectorAll('.time-field');

    function toggleTimeFields() {
        timeFields.forEach(field => {
            field.style.display = allDayCheckbox.checked ? 'none' : 'block';
        });
    }

    allDayCheckbox.addEventListener('change', toggleTimeFields);
    toggleTimeFields();
});
</script>
@endsection
