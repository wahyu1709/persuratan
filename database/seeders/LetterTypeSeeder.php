<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $divisiKemahasiswaan = \App\Models\Division::firstOrCreate(['name' => 'Kemahasiswaan'], ['code' => 'KEM']);

        \App\Models\LetterType::insert([
            [
                'name' => 'Surat Keterangan Aktif Mahasiswa',
                'code' => 'aktif_kuliah',
                'required_fields' => json_encode(['semester', 'tujuan_surat']),
                'division_id' => $divisiKemahasiswaan->id,
                'active' => true,
            ],
            [
                'name' => 'Surat Pengantar Magang',
                'code' => 'pengantar_magang',
                'required_fields' => json_encode(['instansi', 'periode', 'lama_magang']),
                'division_id' => $divisiKemahasiswaan->id,
                'active' => true,
            ],
            [
                'name' => 'Surat Keterangan Bebas Tanggungan',
                'code' => 'bebas_tanggungan',
                'required_fields' => json_encode(['alasan']),
                'division_id' => $divisiKemahasiswaan->id,
                'active' => true,
            ],
            [
                'name' => 'Surat Rekomendasi',
                'code' => 'rekomendasi',
                'required_fields' => json_encode(['tujuan', 'jangka_waktu']),
                'division_id' => $divisiKemahasiswaan->id,
                'active' => true,
            ],
        ]);
    }
}
