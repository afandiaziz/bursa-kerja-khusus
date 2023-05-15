<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Criteria;
use App\Models\CriteriaType;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private function criteriaTypeId($type): string
    {
        return CriteriaType::select('id')->where('type', $type)->first()->id;
    }

    public function run(): void
    {
        Criteria::truncate();
        Criteria::criteriaCreate([
            'name' => 'Nomor Handphone',
            'criteria_type_id' => $this->criteriaTypeId('Teks'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => true,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Tempat Lahir',
            'criteria_type_id' => $this->criteriaTypeId('Teks'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => true,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Tanggal Lahir',
            'criteria_type_id' => $this->criteriaTypeId('Tanggal'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => true,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Jenis Kelamin',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan Ganda (Radio)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => true,
            'active' => true,
        ], [
            'Laki-laki',
            'Perempuan',
        ]);

        Criteria::criteriaCreate([
            'name' => 'Agama',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan Ganda (Dropdown)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ], [
            'Islam',
            'Kristen Protestan',
            'Kristen Katolik',
            'Hindu',
            'Buddha',
            'Konghucu',
        ]);

        Criteria::criteriaCreate([
            'name' => 'Alamat Tinggal Saat Ini',
            'criteria_type_id' => $this->criteriaTypeId('Teks Panjang'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Alamat Lengkap Sesuai KTP',
            'criteria_type_id' => $this->criteriaTypeId('Teks Panjang'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Tinggi Badan (cm)',
            'criteria_type_id' => $this->criteriaTypeId('Angka'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Berat Badan (kg)',
            'criteria_type_id' => $this->criteriaTypeId('Angka'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);
        // ===========
        // Criteria::criteriaCreate([
        //     'name' => 'Asal Sekolah',
        //     'criteria_type_id' => $this->criteriaTypeId('Teks'),
        //     'parent_id' => null,
        //     'parent_order' => (Criteria::count() + 1),
        //     'child_order' => null,
        //     'max_length' => null,
        //     'min_length' => null,
        //     'max_number' => null,
        //     'min_number' => null,
        //     'max_size' => null,
        //     'format_file' => null,
        //     'custom_label' => null,
        //     'mask' => null,
        //     'required' => false,
        //     'active' => true,
        // ]);

        // Criteria::criteriaCreate([
        //     'name' => 'Jurusan',
        //     'criteria_type_id' => $this->criteriaTypeId('Teks'),
        //     'parent_id' => null,
        //     'parent_order' => (Criteria::count() + 1),
        //     'child_order' => null,
        //     'max_length' => null,
        //     'min_length' => null,
        //     'max_number' => null,
        //     'min_number' => null,
        //     'max_size' => null,
        //     'format_file' => null,
        //     'custom_label' => null,
        //     'mask' => null,
        //     'required' => false,
        //     'active' => true,
        // ]);

        // Criteria::criteriaCreate([
        //     'name' => 'Pendidikan Terakhir',
        //     'criteria_type_id' => $this->criteriaTypeId('Pilihan Ganda (Multiple/Dropdown)'),
        //     'parent_id' => null,
        //     'parent_order' => (Criteria::count() + 1),
        //     'child_order' => null,
        //     'max_length' => null,
        //     'min_length' => null,
        //     'max_number' => null,
        //     'min_number' => null,
        //     'max_size' => null,
        //     'format_file' => null,
        //     'custom_label' => null,
        //     'mask' => null,
        //     'required' => true,
        //     'active' => true,
        // ]);

        // Criteria::criteriaCreate([
        //     'name' => 'Tahun Lulus',
        //     'criteria_type_id' => $this->criteriaTypeId('Hanya Tahun'),
        //     'parent_id' => null,
        //     'parent_order' => (Criteria::count() + 1),
        //     'child_order' => null,
        //     'max_length' => null,
        //     'min_length' => null,
        //     'max_number' => null,
        //     'min_number' => null,
        //     'max_size' => null,
        //     'format_file' => null,
        //     'custom_label' => null,
        //     'mask' => null,
        //     'required' => false,
        //     'active' => true,
        // ]);

        Criteria::criteriaCreate([
            'name' => 'Nomor KTP',
            'criteria_type_id' => $this->criteriaTypeId('Angka'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => 16,
            'min_length' => 16,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Mempunyai BPJS Ketenagakerjaan',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan (Ya/Tidak)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Nomor BPJS Ketenagakerjaan',
            'criteria_type_id' => $this->criteriaTypeId('Angka'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => 11,
            'min_length' => 11,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Mempunyai BPJS Kesehatan',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan (Ya/Tidak)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Nomor BPJS Kesehatan',
            'criteria_type_id' => $this->criteriaTypeId('Angka'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => 13,
            'min_length' => 13,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Nomor NPWP',
            'criteria_type_id' => $this->criteriaTypeId('Teks Panjang'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => 16,
            'min_length' => 16,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Nomor SKCK',
            'criteria_type_id' => $this->criteriaTypeId('Teks Panjang'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => 16,
            'min_length' => 16,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Nomor SIO Forklift',
            'criteria_type_id' => $this->criteriaTypeId('Teks Panjang'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Status Perkawinan',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan Ganda (Radio)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ], [
            'Belum Menikah',
            'Menikah',
            'Cerai Hidup',
            'Cerai Mati',
        ]);

        Criteria::criteriaCreate([
            'name' => 'Tindik',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan (Ya/Tidak)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'Kacamata',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan (Ya/Tidak)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);

        Criteria::criteriaCreate([
            'name' => 'SIM yang Dimiliki',
            'criteria_type_id' => $this->criteriaTypeId('Pilihan (Multiple Checkbox)'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => null,
            'format_file' => null,
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ], [
            'SIM A',
            'SIM A Umum',
            'SIM B1',
            'SIM B1 Umum',
            'SIM B2',
            'SIM B2 Umum',
            'SIM C',
            'SIM D',
            'SIM E',
        ]);

        Criteria::criteriaCreate([
            'name' => 'Upload CV',
            'criteria_type_id' => $this->criteriaTypeId('Upload File'),
            'parent_id' => null,
            'parent_order' => (Criteria::count() + 1),
            'child_order' => null,
            'max_length' => null,
            'min_length' => null,
            'max_number' => null,
            'min_number' => null,
            'max_size' => 2,
            'format_file' => '.pdf',
            'custom_label' => null,
            'mask' => null,
            'required' => false,
            'active' => true,
        ]);
    }
}
