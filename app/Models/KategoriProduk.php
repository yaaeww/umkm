<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'slug', 'gambar', 'parent_id']; // Tambahkan parent_id

    /**
     * Relasi ke produk yang termasuk dalam kategori ini.
     */
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    /**
     * Relasi ke kategori induk (jika ini adalah sub-kategori).
     */
    // app/Models/KategoriProduk.php

    // Model: KategoriProduk.php
public function children()
{
    return $this->hasMany(KategoriProduk::class, 'parent_id');
}

public function parent()
{
    return $this->belongsTo(KategoriProduk::class, 'parent_id');
}


    /**
     * Cek apakah kategori ini memiliki sub-kategori.
     */
    public function hasChildren()
    {
        return $this->children()->exists();
    }
}
