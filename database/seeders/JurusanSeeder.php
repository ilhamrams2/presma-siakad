<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $jurusans = [
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak', 'kode_jurusan' => 'PPLG', 'keterangan' => 'Jurusan RPL'],
            ['nama_jurusan' => 'Broadcasting', 'kode_jurusan' => 'BCF', 'keterangan' => 'Jurusan BCF'],
            ['nama_jurusan' => 'Teknik Komputer dan Jaringan', 'kode_jurusan' => 'TJKT', 'keterangan' => 'Jurusan TJKT'],
            ['nama_jurusan' => 'Desain Komunikasi Visual', 'kode_jurusan' => 'DKV', 'keterangan' => 'Jurusan DKV'],
        ];

        foreach ($jurusans as $j) {
            Jurusan::create($j);
        }
    }
}
