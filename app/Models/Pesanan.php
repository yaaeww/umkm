<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'kode_pesanan', 'total_harga', 'metode_pembayaran', 
        'status', 'alamat_pengiriman', 'latitude', 'longitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function pesananDetails()
{
    return $this->hasMany(PesananDetail::class);
}

}
