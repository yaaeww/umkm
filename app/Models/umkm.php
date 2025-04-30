<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'status',
        'nama_toko',
        'deskripsi',
        'alamat',
        'no_telp',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produks()
{
    return $this->hasMany(Produk::class);
}

}
