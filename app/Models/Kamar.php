<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga_per_malam',
        'status',
        'status_kebersihan',
    ];

    protected $casts = [
        'harga_per_malam' => 'decimal:2',
    ];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'kamar_id');
    }

    public function pemesananAktif()
    {
        return $this->hasOne(Pemesanan::class, 'kamar_id')
            ->whereIn('status', ['Dipesan', 'Check-in'])
            ->latestOfMany();
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'Tersedia')->where('status_kebersihan', 'Bersih');
    }

    public function scopeKotor($query)
    {
        return $query->where('status_kebersihan', 'Kotor');
    }
}
