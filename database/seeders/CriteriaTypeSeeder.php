<?php

namespace Database\Seeders;

use App\Models\CriteriaType;
use Illuminate\Database\Seeder;

class CriteriaTypeSeeder extends Seeder
{
    public function run(): void
    {
        CriteriaType::truncate();
        CriteriaType::create([
            'type' => 'Teks',
        ]);
        CriteriaType::create([
            'type' => 'Teks Panjang',
        ]);
        CriteriaType::create([
            'type' => 'Email',
        ]);
        CriteriaType::create([
            'type' => 'Angka',
        ]);
        CriteriaType::create([
            'type' => 'Hari',
        ]);
        CriteriaType::create([
            'type' => 'Hanya Bulan dalam Nama Bulan',
        ]);
        CriteriaType::create([
            'type' => 'Tanggal',
        ]);
        CriteriaType::create([
            'type' => 'Tanggal dan Waktu',
        ]);
        CriteriaType::create([
            'type' => 'Waktu',
        ]);
        CriteriaType::create([
            'type' => 'Jam',
        ]);
        CriteriaType::create([
            'type' => 'Menit/Detik',
        ]);
        CriteriaType::create([
            'type' => 'Hanya Tanggal',
        ]);
        CriteriaType::create([
            'type' => 'Hanya Bulan dalam Angka',
        ]);
        CriteriaType::create([
            'type' => 'Hanya Tahun',
        ]);
        CriteriaType::create([
            'type' => 'Upload File',
        ]);
        CriteriaType::create([
            'type' => 'Pilihan (Ya/Tidak)',
        ]);
        CriteriaType::create([
            'type' => 'Pilihan Ganda (Radio)',
        ]);
        CriteriaType::create([
            'type' => 'Pilihan Ganda (Dropdown)',
        ]);
        CriteriaType::create([
            'type' => 'Pilihan (Multiple Checkbox)',
        ]);
        CriteriaType::create([
            'type' => 'Pilihan (Multiple Dropdown)',
        ]);
        CriteriaType::create([
            'type' => 'Range',
        ]);
        CriteriaType::create([
            'type' => 'Date Range',
        ]);
        CriteriaType::create([
            'type' => 'Custom',
        ]);
    }
}
