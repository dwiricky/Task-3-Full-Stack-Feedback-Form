<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Ulasan; // Import model Ulasan
use Illuminate\Support\Facades\Auth; // Import facade Auth

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ulasan = Ulasan::all();
        dd($ulasan);
        return view('page.produk.detail-produk', compact('ulasan')); // Ubah 'Ulasan' menjadi 'ulasan'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $barang_id)
{
    // Mengambil transaksi terbaru dari pengguna
    $transaksi = Transaksi::where('id_user', Auth::id())
                          ->latest()
                          ->first();

    // Verifikasi apakah ada transaksi yang ditemukan
    if ($transaksi) {
        // Validasi data yang dikirimkan
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        // Simpan ulasan ke dalam database
        Ulasan::create([
            'id_user' => Auth::id(),
            'id_barang' => $barang_id,
            'rate' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda telah ditambahkan.');
    } else {
        return redirect()->back()->with('error', 'Anda harus melakukan transaksi untuk dapat menambahkan ulasan.');
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    // Mengambil data produk berdasarkan ID
    $produk = Barang::findOrFail($id);
    
    // Pastikan hanya pengguna yang sudah melakukan transaksi yang dapat mengakses halaman ini
    if (!$produk->userHasPurchased()) {
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
    
    // Menghitung rating produk
    $rating = Ulasan::where('produk_id', $produk->id)->avg('rate');
    
    // Menyimpan rating ke dalam data produk
    $produk->rating = $rating;
    
    // Mengambil ulasan produk
    $ulasan = Ulasan::where('produk_id', $produk->id)->get();
    
    // Mengirim data produk dan ulasan ke halaman detail produk
    return view('detail_produk', compact('produk', 'ulasan'));
}

    protected function calculateAverageRating($barang_id)
    {
        // Menghitung rata-rata rating produk
        $averageRating = Ulasan::where('id_barang', $barang_id)->avg('rate');

        return $averageRating;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUlasanJson($id)
    {
        // Temukan produk berdasarkan ID
        $produk = Barang::findOrFail($id);

        // Ambil ulasan yang berelasi dengan produk
        // dan juga data user yang memberikan ulasan
        $ulasan = $produk->ulasan()->with('user')->latest()->get();

        // Kembalikan data dalam format JSON
        return response()->json($ulasan);
    }
}
