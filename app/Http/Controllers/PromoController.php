<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Barang;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promo = Promo::with('promoBarang')->where('diarsipkan', 'false')->paginate(10);
        return view('admin.promo.home', compact('promo'));
    }
    public function create()
    {
        $barang = Barang::all();
        return view('admin.promo.create', compact('barang'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            'pengurangan_harga' => 'required|numeric',
            'id_barang' => 'required|array',
            'id_barang.*' => 'exists:barang,id',
        ], [
            'id_barang.required' => 'Barang harus dipilih.',
            'id_barang.*.exists' => 'Barang yang dipilih tidak valid.',
        ]);

        $promo = Promo::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'pengurangan_harga' => $request->pengurangan_harga,
        ]);

        $promo->promoBarang()->attach($request->id_barang);

        return redirect(route('promo.index'))->with('success', 'Promo Berhasil Dibuat.');
    }

    public function edit($id)
    {
        $promo = Promo::with('promoBarang')->findOrFail($id);
        $barang = Barang::all();
        return view('admin.promo.edit', compact('promo', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            'pengurangan_harga' => 'required|numeric',
            'id_barang' => 'required|array',
            'id_barang.*' => 'exists:barang,id',
        ], [
            'id_barang.required' => 'Barang harus dipilih.',
            'id_barang.*.exists' => 'Barang yang dipilih tidak valid.',
        ]);

        $promo = Promo::findOrFail($id);
        $promo->nama = $request->nama;
        $promo->deskripsi = $request->deskripsi;
        $promo->pengurangan_harga = $request->pengurangan_harga;
        $promo->save();

        $promo->promoBarang()->sync($request->id_barang);

        return redirect(route('promo.index'))->with('success', 'Promo Berhasil Diperbarui.');
    }


    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->diarsipkan = "true";
        $promo->save();

        return redirect(route('promo.index'))->with('success', 'Promo Berhasil Dihapus.');
    }
}
