<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role_id',
        'nama',
        'username',
        'email',
        'password',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel otomatis menggunakan bcrypt
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper function untuk cek role
    public function hasRole(String $roleName)
    {
        return $this->role->name === $roleName;
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
                    ->withPivot('joined_at');
    }
    
}