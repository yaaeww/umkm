<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'slug', 'gambar'];  // Menambahkan gambar ke dalam $fillable

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
