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

        for ($i = 1; $i <= 10; $i++) {
            $nama = $faker->name;
            $slugNama = Str::slug($nama, '.');
            $email = strtolower($slugNama) . '@smkprestasiprima.sch.id';

            // Buat user dulu
            $user = User::create([
                'name' => $nama,
                'username' => $slugNama,
                'email' => $email,
                'password' => bcrypt('password123'),
                'role' => 'siswa',
            ]);

            // Buat siswa dan hubungkan ke user, kelas, jurusan
            Siswa::create([
                'user_id' => $user->id,
                'nis' => '2025' . rand(1000, 9999) . $i, // generate NIS unik
                'kelas_id' => $faker->randomElement($kelasIds),
                'jurusan_id' => $faker->randomElement($jurusanIds),
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
            ]);
        }
    }
}
