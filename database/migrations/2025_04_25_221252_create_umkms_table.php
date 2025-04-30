<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmkmsTable extends Migration
{
    public function up()
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // pemilik toko (penjual)
            $table->string('nama_toko');
            $table->text('deskripsi')->nullable();
            $table->string('alamat');
            $table->string('no_telp')->nullable();
            $table->string('logo')->nullable(); // opsional untuk menyimpan logo toko
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('umkms');
    }
}
