<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kependudukan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #10b981;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .summary-box {
            background: #f0fdf4;
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 10px;
        }
        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
        }
        h2 {
            color: #10b981;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #10b981;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEPENDUDUKAN</h1>
        <p>Desa Sejahtera | Tanggal: {{ date('d F Y') }}</p>
    </div>

    <div class="summary-box">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ number_format($totalResidents) }}</div>
                <div class="summary-label">Total Penduduk</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ number_format($maleCount) }}</div>
                <div class="summary-label">Laki-laki ({{ $totalResidents > 0 ? round($maleCount / $totalResidents * 100, 1) : 0 }}%)</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ number_format($femaleCount) }}</div>
                <div class="summary-label">Perempuan ({{ $totalResidents > 0 ? round($femaleCount / $totalResidents * 100, 1) : 0 }}%)</div>
            </div>
        </div>
    </div>

    <h2>Distribusi Agama</h2>
    <table>
        <thead>
            <tr>
                <th>Agama</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($religionData as $religion)
            <tr>
                <td>{{ $religion->religion ?? 'Tidak Diketahui' }}</td>
                <td>{{ number_format($religion->total) }}</td>
                <td>{{ $totalResidents > 0 ? round($religion->total / $totalResidents * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Status Perkawinan</h2>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maritalData as $marital)
            <tr>
                <td>{{ $maritalLabels[$marital->marital_status] ?? $marital->marital_status }}</td>
                <td>{{ number_format($marital->total) }}</td>
                <td>{{ $totalResidents > 0 ? round($marital->total / $totalResidents * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Distribusi Pekerjaan (Top 10)</h2>
    <table>
        <thead>
            <tr>
                <th>Pekerjaan</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($occupationData as $occupation)
            <tr>
                <td>{{ $occupation->occupation ?? 'Tidak Bekerja' }}</td>
                <td>{{ number_format($occupation->total) }}</td>
                <td>{{ $totalResidents > 0 ? round($occupation->total / $totalResidents * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Desa (SiDesa)</p>
        <p>© {{ date('Y') }} - All rights reserved</p>
    </div>
</body>
</html>
