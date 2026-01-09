<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Surat - SiDesa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.30.0/tabler-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .verify-card {
            background: #1f2937;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            color: #e5e7eb;
        }
        .verify-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }
        .verify-icon.success {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }
        .verify-icon.error {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        .info-table td {
            padding: 8px 0;
            border-bottom: 1px solid #374151;
        }
        .info-table td:first-child {
            color: #9ca3af;
            width: 40%;
        }
        .badge-success {
            background: #10b981;
            color: white;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="verify-card">
        <div class="logo-text">
            <i class="ti ti-building-community me-2"></i>SiDesa
        </div>
        
        @if($letter)
            <div class="verify-icon success">
                <i class="ti ti-circle-check"></i>
            </div>
            <h4 class="text-center mb-4 text-white">Surat Terverifikasi</h4>
            
            <div class="alert" style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981;">
                <i class="ti ti-info-circle me-2"></i>
                Surat ini adalah dokumen resmi yang diterbitkan oleh sistem SiDesa.
            </div>

            <table class="table info-table">
                <tr>
                    <td>Nomor Surat</td>
                    <td class="fw-bold">{{ $letter->letter_number }}</td>
                </tr>
                <tr>
                    <td>Jenis Surat</td>
                    <td>
                        <span class="badge badge-success">{{ $letter->template->code }}</span>
                        {{ $letter->template->name }}
                    </td>
                </tr>
                <tr>
                    <td>Nama Pemohon</td>
                    <td class="fw-bold">{{ $letter->resident->name }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>{{ $letter->resident->nik }}</td>
                </tr>
                <tr>
                    <td>Tanggal Terbit</td>
                    <td>{{ $letter->approved_at ? $letter->approved_at->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        @if($letter->status === 'approved')
                            <span class="badge" style="background: #10b981;">Disetujui</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($letter->status) }}</span>
                        @endif
                    </td>
                </tr>
            </table>

            <div class="text-center mt-4">
                <small class="text-muted">
                    Diverifikasi pada {{ now()->format('d F Y, H:i') }} WIB
                </small>
            </div>
        @else
            <div class="verify-icon error">
                <i class="ti ti-circle-x"></i>
            </div>
            <h4 class="text-center mb-4 text-white">Surat Tidak Ditemukan</h4>
            
            <div class="alert" style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444;">
                <i class="ti ti-alert-triangle me-2"></i>
                Kode QR tidak valid atau surat tidak terdaftar dalam sistem.
            </div>

            <p class="text-muted text-center">
                Jika Anda yakin ini adalah surat resmi, silakan hubungi kantor desa untuk verifikasi manual.
            </p>
        @endif
    </div>
</body>
</html>
