<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityToKeranjangsTable extends Migration
{
    public function up()
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->integer('quantity')->default(1);
        });
    }

    public function down()
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
}
