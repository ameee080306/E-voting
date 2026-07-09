<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nim',
        'nama',
        'foto',
        'email',
        'password',
        'role',
        'status_memilih',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // Cast 'hashed' memastikan password di-hash dengan BCrypt secara otomatis
            // setiap kali atribut password di-set langsung via model assignment.
            // Ini adalah mekanisme hashing satu arah (irreversible) — BUKAN enkripsi Blowfish.
            // Blowfish hanya digunakan untuk mengenkripsi data suara di tabel votings.
            'password'          => 'hashed',
        ];
    }
}
