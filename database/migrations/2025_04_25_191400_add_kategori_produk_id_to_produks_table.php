<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriProdukIdToProduksTable extends Migration
{
    public function up()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->foreignId('kategori_produk_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropForeign(['kategori_produk_id']);
            $table->dropColumn('kategori_produk_id');
        });
    }
};
