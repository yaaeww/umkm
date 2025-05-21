<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons';

    protected $fillable = [
        'produks_id',
        'persen_diskon',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');
    }

    // Cek apakah diskon sedang aktif
    public function isActive()
    {
        $today = now()->format('Y-m-d');
        return ($today >= $this->tanggal_mulai && $today <= $this->tanggal_berakhir);
    }
}
