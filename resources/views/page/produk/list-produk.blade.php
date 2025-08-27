@extends('layouts.page.master')

@section('title', 'List Produk')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/page/list-produk.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">
@endsection

@section('content')
    <div class="container-fluid p-5 bg-coklat">
        <div class="container">
            <h1 class="fw-bold px-4 fs-2 text-coklat-gelap"><i class="bi bi-box2-fill"></i> LIST PRODUK</h1>
        </div>
    </div>
    <div class="container p-4" style="min-height: 83.3vh;">
        <a onclick="history.back()" class="btn btn-coklat-gelap mb-3">Kembali</a>
        <!-- Filter by Category -->
        <div class="category-select mb-4">
            <form id="filterForm">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Pilih Kategori Produk</strong>
                        <select class="form-select" id="category" name="category" onchange="filterProducts()">
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 search-container">
                        <strong>Pencarian Produk</strong>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Masukkan Nama Produk..." oninput="searchProducts()">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Product List -->
        <div class="row" id="productList">
            @if(count($products) > 0)
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="product-image">
                                <img src="{{ asset('storage/' . $product->gambar) }}" class="img-fluid rounded-start" alt="{{ $product->nama }}">
                                @if ($product->stock->status == 'Habis')
                                    <p class="bg-danger cart-icon">HABIS</p>
                                @else
                                    <i class="bi bi-cart-fill bg-coklat-gelap cart-icon" onclick="confirmCart(this)" data-url="{{ route('add.to.cart', ['id' => $product->id]) }}"></i>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold fs-3">{{ $product->nama }}</h5>
                                <p class="kategori"><span class="fw-bold">Kategori:</span> {{ $product->kategori->nama }}</p>
                                <p class="card-text my-2">{!! $product->deskripsi !!}</p>
                                <p class="card-text my-2 text-coklat-gelap"><strong>Harga: Rp. {{ number_format($product->harga, 0, ',', '.') }}</strong></p>
                                <div class="rating my-2">
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <span>(4.5/5 dari 2 ulasan)</span>
                                </div>
                                <a href="{{ route('detail-produk', ['id' => $product->id]) }}" class="btn btn-outline-coklat-gelap">Detail Produk</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div>Barang tidak ditemukan.</div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>

    <script>
        
    </script>
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
    function filterProducts() {
        const categoryId = document.getElementById('category').value;
        fetch(`/products-by-category?category_id=${categoryId}`).then(response => response.json()).then(data => {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';
            if (data.length > 0) {
                data.forEach(product => {
                    if (product.diarsipkan !== "true") {
                        if (product.stock.status !== "Habis") {
                            const productCard = `
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="product-image">
                                            <img src="/storage/${product.gambar}" class="img-fluid rounded-start" alt="${product.nama}">
                                            <i class="bi bi-cart-fill bg-coklat-gelap cart-icon" onclick="confirmCart(this)" data-url="/add-to-cart/${product.id}"></i>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold fs-3">${product.nama}</h5>
                                            <p class="kategori"><span class="fw-bold">Kategori:</span> ${product.kategori.nama}</p>
                                            <p class="card-text my-2">${product.deskripsi}</p>
                                            <p class="card-text my-2 text-coklat-gelap"><strong>Harga: Rp. ${new Intl.NumberFormat('id-ID').format(product.harga)}</strong></p>
                                            <div class="rating my-2">
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div>
                                                <span>(4.5/5 dari 2 ulasan)</span>
                                            </div>
                                            <a href="/detail-produk/${product.id}" class="btn btn-outline-coklat-gelap">Detail Produk</a>
                                        </div>
                                    </div>
                                </div> `;
                            productList.innerHTML += productCard;
                        } else {
                            const productCard = `
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="product-image">
                                            <img src="/storage/${product.gambar}" class="img-fluid rounded-start" alt="${product.nama}">
                                            <p class="bg-danger cart-icon">HABIS</p>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold fs-3">${product.nama}</h5>
                                            <p class="kategori"><span class="fw-bold">Kategori:</span> ${product.kategori.nama}</p>
                                            <p class="card-text my-2">${product.deskripsi}</p>
                                            <p class="card-text my-2 text-coklat-gelap"><strong>Harga: Rp. ${new Intl.NumberFormat('id-ID').format(product.harga)}</strong></p>
                                            <div class="rating my-2">
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div>
                                                <span>(4.5/5 dari 2 ulasan)</span>
                                            </div>
                                            <a href="/detail-produk/${product.id}" class="btn btn-outline-coklat-gelap">Detail Produk</a>
                                        </div>
                                    </div>
                                </div> `;
                            productList.innerHTML += productCard;
                        }
                    }
                });
            } else {
                const productCard = `<div>Barang tidak di Temukan.</div>`;
                productList.innerHTML += productCard;
            }
        }).catch(error => console.error('Error:', error));
    }

    function searchProducts() {
        const search = document.getElementById('search').value.toLowerCase();
        const categoryId = document.getElementById('category').value;
        fetch(`/products-by-category?category_id=${categoryId}&search=${search}`).then(response => response.json()).then(data => {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';
            if (data.length > 0) {
                data.forEach(product => {
                    if (product.nama.toLowerCase().includes(search) && product.diarsipkan !== "true") {
                        if (product.stock.status !== "Habis") {
                            const productCard = `
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="product-image">
                                            <img src="/storage/${product.gambar}" class="img-fluid rounded-start" alt="${product.nama}">
                                            <i class="bi bi-cart-fill bg-coklat-gelap cart-icon" onclick="confirmCart(this)" data-url="/add-to-cart/${product.id}"></i>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold fs-3">${product.nama}</h5>
                                            <p class="kategori"><span class="fw-bold">Kategori:</span> ${product.kategori.nama}</p>
                                            <p class="card-text my-2">${product.deskripsi}</p>
                                            <p class="card-text my-2 text-coklat-gelap"><strong>Harga: Rp. ${new Intl.NumberFormat('id-ID').format(product.harga)}</strong></p>
                                            <div class="rating my-2">
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div>
                                                <span>(4.5/5 dari 2 ulasan)</span>
                                            </div>
                                            <a href="/detail-produk/${product.id}" class="btn btn-outline-coklat-gelap">Detail Produk</a>
                                        </div>
                                    </div>
                                </div> `;
                            productList.innerHTML += productCard;
                        } else {
                            const productCard = `
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="product-image">
                                            <img src="/storage/${product.gambar}" class="img-fluid rounded-start" alt="${product.nama}">
                                            <p class="bg-danger cart-icon">HABIS</p>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold fs-3">${product.nama}</h5>
                                            <p class="kategori"><span class="fw-bold">Kategori:</span> ${product.kategori.nama}</p>
                                            <p class="card-text my-2">${product.deskripsi}</p>
                                            <p class="card-text my-2 text-coklat-gelap"><strong>Harga: Rp. ${new Intl.NumberFormat('id-ID').format(product.harga)}</strong></p>
                                            <div class="rating my-2">
                                                <div class="stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div>
                                                <span>(4.5/5 dari 2 ulasan)</span>
                                            </div>
                                            <a href="/detail-produk/${product.id}" class="btn btn-outline-coklat-gelap">Detail Produk</a>
                                        </div>
                                    </div>
                                </div> `;
                            productList.innerHTML += productCard;
                        }
                    }
                });
            } else {
                const productCard = `<div>Barang tidak di Temukan.</div>`;
                productList.innerHTML += productCard;
            }
        }).catch(error => console.error('Error:', error));
    }
</script>