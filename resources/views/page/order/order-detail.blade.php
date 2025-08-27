@extends('layouts.page.master')

@section('title', 'Detail Order Pembelian di Furniture Max')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/page/order.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">
@endsection

@section('content')
    <div class="container-fluid p-5 bg-coklat text-coklat-gelap">
        <div class="container">
            <h1 class="fw-bold px-4 fs-2"><i class="bi bi-receipt"></i> Detail Order Pembelian</h1>
        </div>
    </div>
    <div class="container p-4" style="min-height: 83.3vh;">
        <a onclick="history.back()" class="btn btn-coklat-gelap">Kembali</a>
        <div class="card border-coklat-gelap transaction-card">
            <div class="p-4">
                <h3 class="card-title fw-bold fs-3 text-coklat-gelap">Detail Pembelian</h3>
                <hr class="border-coklat-gelap">
            </div>
            <div class="card-body transaction-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Pembeli:</strong>
                        <input type="text" class="form-control border-coklat-gelap" value="{{ $order->nama_pembeli }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <strong>Alamat:</strong>
                        <textarea class="form-control border-coklat-gelap" rows="3" disabled>{{ $order->alamat }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nomor HP:</strong>
                        <input type="text" class="form-control border-coklat-gelap" value="{{ $order->nomor_hp }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <strong>Pengiriman:</strong>
                        <select class="form-select border-coklat-gelap" disabled>
                            <option value="ninja-express" selected>Ninja Express</option>
                            <option value="jnt-cargo">JNT Cargo</option>
                            <option value="jne-cargo">JNE Cargo</option>
                        </select>
                    </div>
                </div>
                <!-- Loop through order details and display product information -->
                @foreach ($details as $detailTransaksi)
                    @isset($detailTransaksi->resi)
                        <div>
                            <h2 class="bg-coklat-gelap p-2 text-white rounded">Nomor Resi : {{$detailTransaksi->resi}}</h2>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-md-3 d-flex align-items-center">
                            <img src="{{ asset('storage/'.$detailTransaksi->image_url) }}" class="img-fluid product-image" alt="Gambar Produk" style="max-width: 100px;">
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <div>
                                <strong>Nama Produk:</strong>
                                <p class="fs-5">{{ $detailTransaksi->nama_barang }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <div>
                                <strong>Harga :</strong>
                                <?php
                                    $a = $order->total_harga;
                                    $harga = (string) $a;
                                    $harga = strrev($harga);
                                    $arr = str_split($harga, '3');
                                        
                                    $ganti_format_harga = implode('.', $arr);
                                    $harga = strrev($ganti_format_harga);
                                ?>
                                <p class="fs-5">{{ $harga }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <div>
                                <strong>Jumlah Produk:</strong>
                                <div class="quantity-control">
                                    <input type="number" id="quantity" value="{{ $detailTransaksi->jumlah }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End loop -->

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total Harga:</strong>
                        <p class="text-coklat-gelap fs-3" id="totalPrice">
                            {{$harga}}
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 text-end offset-md-6">
                        
                        @foreach ($details as $dt)
                            @if ($dt->status == 'dibatalkan')
                                <button class="btn btn-coklat-gelap" disabled>Dibatalkan</button>
                            @elseif ($dt->status == 'dikirim')
                                <a onclick="confirmDone(this)" data-url="{{ route('order.done', ['id' => $order->id]) }}" class="btn btn-success" role="button"><i class="bi bi-check-circle me-2"></i>Pesanan Sampai</a>
                            @elseif ($dt->status == 'selesai')
                                <p>Pesanan Telah Selesai.</p>
                            @else
                                <a onclick="confirmDelete(this)" data-url="{{ route('order.cancel', ['id' => $order->id]) }}" class="btn btn-danger" role="button"><i class="bi bi-x-circle me-2"></i>Batalkan Pesanan</a>
                            @endif
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer', true)
@section('js-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        confirmDelete = function(button) {
            var url = $(button).data('url');
            swal({
                'title': 'Batalkan Pesanan',
                'text': 'Apakah Kamu Yakin Ingin Membatalkan Pesanan ini?',
                'dangerMode' : true,
                'buttons': true
            }).then(function(value) {
                if (value) {
                    window.location = url;
                }
            })
        }
        confirmDone = function(button) {
            var url = $(button).data('url');
            swal({
                'title': 'Pesanan Selesai',
                'text': 'Apakah Kamu Yakin Ingin Menyelesaikan Pesanan ini?',
                'buttons': true
            }).then(function(value) {
                if (value) {
                    window.location = url;
                }
            })
        }
    </script>
@endsection
