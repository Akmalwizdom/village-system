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

    <div class="row g-3">
        <!-- Calendar -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="ti ti-calendar me-2 text-primary"></i>Kalender</h5>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Navigation buttons -->
                        <a href="{{ route('event.index', ['month' => $date->copy()->subMonth()->format('Y-m')]) }}" 
                           class="btn btn-sm btn-outline-secondary" title="Bulan Sebelumnya">
                            <i class="ti ti-chevron-left"></i>
                        </a>
                        
                        <!-- Date Picker -->
                        <div class="input-group input-group-sm" style="width: auto;">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="ti ti-calendar"></i>
                            </span>
                            <input type="text" class="form-control form-control-sm border-start-0" 
                                   id="monthPicker" 
                                   value="{{ $date->translatedFormat('d/m/Y') }}" 
                                   style="width: 110px;" readonly>
                        </div>
                        
                        <a href="{{ route('event.index', ['month' => $date->copy()->addMonth()->format('Y-m')]) }}" 
                           class="btn btn-sm btn-outline-secondary" title="Bulan Berikutnya">
                            <i class="ti ti-chevron-right"></i>
                        </a>
                        
                        <!-- Today button -->
                        <a href="{{ route('event.index') }}" class="btn btn-sm btn-primary" title="Bulan Ini">
                            <i class="ti ti-calendar-event me-1"></i>Hari Ini
                        </a>
                    </div>
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
                                    <button type="button" class="btn btn-outline-warning btn-edit" title="Edit"
                                            data-id="{{ $event->id }}"
                                            data-title="{{ $event->title }}"
                                            data-category="{{ $event->category }}"
                                            data-location="{{ $event->location }}"
                                            data-description="{{ $event->description }}"
                                            data-start-date="{{ $event->start_date->format('Y-m-d') }}"
                                            data-start-time="{{ $event->start_date->format('H:i') }}"
                                            data-end-date="{{ $event->end_date ? $event->end_date->format('Y-m-d') : '' }}"
                                            data-end-time="{{ $event->end_date ? $event->end_date->format('H:i') : '' }}"
                                            data-all-day="{{ $event->is_all_day ? '1' : '0' }}">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <form action="{{ route('event.destroy', $event) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-delete" title="Hapus">
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

<!-- Edit Event Modal -->
@if(Auth::user()->role_id == 1)
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editEventForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">
                        <i class="ti ti-edit me-2 text-warning"></i>Edit Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label fw-medium">Judul Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_category" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_category" name="category" required>
                                @foreach(\App\Models\Event::CATEGORIES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_location" class="form-label fw-medium">Lokasi</label>
                            <input type="text" class="form-control" id="edit_location" name="location">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_all_day" name="is_all_day" value="1">
                            <label class="form-check-label" for="edit_is_all_day">Sepanjang hari</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_start_date" class="form-label fw-medium">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 edit-time-field">
                            <label for="edit_start_time" class="form-label fw-medium">Waktu Mulai</label>
                            <input type="time" class="form-control" id="edit_start_time" name="start_time">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_end_date" class="form-label fw-medium">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date">
                        </div>
                        <div class="col-md-6 edit-time-field">
                            <label for="edit_end_time" class="form-label fw-medium">Waktu Selesai</label>
                            <input type="time" class="form-control" id="edit_end_time" name="end_time">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-medium">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-check me-1"></i>Simpan Perubahan
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

<!-- Flatpickr Date Picker -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<!-- FullCalendar -->
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

    // Initialize Flatpickr date picker
    flatpickr("#monthPicker", {
        locale: "id",
        dateFormat: "d/m/Y",
        defaultDate: "{{ $date->format('Y-m-d') }}",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const date = selectedDates[0];
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                window.location.href = "{{ route('event.index') }}?month=" + year + "-" + month;
            }
        }
    });

    // Toggle time fields based on all-day checkbox (Add Modal)
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

    // Toggle time fields for Edit Modal
    const editAllDayCheckbox = document.getElementById('edit_is_all_day');
    const editTimeFields = document.querySelectorAll('.edit-time-field');

    if (editAllDayCheckbox) {
        function toggleEditTimeFields() {
            editTimeFields.forEach(field => {
                field.style.display = editAllDayCheckbox.checked ? 'none' : 'block';
            });
        }

        editAllDayCheckbox.addEventListener('change', toggleEditTimeFields);
    }

    // Edit button handler - populate modal with data
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const category = this.dataset.category;
            const location = this.dataset.location;
            const description = this.dataset.description;
            const startDate = this.dataset.startDate;
            const startTime = this.dataset.startTime;
            const endDate = this.dataset.endDate;
            const endTime = this.dataset.endTime;
            const allDay = this.dataset.allDay === '1';

            // Set form action
            document.getElementById('editEventForm').action = '/event/' + id;

            // Populate fields
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_location').value = location || '';
            document.getElementById('edit_description').value = description || '';
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_start_time').value = startTime;
            document.getElementById('edit_end_date').value = endDate;
            document.getElementById('edit_end_time').value = endTime;
            document.getElementById('edit_is_all_day').checked = allDay;

            // Toggle time fields
            editTimeFields.forEach(field => {
                field.style.display = allDay ? 'none' : 'block';
            });

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editEventModal'));
            modal.show();
        });
    });

    // Delete confirmation with SweetAlert
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            confirmDelete(form, 'Kegiatan yang dihapus tidak dapat dikembalikan!');
        });
    });
});
</script>
@endsection
