<?php

namespace Database\Seeders;

use App\Models\FinanceCategory;
use Illuminate\Database\Seeder;

class FinanceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Pemasukan (Income)
            ['name' => 'Pendapatan Asli Desa (PAD)', 'type' => 'income', 'description' => 'Pendapatan dari hasil usaha desa, hasil aset, swadaya, partisipasi dan gotong royong'],
            ['name' => 'Dana Desa', 'type' => 'income', 'description' => 'Dana yang bersumber dari APBN'],
            ['name' => 'Alokasi Dana Desa (ADD)', 'type' => 'income', 'description' => 'Dana perimbangan dari kabupaten/kota'],
            ['name' => 'Bantuan Pemerintah', 'type' => 'income', 'description' => 'Bantuan dari pemerintah pusat, provinsi, atau kabupaten/kota'],
            ['name' => 'Sumbangan/Hibah', 'type' => 'income', 'description' => 'Sumbangan dari pihak ketiga yang tidak mengikat'],
            ['name' => 'Pendapatan Lain-lain', 'type' => 'income', 'description' => 'Pendapatan desa diluar kategori utama'],

            // Pengeluaran (Expense)
            ['name' => 'Belanja Pegawai', 'type' => 'expense', 'description' => 'Gaji dan tunjangan perangkat desa'],
            ['name' => 'Belanja Operasional', 'type' => 'expense', 'description' => 'Biaya operasional kantor desa'],
            ['name' => 'Belanja Pembangunan', 'type' => 'expense', 'description' => 'Biaya pembangunan infrastruktur desa'],
            ['name' => 'Belanja Sosial', 'type' => 'expense', 'description' => 'Bantuan sosial untuk masyarakat'],
            ['name' => 'Belanja Modal', 'type' => 'expense', 'description' => 'Pengadaan aset tetap desa'],
            ['name' => 'Belanja Lainnya', 'type' => 'expense', 'description' => 'Pengeluaran diluar kategori utama'],
        ];

        foreach ($categories as $category) {
            FinanceCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
