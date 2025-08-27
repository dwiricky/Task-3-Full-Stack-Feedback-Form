@extends('layouts.page.master')

@section('title', 'Welcome to Furniture Max')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/page/welcome.css') }}">
@endsection

@section('content')
    {{-- Section Home --}}
    <section id="home" class="container-fluid bg-coklat py-5">
        <div class="container d-flex flex-column-reverse flex-md-row justify-content-center align-items-center mx-auto">
            <div class="w-100 w-md-50">
                <h1 class="fw-bold brand-title text-coklat-gelap text-center text-md-start">Furniture Max</h1>
                <p class="brand-description">Deskripsi singkat tentang website Furniture Max yang menawarkan berbagai macam furniture berkualitas tinggi dengan harga terjangkau.</p>
                <a href="{{route('list-produk')}}" class="btn btn-coklat-gelap">Lihat Furniture Kami</a>
            </div>
            <div class="w-100 w-md-50">
                <img src="{{ asset('assets/img/produk/sofa header.png') }}" alt="Produk" class="img-fluid">
            </div>
        </div>
    </section>

    {{-- Section Promo --}}
    @if($promoItems->count() > 0)
        <section id="promo" class="container-fluid text-center text-coklat-gelap">
            <h2 class="brand-title py-5"><i class="bi bi-percent"></i> Promo</h2>
            <div class="promo-products">
                @forelse ($promoItems as $promoItem)
                    @if($promoItem->diarsipkan == "true")
                    
                    @else
                        @foreach ($promoItem->promoBarang as $items)
                            <div class="product-card">
                                <img src="{{ asset('storage/' . $items->gambar) }}" alt="Living Room Sofa"
                                    class="product-image">
                                <h3>{{ $items->nama }}</h3>
                                <p class="normal-price">Rp {{ number_format($items->harga, 0, ',', '.') }}</p>
                                @if ($harga_promo = $items->harga - $promoItem->pengurangan_harga)
                                    <p class="promo-price">Rp {{ number_format($harga_promo, 0, ',', '.') }}</p>
                                @endif
                                @if ($items->stock->status == "Habis")
                                    <p>Maaf, Produk saat ini sedang Kosong / Habis.</p>
                                @else
                                    <a onclick="confirmCart(this)" data-url="{{ route('add.to.cart', ['id' => $items->id]) }}" class="btn btn-coklat-gelap my-3" role="button"><i class="bi bi-cart"></i></a>
                                @endif
                                <a href="{{route('detail-produk', $items->id)}}" class="btn btn-outline-coklat-gelap"><i class="bi bi-bag"></i></a>
                            </div>
                        @endforeach
                    @endif
                @empty
                    <p>Tidak ada promo saat ini.</p>
                @endforelse
            </div>

            <div class="more-products">
                <a href="/promo" class="btn btn-outline-coklat-gelap">Lihat Promo Selengkapnya</a>
            </div>
        </section>
    @else
    <h2 class="brand-title text-coklat-gelap text-center bg-coklat p-5 mt-1">Tidak Ada Promo Yang Tersedia</h2>
    @endif

    {{-- Section Produk --}}
    <section id="produk" class="container-fluid text-center text-coklat-gelap py-5">
        <h2 class="brand-title py-5"><i class="bi bi-box2"></i> Produk</h2>
        <div class="category-links">
            @foreach ($kategori as $item)
            <a class="btn btn-outline-coklat-gelap" onclick="showCategory({{$item->id}})">{{$item->nama}}</a>
            @endforeach
        </div>
        @foreach ($kategoris as $kategori)
            <div class="category" id="kategori-{{$kategori->id}}">
                <h3>Kategori {{$kategori->nama}}</h3>
                <div class="product-category">
                    @foreach ($kategori->barang as $barang)
                        @if($barang->diarsipkan == "true")

                        @else
                            <div class="product-card">
                                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Living Room Sofa" class="product-image">
                                <h3>{{ $barang->nama }}</h3>
                                {{-- format harga dari xxxxxxx to x.xxx.xxx --}}
                                <?php
                                    $harga = (string) $barang->harga;
                                    $harga = strrev($harga);
                                    $arr = str_split($harga, '3');
                                    
                                    $ganti_format_harga = implode('.', $arr);
                                    $ganti_format_harga = strrev($ganti_format_harga);
                                ?>
                                <p class="price">Rp {{ $ganti_format_harga }}</p>
                                <span>{{ $barang->kategori->nama }}</span> <br>
                                @if ($barang->stock->status == "Habis")
                                    <p>Maaf, Produk saat ini sedang Kosong / Habis.</p>
                                @else
                                    <a onclick="confirmCart(this)" data-url="{{ route('add.to.cart', ['id' => $barang->id]) }}" class="btn btn-coklat-gelap my-3" role="button"><i class="bi bi-cart"></i> Add to Cart</a>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
        <div>
            <a href="{{route('list-produk')}}" class="btn btn-outline-coklat-gelap">Lihat Produk Selengkapnya</a>
        </div>
    </section>

@endsection
@section('about-us', true)
@section('kontak', true)
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
        document.addEventListener("DOMContentLoaded", function() {
            showCategory(1);
        });
        function showCategory(id) {
            const kategoris = document.querySelectorAll('.category');
            kategoris.forEach((kategori) => {
                kategori.style.display = 'none';
            });
            const selectedKategori = document.getElementById('kategori-' + id);
            selectedKategori.style.display = 'block';
        }
    </script>
@endsection
