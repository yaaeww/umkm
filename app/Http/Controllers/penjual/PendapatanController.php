<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\UMKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\PendapatanSummaryExport;
use App\Exports\PendapatanDetailExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;


class PendapatanController extends Controller
{
    // Menampilkan rekap pendapatan berdasarkan filter waktu
    public function index(Request $request)
    {
        $user = Auth::user();
        $umkm = UMKM::where('user_id', $user->id)->first();
        $pendapatanPerProduk = collect();
        $filter = $request->input('filter', 'bulan'); // default: bulanan
        $totalPendapatanBulanLalu = 0;

        if ($umkm) {
            $query = DB::table('orders')
                ->join('produks', 'orders.produk_id', '=', 'produks.id')
                ->where('produks.umkm_id', $umkm->id)
                ->where('orders.status', 'complete')
                ->select(
                    'produks.id',
                    'produks.nama as nama_produk',
                    DB::raw('SUM(orders.jumlah) as total_terjual'),
                    DB::raw('SUM(orders.total_harga) as total_pendapatan')
                );

            // Filter waktu: minggu, bulan, atau tahun
            if ($filter === 'minggu') {
                $query->whereBetween('orders.created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            } elseif ($filter === 'bulan') {
                $query->whereMonth('orders.created_at', Carbon::now()->month)
                    ->whereYear('orders.created_at', Carbon::now()->year);
            } elseif ($filter === 'tahun') {
                $query->whereYear('orders.created_at', Carbon::now()->year);
            }

            $pendapatanPerProduk = $query
                ->groupBy('produks.id', 'produks.nama')
                ->get();

            // Hitung total pendapatan bulan lalu
            $startLastMonth = Carbon::now()->subMonthNoOverflow()->startOfMonth();
            $endLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth();

            $totalPendapatanBulanLalu = DB::table('orders')
                ->join('produks', 'orders.produk_id', '=', 'produks.id')
                ->where('produks.umkm_id', $umkm->id)
                ->where('orders.status', 'complete')
                ->whereBetween('orders.created_at', [$startLastMonth, $endLastMonth])
                ->sum('orders.total_harga');
        }

        return view('penjual.pendapatan-per-produk', compact(
            'pendapatanPerProduk',
            'filter',
            'totalPendapatanBulanLalu'
        ));
    }

    // Menampilkan detail pendapatan per produk
    public function show($id)
    {
        $user = Auth::user();
        $umkm = UMKM::where('user_id', $user->id)->first();

        // Pastikan produk milik UMKM penjual
        $produk = DB::table('produks')
            ->where('id', $id)
            ->where('umkm_id', $umkm->id)
            ->first();

        if (!$produk) {
            abort(404);
        }

        // Ambil data order untuk produk ini
        $detail = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.produk_id', $id)
            ->where('orders.status', 'complete')
            ->select(
                'orders.id',
                'orders.jumlah',
                'orders.total_harga',
                'orders.created_at',
                'users.name as nama_pemesan'
            )
            ->orderBy('orders.created_at', 'desc')
            ->get();


        return view('penjual.pendapatan-detail', compact('produk', 'detail'));
    }

    public function exportSummaryExcel(Request $request)
{
    $user = Auth::user();
    $umkm = UMKM::where('user_id', $user->id)->first();

    if (!$umkm) abort(404);

    $pendapatanPerProduk = $this->getPendapatanQuery($umkm, $request)->get();

    return Excel::download(new PendapatanSummaryExport($pendapatanPerProduk), 'pendapatan_summary.xlsx');
}

public function exportDetailExcel($id)
{
    $user = Auth::user();
    $umkm = UMKM::where('user_id', $user->id)->first();

    if (!$umkm) abort(404);

    $detail = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.produk_id', $id)
        ->where('orders.status', 'complete')
        ->select('orders.id', 'orders.jumlah', 'orders.total_harga', 'orders.created_at', 'users.name as nama_pemesan')
        ->orderBy('orders.created_at', 'desc')
        ->get();

    return Excel::download(new PendapatanDetailExport($detail), 'pendapatan_detail_produk_'.$id.'.xlsx');
}

public function exportSummaryPdf(Request $request)
{
    $user = Auth::user();
    $umkm = UMKM::where('user_id', $user->id)->first();

    if (!$umkm) abort(404);

    $pendapatanPerProduk = $this->getPendapatanQuery($umkm, $request)->get();

    $pdf = Pdf::loadView('penjual.exports.pendapatan-summary-pdf', compact('pendapatanPerProduk'));
    return $pdf->download('pendapatan_summary.pdf');
}

public function exportDetailPdf($id)
{
    $user = Auth::user();
    $umkm = UMKM::where('user_id', $user->id)->first();

    if (!$umkm) abort(404);

    $detail = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.produk_id', $id)
        ->where('orders.status', 'complete')
        ->select('orders.id', 'orders.jumlah', 'orders.total_harga', 'orders.created_at', 'users.name as nama_pemesan')
        ->orderBy('orders.created_at', 'desc')
        ->get();

    $pdf = PDF::loadView('penjual.exports.pendapatan-detail-pdf', compact('detail'));
    return $pdf->download('pendapatan_detail_produk_'.$id.'.pdf');
}

// Refactor query agar bisa dipakai ulang
private function getPendapatanQuery($umkm, $request)
{
    $filter = $request->input('filter', 'bulan');

    $query = DB::table('orders')
        ->join('produks', 'orders.produk_id', '=', 'produks.id')
        ->where('produks.umkm_id', $umkm->id)
        ->where('orders.status', 'complete')
        ->select(
            'produks.id',
            'produks.nama as nama_produk',
            DB::raw('SUM(orders.jumlah) as total_terjual'),
            DB::raw('SUM(orders.total_harga) as total_pendapatan')
        );

    if ($filter === 'minggu') {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $query->whereBetween('orders.created_at', [$startOfWeek, $endOfWeek]);
    } elseif ($filter === 'bulan') {
        $query->whereMonth('orders.created_at', Carbon::now()->month)
            ->whereYear('orders.created_at', Carbon::now()->year);
    } elseif ($filter === 'tahun') {
        $query->whereYear('orders.created_at', Carbon::now()->year);
    }

    return $query->groupBy('produks.id', 'produks.nama');
}
}
