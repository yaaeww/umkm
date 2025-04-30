<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'pesanan_id', 'metode', 'status', 'midtrans_order_id', 
        'midtrans_transaction_id', 'midtrans_payment_type', 'amount'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
