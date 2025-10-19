<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'email',
        'telepon',
        'alamat',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'guru_id');
    }

    public function kelasWali()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }
    protected static function booted()
    {
        static::creating(function ($guru) {
            // Cek kalau belum ada user terkait
            if (!$guru->user_id) {
                $user = \App\Models\User::create([
                    'name' => $guru->nama,
                    'email' => $guru->email ?? strtolower(str_replace(' ', '', $guru->nama)) . '@smkprestasiprima.smkprestasiprima.sch.id',
                    'password' => bcrypt('password123'), // default password
                    'role' => 'guru',
                ]);

                $guru->user_id = $user->id;
            }
        });
    }
}
