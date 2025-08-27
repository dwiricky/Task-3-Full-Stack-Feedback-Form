<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kategori');
            $table->string('gambar');
            $table->string('nama');
            $table->string('deskripsi');
            $table->integer('harga');
            $table->timestamps();
            $table->enum('diarsipkan', ['false','true'])->default('false');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
