<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua kelas dan jurusan
        $kelasIds = Kelas::pluck('id')->toArray();
        $jurusanIds = Jurusan::pluck('id')->toArray();

        if (empty($kelasIds) || empty($jurusanIds)) {
            $this->command->info('Seeder gagal: pastikan tabel kelas dan jurusan sudah ada isinya!');
            return;
        }

        for ($i = 1; $i <= 50; $i++) { // langsung 50 siswa
            $namaSiswa = $faker->name;
            $slugNama = Str::slug($namaSiswa, '.');
            $emailSiswa = strtolower($slugNama) . '@smkprestasiprima.sch.id';

            // Buat akun user untuk siswa
            $user = User::create([
                'name' => $namaSiswa,
                'username' => $slugNama,
                'email' => $emailSiswa,
                'password' => bcrypt('password123'), // password default
                'role' => 'siswa',
            ]);

            // Buat data siswa
            Siswa::create([
                'user_id' => $user->id,
                'nis' => '2025' . str_pad($i, 4, '0', STR_PAD_LEFT), // NIS unik 20250001 dst
                'kelas_id' => $faker->randomElement($kelasIds),
                'jurusan_id' => $faker->randomElement($jurusanIds),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
            ]);
        }
    }
}
