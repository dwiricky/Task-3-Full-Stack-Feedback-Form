<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Promo;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index() {
        $kategori = Kategori::all();
        $j_barang = [];
        foreach ($kategori as $ki) {
            $j_barang[$ki->nama] = Barang::where('id_kategori', $ki->id)->count();
        }
        $kategori = $kategori->pluck('nama')->all();
        // Chart Line Transaksi
            $bulan = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ];

            $transaksi = Transaksi::select('created_at')->get()->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

            $m_count = [];
            $pendapatan_per_bulan = [];

            foreach ($transaksi as $key => $value) {
                $m_count[(int)$key] = count($value);
            }

            for($i = 0; $i < 12; $i++){
                if(!empty($m_count[$i])){
                    $pendapatan_per_bulan[$bulan[$i]] = $m_count[$i];
                }else{
                    $pendapatan_per_bulan[$bulan[$i]] = 0;
                }
            }

            $today = Transaksi::whereDate('created_at', Carbon::today())->sum('total_harga');
            $this_month = Transaksi::whereMonth('created_at', Carbon::now()->month)->sum('total_harga');
            $this_year = Transaksi::whereYear('created_at', Carbon::now()->year)->sum('total_harga');
        return view('admin.dashboard', compact([
            'j_barang',
            'pendapatan_per_bulan',
            'kategori',
            'today',
            'this_month',
            'this_year'
        ]));
    }
}
