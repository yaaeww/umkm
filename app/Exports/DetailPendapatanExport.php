<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailPendapatanExport implements FromView
{
    public $produk, $detail;

    public function __construct($produk, $detail)
    {
        $this->produk = $produk;
        $this->detail = $detail;
    }

    public function view(): View
    {
        return view('penjual.pendapatan.export_excel_detail', [
            'produk' => $this->produk,
            'detail' => $this->detail
        ]);
    }
}
