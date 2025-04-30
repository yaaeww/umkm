<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'produk_id', 'jumlah'];

    // app/Models/Keranjang.php
public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
