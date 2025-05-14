<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'produk_id', 'name', 'alamat', 'phone', 'jumlah', 'total_harga', 'status', 'status_pesanan', 'order_id_midtrans'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
