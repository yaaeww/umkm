<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function indexApi()
    {
        try {
            $umkms = Umkm::with(['user', 'produks' => function($query) {
                $query->with('diskon')
                      ->where('stok', '>', 0)
                      ->take(6);
            }])
            ->where('status', 'approved')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $umkms
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data UMKM',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showApi($id)
    {
        try {
            $umkm = Umkm::with([
                'user', 
                'produks' => function($query) {
                    $query->with(['diskon', 'kategori'])
                          ->where('stok', '>', 0);
                }
            ])
            ->where('status', 'approved')
            ->find($id);

            if (!$umkm) {
                return response()->json([
                    'success' => false,
                    'message' => 'UMKM tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $umkm
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data UMKM',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}