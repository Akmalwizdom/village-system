<?php

namespace App\Exports;

use App\Models\Resident;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResidentExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Resident::where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Telepon',
            'Alamat',
            'Status'
        ];
    }

    public function map($resident): array
    {
        static $no = 0;
        $no++;
        
        $genderLabels = ['male' => 'Laki-laki', 'female' => 'Perempuan'];
        $maritalLabels = [
            'single' => 'Belum Menikah',
            'married' => 'Menikah',
            'divorced' => 'Cerai',
            'widowed' => 'Duda/Janda'
        ];
        $statusLabels = [
            'active' => 'Aktif',
            'moved' => 'Pindah',
            'deceased' => 'Meninggal'
        ];
        
        $age = \Carbon\Carbon::parse($resident->birth_date)->age;
        
        return [
            $no,
            "'" . $resident->nik, // Prefix with ' to prevent Excel from treating as number
            $resident->name,
            $genderLabels[$resident->gender] ?? $resident->gender,
            $resident->birth_place,
            \Carbon\Carbon::parse($resident->birth_date)->format('d/m/Y'),
            $age . ' tahun',
            $resident->religion ?? '-',
            $maritalLabels[$resident->marital_status] ?? $resident->marital_status,
            $resident->occupation ?? '-',
            $resident->phone ?? '-',
            $resident->address,
            $statusLabels[$resident->status] ?? $resident->status
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '10B981']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]
            ]
        ];
    }
}
