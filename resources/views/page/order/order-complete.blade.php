@extends('layouts.page.master')

@section('title', 'Pembelian Berhasil')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-center" style="min-height: 81.5vh; margin-top: 13px;">
        <div class="d-flex flex-column gap-2 align-items-center">
            <i class="bi bi-check-circle text-coklat-gelap" style="font-size: 75px"></i>
            <h2 class="fs-2 fw-bold text-coklat-gelap">PEMBELIAN BERHASIL</h2>
            <p class="mt-2 mb-4 text-center" style="max-width: 500px">Terima kasih telah membeli! orderan kamu akan di proses dalam waktu 4-6 jam. Kamu juga akan menerima notifikasi melalui email saat orderan kamu selesai.</p>
            <div class="d-flex flex-column w-full gap-2">
                <a href="{{ route('order-status') }}" class="btn btn-coklat-gelap text-white">Cek Status</a>
                <a href="{{ route('list-produk') }}" class="btn btn-outline-coklat-gelap text-white">Lanjut Belanja</a>
            </div>
        </div>
    </div>
@endsection

@section('footer', true)