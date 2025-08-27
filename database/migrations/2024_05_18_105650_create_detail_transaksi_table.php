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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('resi')->nullable();
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_barang');
            $table->integer('harga_barang');
            $table->integer('jumlah');
            $table->enum('status', ['pending' , 'diproses' , 'dikirim' , 'selesai' , 'dibatalkan'])->default('pending');
            $table->timestamps();
            $table->foreign('id_transaksi')->references('id')->on('transaksi')->onDelete('cascade');
            $table->foreign('id_barang')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
