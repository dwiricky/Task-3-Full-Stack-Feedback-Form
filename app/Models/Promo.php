<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    protected $table = "promo";
    protected $fillable = [
        'nama',
        'deskripsi',
        'pengurangan_harga'
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id');
    }

    public function promoBarang()
    {
        return $this->belongsToMany(Barang::class, 'promo_barang', 'id_promo', 'id_barang')
            ->withTimestamps();
    }
}
