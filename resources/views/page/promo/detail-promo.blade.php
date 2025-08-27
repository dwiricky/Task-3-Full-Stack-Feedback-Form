@extends('layouts.page.master')

@section('title', 'Detail Promo di Furniture Max')

@section('css-style')
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('content')
    <div class="container-fluid p-5 bg-coklat">
        <div class="container">
            <h1 class="fw-bold px-4 fs-2 text-coklat-gelap"><i class="bi bi-megaphone-fill"></i> DETAIL PROMO</h1>
        </div>
    </div>
    <div class="container p-4" style="min-height:83.3vh">
        <a onclick="history.back()" class="btn btn-coklat-gelap">Kembali</a>
        <div class="card mt-4 border-none border-2 rounded-none border-coklat-gelap">
            <div class="card-body">
                <h3 class="card-title fw-bold fs-3">{{ $promo->nama }}</h3>
                <p class="card-text my-2">{{ $promo->deskripsi }}</p>
                <?php
                    $harga = (string) $promo->pengurangan_harga;
                    $harga = strrev($harga);
                    $arr = str_split($harga, '3');
                        
                    $ganti_format_harga = implode('.', $arr);
                    $harga = strrev($ganti_format_harga);
                ?>
                <p class="card-text my-2">Potongan (Rp) : {{ $harga }}</p>
            </div>
        </div>
        <h1 class="fw-bold fs-2 mt-4 text-coklat-gelap"><i class="bi bi-box2-fill text-sage"></i> BARANG YANG TERSEDIA</h1>
        <div class="row gap-y-4 mt-4">
            @forelse ($promo->promoBarang as $barang)
                <div class="col-sm-12 col-md-6">
                    <div class="card text-sm-center text-md-start border-none border-2 rounded-none mb-3 border-coklat-gelap">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $barang->gambar) }}"
                                    class="mx-auto img-fluid rounded-start" width="200px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h2 class="card-title fs-2 fw-bold">{{ $barang->nama }}</h2>
                                    <p class="card-text">{!! $barang->deskripsi !!}</p>
                                    <?php
                                        $harga = (string) $barang->harga;
                                        $harga = strrev($harga);
                                        $arr = str_split($harga, '3');
                                            
                                        $ganti_format_harga = implode('.', $arr);
                                        $harga = strrev($ganti_format_harga);
                                    ?>
                                    <p class="card-text"><small class="text-body-secondary">Rp. {{ $harga }}</small>
                                    </p>
                                    <div class="d-flex align-items-center justify-items-center gap-2">
                                        <a href="{{route('detail-produk',$barang->id)}}" class="btn btn-coklat-gelap my-3"><i class="bi bi-eye"></i></a>
                                        @if ($barang->stock->status == "Habis")
                                            Maaf, Produk saat ini sedang Kosong / Habis.
                                        @else
                                            <a onclick="confirmCart(this)" data-url="{{ route('add.to.cart', ['id' => $barang->id]) }}" class="btn btn-coklat-gelap my-3" role="button"><i class="bi bi-cart"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada barang untuk promo ini.</p>
            @endforelse
        </div>
    </div>
@endsection

@section('footer', true)
@section('js-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        confirmCart = function(button) {
            var url = $(button).data('url');
            swal({
                'title': 'Tambah Barang',
                'text': 'Apakah Kamu Yakin Ingin Menambah Barang Ini?',
                'buttons': true
            }).then(function(value) {
                if (value) {
                    window.location = url;
                }
            })
        }
    </script>
@endsection
