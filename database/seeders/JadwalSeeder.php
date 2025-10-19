<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\JadwalPelajaran;
use App\Models\User;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua data kelas, mapel, dan guru
        $kelasIds = Kelas::pluck('id')->toArray();
        $mapelIds = Mapel::pluck('id')->toArray();
        $guruIds  = User::where('role', 'guru')->pluck('id')->toArray();

        $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        foreach ($kelasIds as $kelasId) {
            // Misal tiap kelas punya 4-6 jam pelajaran per hari
            foreach ($hariOptions as $hari) {
                $jumlahJam = rand(4, 6);
                $jamMulai = 7; // Mulai jam 7 pagi

                for ($i = 0; $i < $jumlahJam; $i++) {
                    $mapelId = $faker->randomElement($mapelIds);
                    $guruId  = Mapel::find($mapelId)->guru_id; // guru mapel tersebut

                    JadwalPelajaran::create([
                        'kelas_id'   => $kelasId,
                        'mapel_id'   => $mapelId,
                        'guru_id'    => $guruId,
                        'hari'       => $hari,
                        'jam_mulai'  => sprintf('%02d:00:00', $jamMulai),
                        'jam_selesai'=> sprintf('%02d:00:00', $jamMulai + 1),
                    ]);

                    $jamMulai++;
                }
            }
        }
    }
}
