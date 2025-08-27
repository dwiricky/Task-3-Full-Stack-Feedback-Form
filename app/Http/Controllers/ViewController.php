<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Promo;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;

class ViewController extends Controller
{
    //dd(date('Y-m-d H:i:s', $tglDimasukkan));
    public function index(int $limit = 4)
    {
        // Nampilin Barang Yang Sedang Ada Promo Secara Random di Landing
        $promoItems = Promo::whereHas('promoBarang')
            ->with(['promoBarang' => function ($query) {
                $query->inRandomOrder();
            }])
            ->limit($limit)
            ->where('diarsipkan', 'false')->get();
        // limiter display
        // $barang = Barang::all()->take(1);
        $barang = Barang::limit(10)->where('diarsipkan', 'false')->get();
        $kategori = Kategori::where('diarsipkan', 'false')->get();
        $kategoris = Kategori::with('barang')->where('diarsipkan', 'false')->get();
        return view('welcome', compact('barang', 'promoItems', 'kategori', 'kategoris'));
    }

    public function promo()
    {
        $promo = Promo::where('diarsipkan', 'false')->get();
        return view('page.promo.list-promo', compact('promo'));
    }
    public function detailPromo(String $id)
    {
        $promo = Promo::with('promoBarang')->where('diarsipkan', 'false')->findOrFail($id);
        return view('page.promo.detail-promo', compact('promo'));
    }

    public function detailProduk(String $id)
    {
        $produk = Barang::where('diarsipkan', 'false')->findOrFail($id);
        $ulasan = Ulasan::where('diarsipkan', 'false')->get();
        $rating = Ulasan::where('id_barang', $produk->id)->avg('rate');
        return view('page.produk.detail-produk', compact(['produk', 'ulasan', 'rating']));
    }
    public function faq()
    {
        return view('page.faq.faq');
    }
    public function aboutUs()
    {
        return view('page.about.about-us');
    }
    public function dataPribadi()
    {
        return view('page.data.data-pribadi');
    }

    public function listProduk(Request $request)
    {
        $kategori = Kategori::where('diarsipkan', 'false')->get();

        $categories = array();

        foreach ($kategori as $key) {
            $categories[] = $key;
        }

        // dd($categories);

        // $categories = [
        //     1 => 'Ruang Tamu',
        //     2 => 'Kamar Mandi',
        //     3 => 'Kamar Tidur'
        // ];

        $selectedCategory = $request->get('category', 1);
        $search = $request->get('search', '');

        $products = Barang::where('id_kategori', $selectedCategory)
            ->where('nama', 'like', "%$search%")
            ->where('diarsipkan', 'false')
            ->paginate(10);

        return view('page.produk.list-produk', compact('categories', 'selectedCategory', 'products', 'search'));
    }
    public function __construct()
    {
        $this->middleware('auth')->only(['addToCart', 'checkout']);
    }


    public function cart()
    {

        $cart = session()->get('cart', []);

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['harga'] * $details['quantity'];
        }

        $pajak = $total * 0.1;

        $totalPajak = $total + $pajak;

        return view('page.order.cart', [
            'cart' => $cart,
            'total' => $total,
            'totalPajak' => $totalPajak
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $barang = Barang::where('diarsipkan', 'false')->findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($barang->id) && $barang->stock->stock >= 1) {
            $promotions = Promo::where('diarsipkan', "false")->get();
            foreach ($promotions as $promotion) {
                if ($promotion->promoBarang->contains($barang)) {
                    $barang->harga -= $promotion->pengurangan_harga;
                }
            }
            $stock = Stock::where('id_barang', $barang->id)->first();

            if ($stock->stock > 0) {
                $stock_update = $stock->stock - 1;
                if ($stock_update == 0) {
                    $stock->update([
                        'stock' => $stock_update,
                        'status' => 'Habis',
                    ]);
                } else {
                    $stock->update([
                        'stock' => $stock_update,
                    ]);
                }
            } else if ($stock->stock == 0) {
                return redirect()->back()->with('error', 'Product Habis');
            }
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "nama" => $barang->nama,
                    "id_barang" => $barang->id,
                    "quantity" => 1,
                    "harga" => $barang->harga, // Use discounted price if applicable
                    "gambar" => $barang->gambar,
                    "last_updated" => Carbon::now(),
                ];
            }

