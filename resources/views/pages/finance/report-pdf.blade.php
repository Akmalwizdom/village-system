<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - {{ $date->translatedFormat('F Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        h1, h2 {
            margin: 0;
            color: #1f2937;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 18pt;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .summary-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 5px;
        }
        .summary-item.income { background: #d1fae5; }
        .summary-item.expense { background: #fee2e2; }
        .summary-item.balance { background: #dbeafe; }
        .summary-item h3 {
            margin: 0 0 5px;
            font-size: 10pt;
            color: #666;
        }
        .summary-item .value {
            font-size: 14pt;
            font-weight: bold;
        }
        .summary-item.income .value { color: #059669; }
        .summary-item.expense .value { color: #dc2626; }
        .summary-item.balance .value { color: #2563eb; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #f3f4f6;
            font-weight: bold;
        }
        .text-end { text-align: right; }
        .text-success { color: #059669; }
        .text-danger { color: #dc2626; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10pt;
            color: #666;
        }
        tfoot td {
            font-weight: bold;
            background: #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN DESA</h1>
        <p>Periode: {{ $date->translatedFormat('F Y') }}</p>
    </div>

    <table style="margin-bottom: 25px;">
        <tr>
            <td style="width: 33%; text-align: center; background: #d1fae5; padding: 15px;">
                <div style="font-size: 10pt; color: #666;">Total Pemasukan</div>
                <div style="font-size: 14pt; font-weight: bold; color: #059669;">
                    Rp {{ number_format($incomeTotal, 0, ',', '.') }}
                </div>
            </td>
            <td style="width: 33%; text-align: center; background: #fee2e2; padding: 15px;">
                <div style="font-size: 10pt; color: #666;">Total Pengeluaran</div>
                <div style="font-size: 14pt; font-weight: bold; color: #dc2626;">
                    Rp {{ number_format($expenseTotal, 0, ',', '.') }}
                </div>
            </td>
            <td style="width: 33%; text-align: center; background: #dbeafe; padding: 15px;">
                <div style="font-size: 10pt; color: #666;">Saldo</div>
                <div style="font-size: 14pt; font-weight: bold; color: {{ $balance >= 0 ? '#2563eb' : '#dc2626' }};">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <h2 style="font-size: 13pt; margin-bottom: 10px;">Daftar Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-end">Pemasukan</th>
                <th class="text-end">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
            <tr>
                <td>{{ $tx->transaction_date->format('d/m/Y') }}</td>
                <td>{{ $tx->category->name }}</td>
                <td>{{ $tx->description }}</td>
                <td class="text-end text-success">
                    {{ $tx->type === 'income' ? 'Rp ' . number_format($tx->amount, 0, ',', '.') : '-' }}
                </td>
                <td class="text-end text-danger">
                    {{ $tx->type === 'expense' ? 'Rp ' . number_format($tx->amount, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end">TOTAL</td>
                <td class="text-end text-success">Rp {{ number_format($incomeTotal, 0, ',', '.') }}</td>
                <td class="text-end text-danger">Rp {{ number_format($expenseTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB</p>
        <p style="margin-top: 30px;">
            Mengetahui,<br><br><br><br>
            <strong>Kepala Desa</strong>
        </p>
    </div>
</body>
</html>
