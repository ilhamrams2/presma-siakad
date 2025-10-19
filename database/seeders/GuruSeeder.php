<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Guru;
use App\Models\User;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 10; $i++) {
            $nama = $faker->name;
            $slugNama = Str::slug($nama, '.');
            $email = strtolower($slugNama) . '@smkprestasiprima.sch.id';

            // Buat user dulu
            $user = User::create([
                'name' => $nama,
                'username' => Str::slug($nama, '.'), // tambahkan baris ini
                'email' => $email,
                'password' => bcrypt('password123'),
                'role' => 'guru',
            ]);


            // Buat guru dan hubungkan ke user
            Guru::create([
                'user_id' => $user->id,
                'nip' => '1980' . rand(1000, 9999) . $i,
                'nama' => $nama,
                'gelar' => $faker->randomElement(['S.Pd', 'M.Pd', 'S.Kom.', 'M.Kom.', 'Ir.']),
                'email' => $email,
                'telepon' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
            ]);
        }
    }
}
