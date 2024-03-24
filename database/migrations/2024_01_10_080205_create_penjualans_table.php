<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('penjualans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->date('tanggal');
        $table->string('status');
        $table->integer('kode');
        $table->integer('jumlah_harga');
        
        $table->foreign('user_id')->references('id')->on('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};
