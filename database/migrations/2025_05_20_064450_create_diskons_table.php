<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produks_id');
            $table->integer('persen_diskon');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->timestamps();

            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
