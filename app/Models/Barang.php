<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Barang extends Model
{
    use HasFactory;

    protected $table = "barang";

    protected $guarded = ['id'];

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_barang');
    }
    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'id_barang', 'id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    public function promo(): BelongsToMany
    {
        return $this->belongsToMany(Promo::class, 'promo_barang', 'id_barang', 'id_promo')
            ->withTimestamps();
    }

    /**
     * Memeriksa apakah pengguna yang sedang login pernah membeli barang ini.
     * @return bool
     */
    public function userHasPurchased(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Transaksi::where('id_user', Auth::id())
                        ->where('status_transaksi', 'selesai')
                        ->whereHas('detailTransaksi', function ($query) {
                            $query->where('id_barang', $this->id);
                        })
                        ->exists();
    }
}