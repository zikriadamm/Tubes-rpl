<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran',
        'aktif',
        'no_hp',
        'no_identitas',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pemesanansSebagaiTamu()
    {
        return $this->hasMany(Pemesanan::class, 'tamu_id');
    }

    public function pemesanansSebagaiPembuat()
    {
        return $this->hasMany(Pemesanan::class, 'pembuat_id');
    }

    public function pembayaransDiterima()
    {
        return $this->hasMany(Pembayaran::class, 'penerima_id');
    }

    public function isManajer(): bool
    {
        return $this->peran === 'Manajer';
    }

    public function isResepsionis(): bool
    {
        return $this->peran === 'Resepsionis';
    }

    public function isPetugasKebersihan(): bool
    {
        return $this->peran === 'Petugas Kebersihan';
    }
}
