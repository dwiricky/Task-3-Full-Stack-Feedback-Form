@extends('layouts.page.master')

@section('title', 'Status Order di Furniture Max')

@section('css-style')
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .product-image {
            max-width: 150px; /* Atur ukuran sesuai kebutuhan */
            height: auto;
        }
        .product-container {
            max-width: 33.33%; /* Mengatur agar maksimal 3 produk dalam satu baris */
            margin-right: 4rem; /* Menambahkan jarak antara produk */
            margin-bottom: 1rem; /* Menambahkan jarak antara baris produk */
        }
        .rating-stars {
            font-size: 1.6rem; /* Membuat ukuran bintang lebih besar */
            color: #e4e5e9; /* Warna bintang default (putih) */
        }
        .rating-stars .bi-star-fill.active {
            color: #FFD700; /* Warna emas untuk bintang aktif */
        }
        .btn-sage {
            background-color: #93D459; /* Warna Sage */
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-5 bg-coklat">
        <div class="container text-coklat-gelap">
            <h1 class="fw-bold px-4 fs-2"><i class="bi bi-list-task"></i> Status Order</h1>
        </div>
    </div>
    <div class="container p-4" style="min-height:83.3vh">
        <a onclick="history.back()" class="btn btn-coklat-gelap mb-3">Kembali</a>
        <div class="row gap-y-4 mt-4">
            @foreach($formattedTransaksis as $index => $formattedTransaksi)
                <div class="col-sm-12 my-2 col-md-6">
                    <div class="card border-none border-3 rounded-none border-coklat-gelap">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <div class="product-container">
                                    @foreach($formattedTransaksi['gambar_produk'] as $gambarProduk)
                                        <img src="{{ asset('storage/'. $gambarProduk ) }}" alt="Gambar Produk" class="img-fluid mb-3 product-image">
                                    @endforeach
                                    @foreach($formattedTransaksi['nama_produk'] as $namaProduk)
                                        <h3 class="card-title fw-bold fs-5">{{ $namaProduk }}</h3>
                                    @endforeach
                                </div>
                            </div>
                            <p class="card-text">Total Di Bayar : 
                                <?php
                                    $harga = (string) $formattedTransaksi['total_harga'];
                                    $harga = strrev($harga);
                                    $arr = str_split($harga, '3');
                                        
                                    $ganti_format_harga = implode('.', $arr);
                                    $harga = strrev($ganti_format_harga);
                                ?> {{ $harga }}</p>
                            <button class="text-capitalize btn btn-{{ $formattedTransaksi['status_button_color'] }}" disabled>{{ $formattedTransaksi['status'] }}</button>
                            <a href="{{ route('order-detail', ['id' => $formattedTransaksi['id_transaksi']]) }}" class="btn btn-outline-coklat-gelap ms-2">Detail Order</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('footer', true)

@section('js-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.rating-stars .bi-star-fill');
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
@endsection