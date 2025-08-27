@extends('layouts.page.master')

@section('title', 'List Promo di Furniture Max')

@section('css-style')
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('content')
    <div class="container-fluid p-5 bg-coklat text-coklat-gelap">
        <div class="container">
            <h1 class="fw-bold px-4 fs-2"><i class="bi bi-megaphone-fill"></i> LIST PROMO</h1>
        </div>
    </div>
    <div class="container p-4" style="min-height:83.3vh">
        <a onclick="history.back()" class="btn btn-coklat-gelap">Kembali</a>
        <div class="row gap-y-4 mt-4">
            @foreach($promo as $item)
            <div class="col-sm-12 col-md-6">
                <div class="card border-none border-2 rounded-none border-coklat-gelap">
                    <div class="card-body">
                      <h3 class="card-title fw-bold text-coklat-gelap fs-3">{{$item->nama}}</h3>
                      <p class="card-text my-2">{{$item->deskripsi}}</p>
                        <?php
                            $harga = (string) $item->pengurangan_harga;
                            $harga = strrev($harga);
                            $arr = str_split($harga, '3');
                                
                            $ganti_format_harga = implode('.', $arr);
                            $harga = strrev($ganti_format_harga);
                        ?>
                      <p class="card-text my-2">Potongan (Rp) : {{$harga}}</p>
                      <a href="{{ route('detail-promo',$item->id)}}" class="btn btn-outline-coklat-gelap"><i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@section('footer', true)