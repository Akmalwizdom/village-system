@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Agenda Kegiatan</h4>
                    <p class="text-muted mb-0">Kalender kegiatan desa</p>
                </div>
                @if(Auth::user()->role_id == 1)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="ti ti-plus me-1"></i>Tambah Kegiatan
                </button>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="ti ti-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="ti ti-alert-circle me-2"></i>
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3">
        <!-- Calendar -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-calendar me-2 text-primary"></i>Kalender</h5>
                    <form action="{{ route('event.index') }}" method="GET" class="d-flex gap-2">
                        <input type="month" name="month" class="form-control form-control-sm" value="{{ $month }}">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-filter"></i></button>
                    </form>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Category Legend -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="ti ti-palette me-2 text-primary"></i>Kategori</h6>
                </div>
                <div class="card-body py-2">
                    @foreach(\App\Models\Event::CATEGORIES as $key => $label)
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge me-2" style="background: {{ \App\Models\Event::CATEGORY_COLORS[$key] }}; width: 12px; height: 12px;"></span>
                        <small>{{ $label }}</small>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="ti ti-clock me-2 text-primary"></i>Kegiatan Mendatang</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($upcomingEvents as $event)
                        <li class="list-group-item">
                            <div class="d-flex align-items-start">
                                <div class="me-2 mt-1" style="width: 8px; height: 8px; border-radius: 50%; background: {{ $event->category_color }};"></div>
                                <div class="flex-grow-1">
                                    <a href="{{ route('event.show', $event) }}" class="fw-medium text-decoration-none">
                                        {{ Str::limit($event->title, 30) }}
                                    </a>
                                    <div class="text-muted small">
                                        <i class="ti ti-calendar-event me-1"></i>{{ $event->formatted_start_date }}
                                    </div>
                                    @if($event->location)
                                    <div class="text-muted small">
                                        <i class="ti ti-map-pin me-1"></i>{{ $event->location }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted py-4">
                            Tidak ada kegiatan mendatang
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Event List -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-transparent">
            <h5 class="mb-0"><i class="ti ti-list me-2 text-primary"></i>Daftar Kegiatan - {{ $date->translatedFormat('F Y') }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kegiatan</th>
                            <th>Kategori</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            @if(Auth::user()->role_id == 1)
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>
                                <a href="{{ route('event.show', $event) }}" class="fw-medium text-decoration-none">
                                    {{ $event->title }}
                                </a>
                            </td>
                            <td>{!! $event->category_badge !!}</td>
                            <td>{{ $event->date_range }}</td>
                            <td>{{ $event->location ?? '-' }}</td>
                            @if(Auth::user()->role_id == 1)
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('event.edit', $event) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('event.destroy', $event) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role_id == 1 ? 5 : 4 }}" class="text-center py-4 text-muted">
                                Tidak ada kegiatan di bulan ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
@if(Auth::user()->role_id == 1)
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('event.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">
                        <i class="ti ti-calendar-plus me-2 text-primary"></i>Tambah Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="Contoh: Rapat RT Bulanan" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                @foreach(\App\Models\Event::CATEGORIES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-medium">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   placeholder="Contoh: Balai Desa">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_all_day" name="is_all_day" value="1">
                            <label class="form-check-label" for="is_all_day">Sepanjang hari (tanpa waktu spesifik)</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-medium">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 time-field">
                            <label for="start_time" class="form-label fw-medium">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" value="08:00">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-medium">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="col-md-6 time-field">
                            <label for="end_time" class="form-label fw-medium">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Detail kegiatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Simpan Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
#calendar {
    min-height: 400px;
}
.fc {
    font-size: 0.9rem;
}
.fc-toolbar-title {
    font-size: 1.2rem !important;
}
.fc-event {
    cursor: pointer;
    padding: 2px 4px;
}
.fc-daygrid-day.fc-day-today {
    background: rgba(16, 185, 129, 0.1) !important;
}
.fc-theme-standard td, .fc-theme-standard th {
    border-color: #374151;
}
.fc-col-header-cell {
    background: #1f2937;
}
</style>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet'>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '{{ $date->format("Y-m-d") }}',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        events: @json($calendarEvents),
        eventClick: function(info) {
            if (info.event.url) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            }
        },
        height: 'auto',
        locale: 'id',
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            list: 'List'
        }
    });
    calendar.render();

    // Toggle time fields based on all-day checkbox
    const allDayCheckbox = document.getElementById('is_all_day');
    const timeFields = document.querySelectorAll('.time-field');

    if (allDayCheckbox) {
        function toggleTimeFields() {
            timeFields.forEach(field => {
                field.style.display = allDayCheckbox.checked ? 'none' : 'block';
            });
        }

        allDayCheckbox.addEventListener('change', toggleTimeFields);
        toggleTimeFields();
    }
});
</script>
@endsection