            session()->put('cart', $cart);
            return redirect()->route('cart')->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->back()->with('error', 'Product not found or invalid!');
        }
    }


    /**

     *
     * @return response()
     */
    public function update(Request $request)
    {
        if ($request->id && $request->quantity !== null) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                $barang = Barang::findOrFail($request->id);
                $stock = Stock::where('id_barang', $barang->id)->first();

                $previousQuantity = $cart[$request->id]["quantity"];
                $cart[$request->id]["quantity"] = $request->quantity;

                // Update stock by the difference between new and old quantities
                $stock->update([
                    'stock' => $stock->stock - ($request->quantity - $previousQuantity),
                ]);
                
                if ($stock->stock <= 0) {
                    $stock->update([
                        'status' => 'Habis',
                    ]);
                }

                session()->put('cart', $cart);

                $subtotal = $cart[$request->id]["quantity"] * $cart[$request->id]["harga"];
                $total = array_reduce($cart, function ($sum, $item) {
                    return $sum + ($item["harga"] * $item["quantity"]);
                }, 0);

                $totalPajak = $total + ($total * 0.1);

                return response()->json([
                    'subtotal' => number_format($subtotal, 0, ',', '.'),
                    'total' => number_format($total, 0, ',', '.'),
                    'totalPajak' => number_format($totalPajak, 0, ',', '.'),
                    'success' => 'Cart updated successfully'
                ]);
            } else {
                return response()->json(['error' => 'Product not found in cart']);
            }
        } else {
            return response()->json(['error' => 'Invalid request']);
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Cart cleared successfully!');
    }

    public function checkout(Request $request)
    {
        // Hapus pengecekan email_verified_at
        // Langsung proses checkout

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_hp' => 'required|string|max:15',
            'pengiriman' => 'required|string',
            'total' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id_barang' => 'required|integer',
            'products.*.nama' => 'required|string',
            'products.*.harga' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
        ]);

        $id_user = Auth::check() ? Auth::id() : null;

        $totalHargaBarang = $request->total;
        $total = 0;
        $discountedProducts = [];

        foreach ($request->products as $produk) {
            $harga = $produk['harga'];
            $total += $harga * $produk['quantity'];

            $discountedProducts[] = [
                'id_barang' => $produk['id_barang'],
                'nama' => $produk['nama'],
                'harga' => $harga,
                'quantity' => $produk['quantity'],
                'total_harga' => $harga * $produk['quantity'],
            ];
        }

        $transaksi = Transaksi::create([
            'id_user' => $id_user,
            'nama_pembeli' => $request->nama,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'total_harga' => $totalHargaBarang,
        ]);

        foreach ($discountedProducts as $produk) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_barang' => $produk['id_barang'],
                'jumlah' => $produk['quantity'],
                'harga' => $produk['harga'],
                'harga_barang' => $produk['harga'],
                'total_harga' => $produk['total_harga'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order-complete');
    }

    public function orderComplete()
    {
        return view('page.order.order-complete');
    }

    public function sendWhatsAppMessage($total, $produkTransaksi)
    {
        $pesan = "Halo, saya ingin melakukan pembelian dengan total: $" . $total . "%0A%0A";
        foreach ($produkTransaksi as $produk) {
            $pesan .= "Produk: " . $produk['nama'] . " - Harga: $" . $produk['harga'] . "%0A";
        }


        $nomorWhatsApp = "62895411898900";


        $whatsappUrl = "https://wa.me/$nomorWhatsApp?text=" . urlencode($pesan);

        return $whatsappUrl;
    }
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);

                // Increase the stock of the removed product
                $barang = Barang::findOrFail($request->id);
                $stock = Stock::where('id_barang', $barang->id)->first();
                $stock->update([
                    'stock' => $stock->stock + $request->quantity,
                ]);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
    public function orderStatus()
    {
        $userId = Auth::id();


        $detailTransaksis = DetailTransaksi::whereHas('transaksi', function ($query) use ($userId) {
            $query->where('id_user', $userId);
        })->with(['barang', 'transaksi'])->get();


        $formattedTransaksis = [];


        foreach ($detailTransaksis as $detailTransaksi) {
            $transaksiId = $detailTransaksi->id_transaksi;
            if (!array_key_exists($transaksiId, $formattedTransaksis)) {
                $formattedTransaksis[$transaksiId] = [
                    'id_transaksi' => $transaksiId,
                    'nama_produk' => [],
                    'gambar_produk' => [],
                    'total_harga' => 0,
                    'status' => $detailTransaksi->status,
                    'status_button_color' => $this->getStatusButtonColor($detailTransaksi->status),
                ];
            }


            if (isset($detailTransaksi->barang->nama)) {
                $formattedTransaksis[$transaksiId]['nama_produk'][] = $detailTransaksi->barang->nama;
            }


            if (isset($detailTransaksi->barang->gambar)) {
                $formattedTransaksis[$transaksiId]['gambar_produk'][] = $detailTransaksi->barang->gambar;
            } else {

                $formattedTransaksis[$transaksiId]['gambar_produk'][] = 'url_gambar_default.jpg';
            }


            $formattedTransaksis[$transaksiId]['total_harga'] += $detailTransaksi->transaksi->total_harga;
        }


        return view('page.order.order-status', compact('formattedTransaksis'));
    }

    private function getStatusButtonColor($status)
    {
        switch ($status) {
            case 'proses':
                return 'success';
            case 'pending':
                return 'warning';
            default:
                return 'secondary';
        }
    }

    public function orderDetail($orderId)
    {

        $order = DB::table('transaksi')
            ->where('id', $orderId)
            ->first();


        $details = DB::table('detail_transaksi')
            ->join('barang', 'detail_transaksi.id_barang', '=', 'barang.id')
            ->where('detail_transaksi.id_transaksi', $orderId)
            ->select('detail_transaksi.*', 'barang.nama as nama_barang', 'barang.harga', 'barang.gambar as image_url')
            ->get();

        return view('page.order.order-detail', compact('order', 'details'));
    }

    public function cancelOrder($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        DetailTransaksi::where('id_transaksi', $id)->update(['status' => 'dibatalkan']);

        $transaksi->diarsipkan = "true";
        $transaksi->save();

        return redirect()->route('order-status')->with('success', 'Pesanan berhasil dibatalkan.');
    }
    public function doneOrder($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        DetailTransaksi::where('id_transaksi', $id)->update(['status' => 'selesai']);

        $transaksi->save();

        return redirect()->route('order-status')->with('success', 'Pesanan telah Selesai.');
    }
}
