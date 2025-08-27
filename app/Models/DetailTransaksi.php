<?php

// app/Models/DetailTransaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi'; // Nama tabel dalam database

    protected $fillable = [
        'resi',
        'id_transaksi',
        'id_barang',
        'status',
        'harga_barang',
        'jumlah'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
