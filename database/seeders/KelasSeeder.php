<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasLevels = [10, 11, 12];   // Tingkatan kelas
        $kelasNumber = [1, 2];         // Nomor kelas

        // Ambil semua jurusan
        $jurusans = Jurusan::all();

        foreach ($kelasLevels as $level) {
            foreach ($jurusans as $jurusan) {
                for ($num = 1; $num <= 2; $num++) {
                    Kelas::create([
                        'nama_kelas' => "$level {$jurusan->kode_jurusan} $num",
                        'jurusan_id' => $jurusan->id,
                        'wali_kelas_id' => null, // bisa diassign nanti
                    ]);
                }
            }
        }
    }
}
