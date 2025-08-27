@extends('layouts.page.master')

@section('title', 'Detail Produk')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/page/detail-produk.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">
@endsection

@section('content')
    <div class="container-fluid p-5 bg-coklat">
        <div class="container">
            <h1 class="fw-bold px-4 fs-2"><i class="bi bi-info-circle-fill text-coklat-gelap"></i> DETAIL PRODUK</h1>
        </div>
    </div>
    <div class="container p-4" style="min-height: 83.3vh;">
        <a onclick="history.back()" class="btn btn-coklat-gelap">Kembali</a>
        <div class="card mt-4 border-none border-5 border-start rounded-none border-coklat-gelap">
            <div class="row g-0">
                <div class="col-md-4 product-image">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-fluid rounded-start" alt="Gambar Produk">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title fw-bold fs-2">{{ $produk->nama }}</h2>
                        <p class="kategori"><span class="bold">Kategori:</span></br>{{ $produk->kategori->nama }}</p>
                        <p class="card-text my-2"><span class="bold">Deskripsi:</span></br> {!! $produk->deskripsi !!}</p>
                        <p class="card-text my-2 text-coklat-gelap"><strong>Harga: Rp. {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                        <div class="rating my-2">
                            <strong class="me-2">Rating:</strong>
                            <div class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $rating)
                                        <i class="bi bi-star-fill"></i>
                                    @elseif ($i == ceil($rating) && ($rating - floor($rating)) >= 0.5)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span>({{ number_format($rating, 1) }}/5 dari {{ $ulasan->count() }} ulasan)</span>
                        </div>
                        @if ($produk->stock->status == "Habis")
                            <p>Maaf, Produk saat ini sedang Kosong / Habis.</p>
                        @else
                            <a onclick="confirmCart(this)" data-url="{{ route('add.to.cart', ['id' => $produk->id]) }}" class="btn btn-coklat-gelap my-3" role="button"><i class="bi bi-cart"></i> Add to Cart</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <h3 class="fw-bold fs-3 mt-4"><i class="bi bi-star-fill text-coklat-gelap"></i> ULASAN PRODUK</h3>
        
        {{-- Form Tambah Ulasan (Tetap Sama) --}}
        <h4 class="fw-bold fs-4 mt-4">Tambahkan Komentar Anda</h4>
        @auth
            @if ($produk->userHasPurchased())
                <div class="row mt-3">
                    <div class="col-12">
                        <form action="{{ route('ulasan.store', ['barang_id' => $produk->id]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <div class="rating" id="rating-form-stars">
                                    <i class="bi bi-star" data-value="1"></i>
                                    <i class="bi bi-star" data-value="2"></i>
                                    <i class="bi bi-star" data-value="3"></i>
                                    <i class="bi bi-star" data-value="4"></i>
                                    <i class="bi bi-star" data-value="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating-value" required>
                            </div>
                            <div class="mb-3">
                                <label for="komentar" class="form-label">Komentar</label>
                                <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-coklat-gelap">Kirim Komentar</button>
                        </form>
                    </div>
                </div>
            @else
                <p>Anda hanya dapat menambahkan komentar setelah melakukan transaksi.</p>
            @endif
        @else
            <p>Anda harus <a href="{{ route('login') }}">login</a> untuk menambahkan komentar.</p>
        @endauth
        
        {{-- PERUBAHAN: Container untuk daftar ulasan yang akan diisi oleh JavaScript --}}
        <div id="ulasan-container" class="row gap-y-4 mt-4">
            {{-- Ulasan akan dimuat di sini secara dinamis --}}
        </div>
        
    </div>
@endsection

@section('footer', true)
@section('js-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // Skrip SweetAlert (Tetap Sama)
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
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Skrip untuk rating bintang pada form (Sedikit penyesuaian pada selector)
            const stars = document.querySelectorAll('#rating-form-stars i');
            const ratingValue = document.getElementById('rating-value');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingValue.value = value;
                    updateStars(value);
                });
            });

            function updateStars(value) {
                stars.forEach(star => {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                    if (star.getAttribute('data-value') <= value) {
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill', 'text-warning');
                    }
                });
            }

            // --- PERUBAHAN UTAMA: Skrip untuk Fetch Ulasan ---
            const ulasanContainer = document.getElementById('ulasan-container');
            const produkId = {{ $produk->id }}; // Ambil ID produk dari PHP

            // Tampilkan loading spinner atau pesan
            ulasanContainer.innerHTML = '<div class="col-12 text-center"><p>Memuat ulasan...</p></div>';

            fetch(`/produk/${produkId}/ulasan`)
                .then(response => response.json())
                .then(data => {
                    ulasanContainer.innerHTML = ''; // Kosongkan pesan loading

                    if (data.length === 0) {
                        ulasanContainer.innerHTML = '<div class="col-12"><p>Belum ada ulasan untuk produk ini.</p></div>';
                        return;
                    }

                    data.forEach(review => {
                        // Buat Bintang Rating
                        let starsHTML = '';
                        for (let i = 1; i <= 5; i++) {
                            starsHTML += `<i class="bi ${i <= review.rate ? 'bi-star-fill' : 'bi-star'}"></i>`;
                        }

                        // Format Tanggal
                        const reviewDate = new Date(review.created_at);
                        const formattedDate = reviewDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

                        // Buat Card untuk setiap ulasan
                        const reviewCard = `
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5 class="review-title">${review.user ? review.user.nama : 'User tidak diketahui'}</h5>
                                                <p class="review-date"><small class="text-muted">Tanggal Ulasan: ${formattedDate}</small></p>
                                            </div>
                                            <div class="stars text-warning">
                                                ${starsHTML}
                                            </div>
                                        </div>
                                        <p class="review-text">${review.komentar}</p>
                                    </div>
                                </div>
                            </div>`;
                        
                        ulasanContainer.innerHTML += reviewCard;
                    });
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                    ulasanContainer.innerHTML = '<div class="col-12"><p>Gagal memuat ulasan. Silakan coba lagi nanti.</p></div>';
                });
        });
    </script>
@endsection