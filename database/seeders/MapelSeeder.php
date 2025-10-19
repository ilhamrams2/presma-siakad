<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua guru dari users
        $guruIds = User::where('role', 'guru')->pluck('id')->toArray();

        if (empty($guruIds)) {
            $this->command->info('Seeder gagal: belum ada guru di tabel users!');
            return;
        }

        // Contoh daftar mapel
        $mapels = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Pendidikan Agama',
            'PKN',
            'Seni Budaya',
            'Penjaskes',
        ];

        foreach ($mapels as $namaMapel) {
            Mapel::create([
                'nama_mapel' => $namaMapel,
                'guru_id' => $faker->randomElement($guruIds),
            ]);
        }
    }
}
