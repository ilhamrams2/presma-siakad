<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nis', 'kelas_id', 'jurusan_id', 'alamat', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
    protected static function booted()
{
    static::creating(function ($siswa) {
        // Cek kalau belum ada user terkait
        if (!$siswa->user_id) {
            $email = $siswa->email ?? strtolower(str_replace(' ', '', $siswa->nama)) . '@smkprestasiprima.sch.id';

            // Buat user baru
            $user = \App\Models\User::create([
                'name' => $siswa->nama,
                'email' => $email,
                'password' => bcrypt('password123'), // password default
                'role' => 'siswa',
            ]);

            // Set user_id di siswa
            $siswa->user_id = $user->id;
        }
    });
}
}
