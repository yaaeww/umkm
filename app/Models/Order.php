<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'produk_id',
        'name',
        'alamat',
        'phone',
        'jumlah',
        'total_harga',
        'status',
        'status_pesanan',
        'order_id_midtrans'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produks()
    {
        return $this->belongsToMany(
            Produk::class,
            'order_produk',  // nama tabel pivot
            'orders_id',     // foreign key order di pivot
            'produks_id'     // foreign key produk di pivot
        );
    }
    public function produk()
    {
        // Jika tiap order punya satu produk:
        return $this->belongsTo(Produk::class, 'produk_id');

        // Jika order bisa punya banyak produk melalui pivot atau detail pesanan, sesuaikan:
        // return $this->belongsToMany(Produk::class, 'order_details', 'order_id', 'produk_id');
    }
}
