<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PendapatanSummaryExport;
use App\Exports\DetailPendapatanExport;

class PendapatanController extends Controller
{
    // Ganti perProduk jadi index supaya cocok dengan routing
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'bulan');

        $query = DB::table('orders')
            ->join('produks', 'orders.produk_id', '=', 'produks.id')
            ->where('produks.user_id', $user->id)
            ->where('orders.status', 'complete')
            ->select(
                'produks.id',
                'produks.nama',
                DB::raw('SUM(orders.jumlah) as total_terjual'),
                DB::raw('SUM(orders.total_harga) as total_pendapatan')
            );

        if ($filter === 'minggu') {
            $query->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('orders.created_at', Carbon::now()->month)
                ->whereYear('orders.created_at', Carbon::now()->year);
        } elseif ($filter === 'tahun') {
            $query->whereYear('orders.created_at', Carbon::now()->year);
        }

        $pendapatanPerProduk = $query->groupBy('produks.id', 'produks.nama')->get();

        return view('penjual.pendapatan-per-produk', compact('pendapatanPerProduk', 'filter'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $produk = Produk::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $detail = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.produk_id', $id)
            ->where('orders.status', 'complete')
            ->select('orders.id', 'orders.jumlah', 'orders.total_harga', 'orders.created_at', 'users.name as nama_pemesan')
            ->orderByDesc('orders.created_at')
            ->get();

        return view('penjual.pendapatan-detail', compact('produk', 'detail'));
    }

    public function exportSummaryExcel(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'bulan');

        $query = DB::table('orders')
            ->join('produks', 'orders.produk_id', '=', 'produks.id')
            ->where('produks.user_id', $user->id)
            ->where('orders.status', 'complete')
            ->select(
                'produks.id',
                'produks.nama',
                DB::raw('SUM(orders.jumlah) as total_terjual'),
                DB::raw('SUM(orders.total_harga) as total_pendapatan')
            );

        if ($filter === 'minggu') {
            $query->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('orders.created_at', Carbon::now()->month)
                ->whereYear('orders.created_at', Carbon::now()->year);
        } elseif ($filter === 'tahun') {
            $query->whereYear('orders.created_at', Carbon::now()->year);
        }

        $pendapatanPerProduk = $query->groupBy('produks.id', 'produks.nama')->get();

        return Excel::download(new PendapatanSummaryExport($pendapatanPerProduk), 'pendapatan_summary.xlsx');
    }

    public function exportDetailExcel($id)
    {
        $user = Auth::user();
        $produk = Produk::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $detail = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.produk_id', $id)
            ->where('orders.status', 'complete')
            ->select('orders.id', 'orders.jumlah', 'orders.total_harga', 'orders.created_at', 'users.name as nama_pemesan')
            ->orderByDesc('orders.created_at')
            ->get();

        return Excel::download(new DetailPendapatanExport($produk, $detail), 'detail_pendapatan_produk_' . $id . '.xlsx');
    }

    public function exportSummaryPdf(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'bulan');

        $query = DB::table('orders')
            ->join('produks', 'orders.produk_id', '=', 'produks.id')
            ->where('produks.user_id', $user->id)
            ->where('orders.status', 'complete')
            ->select(
                'produks.id',
                'produks.nama',
                DB::raw('SUM(orders.jumlah) as total_terjual'),
                DB::raw('SUM(orders.total_harga) as total_pendapatan')
            );

        if ($filter === 'minggu') {
            $query->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('orders.created_at', Carbon::now()->month)
                ->whereYear('orders.created_at', Carbon::now()->year);
        } elseif ($filter === 'tahun') {
            $query->whereYear('orders.created_at', Carbon::now()->year);
        }

        $pendapatanPerProduk = $query->groupBy('produks.id', 'produks.nama')->get();

        $pdf = Pdf::loadView('penjual.exports.pendapatan-summary-pdf', compact('pendapatanPerProduk'));
        return $pdf->download('pendapatan_summary.pdf');
    }

    public function exportDetailPdf($id)
    {
        $user = Auth::user();
        $produk = Produk::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $detail = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.produk_id', $id)
            ->where('orders.status', 'complete')
            ->select('orders.id', 'orders.jumlah', 'orders.total_harga', 'orders.created_at', 'users.name as nama_pemesan')
            ->orderByDesc('orders.created_at')
            ->get();

        $pdf = Pdf::loadView('penjual.exports.pendapatan-detail-pdf', compact('produk', 'detail'));
        return $pdf->download('pendapatan_detail_produk_' . $produk->nama . '.pdf');
    }
}
