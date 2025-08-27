@extends('admin.layouts.master')

@section('body')
<main class="main-content border-radius-lg ">
    <!-- Navbar -->
    @include('admin.components.navbar')
    <div class="p-4 mx-4" style="min-height: 80vh">
        <p> >> CAPSTONE#1_FS2 / Dashboard / Kategori / Create </p>
        {{-- Start Here --}}
        <h2>Ini adalah halaman create kategori untuk admin</h2>
        <a href="{{route('kategori.index')}}" class="btn bg-gradient-info">Kembali</a>
        <form action="{{route('kategori.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group input-group-outline mb-4">
                <label class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama">
            </div>
            @error('nama')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="mt-4">
                <input type="reset" value="Reset" class="btn bg-gradient-warning">
                <input type="submit" value="Create" class="btn bg-gradient-success">
            </div>
        </form>
    </div>
    @include('admin.components.footer')
</main>
@endsection