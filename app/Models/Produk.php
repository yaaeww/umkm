<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
        'gambar', 
        'user_id',
        'stok', // tambahkan jika ada field stok
        'rating',
        'umkm_id',
        'kategori_produk_id'
    ];
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
    
    /**
     * Relasi ke model User (Penjual)
     */
    public function penjual()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // App\Models\Produk
public function user()
{
    return $this->belongsTo(User::class);
}

// app/Models/Produk.php

public function kategori()
{
    return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
}

    /**
     * Relasi ke Kategori (jika ada)
     */
    
    /**
     * Method untuk admin dashboard
     */
    public function adminIndex()
    {
        $produks = Produk::with(['penjual', 'kategori'])
                        ->latest()
                        ->get();
        
        return view('admin.dashboard', compact('produks'));
    }

    /**
     * Accessor untuk format harga
     */
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Scope untuk produk aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
    
}