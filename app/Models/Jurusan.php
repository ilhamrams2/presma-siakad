<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusans';
    protected $guarded = ['id'];
    // protected $fillable = ['nama_jurusan', 'keterangan'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
