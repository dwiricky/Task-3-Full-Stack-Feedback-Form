<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::where('diarsipkan', 'false')->paginate(10);
        return view('admin.barang.home', compact('barang'));
    }

    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $products = Barang::where('id_kategori', $categoryId)->with(['kategori','stock'])->get();
        return response()->json($products);
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.barang.create', compact('kategori'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_kategori' => 'required|integer',
            'gambar' => 'required|image|max:2048|mimes:png,jpg,jpeg',
            'nama' => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'harga' => 'required',
            'stock' => 'required|integer'
        ]);

        if ($request->stock > 0) {
            $status = 'Tersedia';
        } else {
            $status = 'Habis';
        }

        $gambar = $request->file('gambar');
        $gambar->store('public');

        $barang = Barang::create([
            'id_kategori' => $request->id_kategori,
            'gambar' => $gambar->hashName(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'diarsipkan' => 'false',
        ]);
        Stock::create([
            'id_barang' => $barang->id,
            'stock' => $request->stock,
            'status' => $status,
        ]);
        return redirect(route('barang.index'))->with('success', 'Barang Berhasil Dibuat!!!');
    }
    public function edit(String $id)
    {
        $selected_barang = Barang::findOrFail($id);
        // dd($selected_barang);
        $kategori = Kategori::all();
        return view('admin.barang.edit', compact(['kategori', 'selected_barang']));
    }
    public function update(Request $request, String $id)
    {
        $this->validate($request, [
            'id_kategori' => 'required|integer',
            'gambar' => 'image|max:2048|mimes:png,jpg,jpeg',
            'nama' => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'harga' => 'required',
            'stock' => 'required|integer'
        ]);

        $barang = Barang::findOrFail($id);

        if ($request->stock > 0) {
            $status = 'Tersedia';
        } else {
            $status = 'Habis';
        }

        $stock = Stock::where('id_barang', $id)->first();
        $stock->update([
            'stock' => $request->stock,
            'status' => $status,
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar->store('public');
            Storage::delete($barang->gambar);
            $barang->update([
                'id_kategori' => $request->id_kategori,
                'gambar' => $gambar->hashName(),
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'diarsipkan' => 'false',
            ]);
        } else {
            $barang->update([
                'id_kategori' => $request->id_kategori,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'diarsipkan' => 'false',
            ]);
        }

        return redirect(route('barang.index'))->with('success', 'Barang Berhasil Diedit!!!');
    }
    public function destroy(String $id)
    {
        $selected_barang = Barang::findOrFail($id);
        Storage::delete($selected_barang->gambar);

        $selected_barang->diarsipkan = "true";
        $selected_barang->save();
        return redirect(route('barang.index'))->with('success', 'Data Berhasil di Hapus');
    }
}
