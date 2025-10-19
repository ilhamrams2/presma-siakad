<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'guru_id');
    }
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }
    // protected static function booted()
    // {
    //     static::created(function ($user) {
    //         if ($user->role === 'guru') {
    //             $user->guru()->create([
    //                 'nama' => $user->name,
    //                 'email' => $user->email,
    //             ]);
    //         }
    //     });
    // }
}
