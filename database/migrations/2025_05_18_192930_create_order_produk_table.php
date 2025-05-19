<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('order_produk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('orders_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('produks_id')->constrained('produks')->onDelete('cascade');
        $table->integer('quantity')->default(1); // misal ada qty
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('order_produk');
}

};
