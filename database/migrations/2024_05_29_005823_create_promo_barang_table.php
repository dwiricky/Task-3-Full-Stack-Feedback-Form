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
        Schema::create('promo_barang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_promo');
            $table->enum('diarsipkan', ['false', 'true'])->default('false');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_barang');
    }
};
