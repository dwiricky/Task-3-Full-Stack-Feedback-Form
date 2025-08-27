@extends('admin.layouts.master')

@section('body')
    <main class="main-content border-radius-lg ">
        <!-- Navbar -->
        @include('admin.components.navbar')
        <div class="p-4 mx-4" style="min-height: 80vh">
            <p> >> CAPSTONE#1_FS2 / Dashboard / Promo / Create </p>
            {{-- Start Here --}}
            <h2>Ini adalah halaman create promo untuk admin</h2>
            <a href="{{ route('promo.index') }}" class="btn bg-gradient-info">Kembali</a>
            <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Nama Promo</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama">
                </div>
                @error('nama')
                    <div class="alert alert-danger text-white mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <div class="input-group-static mb-4">
                    <label class="form-label">Barang</label>
                    <div class="row">
                        @foreach ($barang as $item)
                            <div class="col-6 col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" name="id_barang[]" value="{{ $item->id }}"
                                        class="form-check-input @error('id_barang') is-invalid @enderror">
                                    <label class="form-check-label">
                                        {{ $item->nama }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('id_barang')
                        <div class="alert alert-danger text-white mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    @if ($errors->has('id_barang.*'))
                        @foreach ($errors->get('id_barang.*') as $messages)
                            @foreach ($messages as $message)
                                <div class="alert alert-danger text-white mt-2">
                                    {{ $message }}
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>



                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Pengurangan Harga</label>
                    <input type="number" class="form-control @error('pengurangan_harga') is-invalid @enderror"
                        name="pengurangan_harga">
                </div>
                @error('pengurangan_harga')
                    <div class="alert alert-danger text-white mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                        name="deskripsi"></input>
                </div>
                @error('deskripsi')
                    <div class="alert alert-danger text-white mt-2">
                        {{ $message }}
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
