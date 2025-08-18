@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0"><i class="ti ti-user-plus me-2"></i>Form ubah Penduduk</h5>
                    <small class="text-muted">Lengkapi semua data penduduk dengan benar</small>
                </div>
                <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                    <i class="ti ti-users f-18"></i>
                </div>
            </div>
            
            <form action="/resident/{{ $resident->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <div class="flex-grow-1 ms-3">
                                <h6 class="alert-heading mb-1">
                                    <i class="ti ti-alert-circle me-2"></i>
                                    Terdapat kesalahan validasi:
                                </h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3 f-w-600 text-primary">
                                <i class="ti ti-id me-2"></i>Data Identitas
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nik" class="form-label">
                                    <i class="ti ti-id-badge me-1"></i>NIK
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                       id="nik" name="nik" value="{{ old('nik', $resident->nik) }}" maxlength="16" 
                                       placeholder="Masukkan 16 digit NIK">
                                @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="ti ti-user me-1"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $resident->name) }}" 
                                       placeholder="Masukkan nama lengkap">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gender" class="form-label">
                                    <i class="ti ti-gender-bigender me-1"></i>Jenis Kelamin
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="male" @selected(old('gender', $resident->gender) == 'male')>
                                        Laki-laki
                                    </option>
                                    <option value="female" @selected(old('gender', $resident->gender) == 'female')>
                                        Perempuan
                                    </option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">
                                    <i class="ti ti-calendar me-1"></i>Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" name="birth_date" value="{{ old('birth_date', $resident->birth_date) }}">
                                @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="birth_place" class="form-label">
                                    <i class="ti ti-map-pin me-1"></i>Tempat Lahir
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" 
                                       id="birth_place" name="birth_place" value="{{ old('birth_place', $resident->birth_place) }}" 
                                       placeholder="Contoh: Jakarta">
                                @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <label for="address" class="form-label">
                                    <i class="ti ti-home me-1"></i>Alamat Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" 
                                          placeholder="Masukkan alamat lengkap (RT/RW, Kelurahan, Kecamatan, dll)">{{ old('address' , $resident->address) }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr class="my-4">
                            <h6 class="mb-3 f-w-600 text-success">
                                <i class="ti ti-user-circle me-2"></i>Data Personal
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="religion" class="form-label">
                                    <i class="ti ti-book me-1"></i>Agama
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Agama</option>
                                    <option value="Islam" @selected(old('religion', $resident->religion) == 'Islam')>Islam</option>
                                    <option value="Kristen" @selected(old('religion', $resident->religion) == 'Kristen')>Kristen</option>
                                    <option value="Katolik" @selected(old('religion', $resident->religion) == 'Katolik')>Katolik</option>
                                    <option value="Hindu" @selected(old('religion', $resident->religion) == 'Hindu')>Hindu</option>
                                    <option value="Buddha" @selected(old('religion', $resident->religion) == 'Buddha')>Buddha</option>
                                    <option value="Konghucu" @selected(old('religion', $resident->religion) == 'Konghucu')>Konghucu</option>
                                </select>
                                @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="marital_status" class="form-label">
                                    <i class="ti ti-heart me-1"></i>Status Perkawinan
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="marital_status" id="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Status Perkawinan</option>
                                    <option value="single" @selected(old('marital_status', $resident->marital_status) == 'single')>Belum Menikah</option>
                                    <option value="married" @selected(old('marital_status', $resident->marital_status) == 'married')>Menikah</option>
                                    <option value="divorced" @selected(old('marital_status', $resident->marital_status) == 'divorced')>Cerai</option>
                                    <option value="widowed" @selected(old('marital_status', $resident->marital_status) == 'widowed')>Janda/Duda</option>
                                </select>
                                @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="occupation" class="form-label">
                                    <i class="ti ti-briefcase me-1"></i>Pekerjaan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                       id="occupation" name="occupation" value="{{ old('occupation', $resident->occupation) }}" 
                                       placeholder="Contoh: PNS, Wiraswasta, dll">
                                @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr class="my-4">
                            <h6 class="mb-3 f-w-600 text-warning">
                                <i class="ti ti-phone me-2"></i>Data Kontak & Status
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="ti ti-device-mobile me-1"></i>Nomor Telepon
                                </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $resident->phone) }}" 
                                       placeholder="Contoh: 08123456789">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <i class="ti ti-flag me-1"></i>Status Kependudukan
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="active" @selected(old('status', $resident->status) == 'active')>Aktif</option>
                                    <option value="moved" @selected(old('status', $resident->status) == 'moved')>Pindah</option>
                                    <option value="deceased" @selected(old('status', $resident->status) == 'deceased')>Meninggal Dunia</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <div class="flex-shrink-0">
                                    <i class="ti ti-info-circle f-20"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Informasi:</strong> Field yang bertanda (*) wajib diisi. Pastikan semua data yang dimasukkan sudah benar sebelum menyimpan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                        </button>
                        <a href="/resident" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <small class="text-muted">
                        <i class="ti ti-clock me-1"></i>Form akan tersimpan otomatis setelah submit
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection