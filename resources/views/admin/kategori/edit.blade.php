@extends('admin.layouts.master')

@section('body')
<main class="main-content border-radius-lg ">
    <!-- Navbar -->
    @include('admin.components.navbar')
    <div class="p-4 mx-4" style="min-height: 80vh">
        <p> >> CAPSTONE#1_FS2 / Dashboard / Kategori / Edit </p>
        {{-- Start Here --}}
        <h2>Ini adalah halaman edit kategori untuk admin</h2>
        <a href="{{route('kategori.index')}}" class="btn bg-gradient-info">Kembali</a>
        <form action="{{route('kategori.update', $kategori->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group input-group-dynamic mb-4">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{$kategori->nama}}" placeholder="Nama Kategori" name="nama">
            </div>
            @error('nama')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            
            <div class="mt-4">
                <input type="reset" value="Reset" class="btn bg-gradient-warning">
                <input type="submit" value="Update" class="btn bg-gradient-success">
            </div>
        </form>
    </div>
    @include('admin.components.footer')
</main>
@endsection