<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $guruRole = Role::create(['name' => 'guru']);
        $siswaRole = Role::create(['name' => 'siswa']);
        
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@smkprestasiprima.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole($adminRole);

        // Guru
        $guru = User::create([
            'name' => 'Guru Contoh',
            'username' => 'guru1',
            'email' => 'guru@smkprestasiprima.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);
        $guru->assignRole($guruRole);

        // Siswa
        $siswa = User::create([
            'name' => 'Siswa Contoh',
            'username' => 'siswa1',
            'email' => 'siswa@smkprestasiprima.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
        $siswa->assignRole($siswaRole);
    }
}
