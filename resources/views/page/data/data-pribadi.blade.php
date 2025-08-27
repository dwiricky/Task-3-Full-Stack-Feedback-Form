@extends('layouts.page.master')

@section('title', 'Data Saya')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('content')
<div class="container-fluid flex justify-center bg-coklat p-4 text-coklat-gelap">
    <h1 class="fs-1 fw-bold"><i class="bi bi-card-list"></i> Data Pribadi</h1>
</div>
<div class="container-fluid" id="session">
    @if (session('success'))
        <div class="bg-coklat text-coklat-gelap fs-3 p-2 px-4 rounded mt-2 d-flex justify-content-between">
            {{ session('success') }}
            <a onclick="hideSession()"><i class="bi bi-x"></i></a>
        </div>
    @elseif (session('error'))
        <div class="bg-coklat text-coklat-gelap fs-3 p-2 px-4 rounded mt-2 d-flex justify-content-between">
            {{ session('error') }}
            <a onclick="hideSession()"><i class="bi bi-x"></i></a>
        </div>
    @endif
</div>
<div class="container-fluid" style="min-height: 65.5vh">
    <div class="row my-2">
        <div class="col-12 col-lg-6 p-4 bg-coklat mx-auto">
            <form action="{{route('update-data', Auth::user()->id)}}" method="POST">
                @csrf
                <div class="my-4">
                    <label class="mb-2 fs-4">Nama</label>
                    <input type="text" name="nama" value="{{Auth::user()->nama}}" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Kamu">
                </div>
                @error('nama')
                    <div class="alert bg-coklat-gelap text-white mt-2">
                        {{$message}}
                    </div>
                @enderror
                <div class="my-4">
                    <label class="mb-2 fs-4">Email</label>
                    <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control @error('email') is-invalid @enderror" placeholder="Email Kamu">
                </div>
                @error('email')
                    <div class="alert bg-coklat-gelap text-white mt-2">
                        {{$message}}
                    </div>
                @enderror
                <div class="my-4">
                    <label class="mb-2 fs-4">Nomor HP</label>
                    <input type="text" name="nomor_hp" value="{{Auth::user()->nomor_hp}}" class="form-control" placeholder="Topik">
                </div>
                <div class="my-4">
                    <label class="mb-2 fs-4">Alamat Pengiriman</label>
                    <textarea name="alamat" class="form-control" cols="30" rows="10" placeholder="Alamat Saya">{{Auth::user()->alamat}}</textarea>
                </div>
                <div class="my-4">
                    <input type="submit" value="Perbaharui Data" class="btn btn-coklat-gelap">
                </div>
            </form>
        </div>
        {{-- <div class="col-12 col-lg-6 p-4">
            <form action="mailto:valinellaprojects@gmail.com" method="POST" enctype="multipart/form-data" name="EmailForm">
                <div class="my-4">
                    <label class="mb-2 fs-3">Ubah Password</label>
                </div>
                <div class="my-4">
                    <label class="mb-2 fs-4">Password Saat Ini</label>
                    <input type="password" name="passwordAwal" class="form-control">
                </div>
                <div class="my-4">
                    <label class="mb-2 fs-4">Password Baru</label>
                    <input type="password" name="passwordAwal" class="form-control">
                </div>
                <div class="my-4">
                    <label class="mb-2 fs-4">Konfirmasi Password</label>
                    <input type="password" name="passwordAwal" class="form-control">
                </div>
                <div class="my-4">
                    <input type="submit" value="Ubah Password" class="btn btn-outline-coklat-gelap">
                </div>
            </form>
        </div> --}}
    </div>
</div>
@endsection

@section('footer', true)
@section('js-scripts')
    <script>
        function hideSession() {
            document.getElementById('session').style.display = 'none';
        }
        // document.getElementById('hideSession').addEventListener('click', function() {
        //     document.getElementById('session').style.display = 'none';
        // })
    </script>
@endsection