<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    public function indexApi()
    {
        try {
            $kategoris = KategoriProduk::with(['subkategoris', 'produks' => function($query) {
                $query->with('diskon')
                      ->where('stok', '>', 0)
                      ->take(3);
            }])
            ->whereNull('parent_id')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $kategoris
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showApi($id)
    {
        try {
            $kategori = KategoriProduk::with(['subkategoris', 'produks' => function($query) {
                $query->with('diskon')
                      ->where('stok', '>', 0);
            }])->find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $kategori
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function produksByKategori($id)
    {
        try {
            $kategori = KategoriProduk::find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak ditemukan'
                ], 404);
            }

            // Get all produk in this category and subcategories
            $produks = $kategori->produks()
                ->with('diskon')
                ->where('stok', '>', 0)
                ->get();

            // If category has subcategories, get their products too
            if ($kategori->subkategoris->count() > 0) {
                foreach ($kategori->subkategoris as $subkategori) {
                    $subProduks = $subkategori->produks()
                        ->with('diskon')
                        ->where('stok', '>', 0)
                        ->get();
                    $produks = $produks->merge($subProduks);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $produks
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}