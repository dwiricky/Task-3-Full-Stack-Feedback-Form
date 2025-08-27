<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    use HasFactory;


    protected $table = 'ulasan';

    protected $guarded = ['id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}