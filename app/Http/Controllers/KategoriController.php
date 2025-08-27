<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::where('diarsipkan', 'false')->paginate(10);
        return view('admin.kategori.home', compact('kategori'));
    }
    public function create()
    {
        return view('admin.kategori.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:5'
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'diarsipkan' => 'false',
        ]);

        return redirect(route('kategori.index'))->with('success', 'Kategori Berhasil Dibuat!!!');
    }
    public function edit(String $id)
    {
        $kategori = Kategori::findOrFail($id);
        // dd($selected_barang);
        return view('admin.kategori.edit', compact('kategori'));
    }
    public function update(Request $request, String $id)
    {
        $this->validate($request, [
            'nama' => 'required|min:5',
            'diarsipkan' => 'false',
        ]);
        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'id_kategori' => $request->id,
            'nama' => $request->nama,
            'diarsipkan' => 'false',
        ]);

        return redirect(route('kategori.index'))->with('success', 'Kategori Berhasil Diedit!!!');
    }
    public function destroy(String $id)
    {
        if (Kategori::count() > 1) {
            $available_kategori = Kategori::where('id', '!=', $id)->first();
            $selected_kategori = Kategori::findOrFail($id);

            $barang = Barang::where('id_kategori', $id);
            $barang->update([
                'id_kategori' => $available_kategori->id,
                'updated_at' => Carbon::now(),
            ]);

            $selected_kategori->diarsipkan = "true";
            $selected_kategori->save();

            return redirect(route('kategori.index'))->with('success', 'Kategori Berhasil di Hapus!!!');
        } else {
            return redirect(route('kategori.index'))->with('error', 'Kategori Tidak dapat dihapus!!!');
        }
    }
}
