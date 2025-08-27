@extends('admin.layouts.master')

@section('body')
<main class="main-content border-radius-lg ">
    <!-- Navbar -->
    @include('admin.components.navbar')
    <div class="p-4 mx-4" style="min-height: 80vh">
        <p> >> CAPSTONE#1_FS2 / Dashboard / Barang / Edit </p>
        {{-- Start Here --}}
        <h2>Ini adalah halaman edit barang untuk admin</h2>
        <a href="{{route('barang.index')}}" class="btn bg-gradient-info">Kembali</a>
        <form action="{{route('barang.update', $selected_barang->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Return 404 Error --}}
            <img src="{{ asset('storage/'.$selected_barang->gambar)}}" id="pre-img" alt="" width="250px" class="img-fluid border rounded bg-secondary">
            {{-- @if ($selected_barang != null)
                <div id="no-image" class="text-center">
                    <small>No image available</small>
                </div>
            @else
                <img src="{{ asset('storage/'.$selected_barang->gambar)}}" id="pre-img" alt="" width="250px" class="img-fluid border rounded bg-secondary">
            @endif --}}
            <div class="input-group input-group-outline my-3">
                <input type="file" name="gambar" id="upGambar" class="form-control">
            </div>
            @error('gambar')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-dynamic mb-4">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{$selected_barang->nama}}" placeholder="Nama Barang" name="nama">
            </div>
            @error('nama')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-static mb-4">
                <label for="exampleFormControlSelect1" class="ms-0">Kategori</label>
                <select class="form-control" name="id_kategori" id="exampleFormControlSelect1">
                    <option value="" hidden></option>
                    @foreach ($kategori as $key => $value)
                        <option value="{{ $value->id }}"
                        @if ($key == old('id_kategori', $selected_barang->kategori))
                            selected="selected"
                        @endif
                        >{{ $value->nama }}</option>
                    @endforeach
                </select>
            </div>
            @error('kategori')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-dynamic mb-4">
                <input type="text" class="form-control @error('harga') is-invalid @enderror" value="{{$selected_barang->harga}}" placeholder="Harga Barang" name="harga">
            </div>
            @error('harga')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-outline mb-4">
                <input type="number" name="stock" value="{{$selected_barang->Stock->stock}}" class="form-control @error('stock') is-invalid @enderror">
            </div>
            @error('stock')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <textarea name="deskripsi" id="textarea-deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="30" rows="10" placeholder="Deskripsi">{{$selected_barang->deskripsi}}</textarea>
            @error('deskripsi')
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    CKEDITOR.replace('deskripsi');
    $(document).ready(() => {
            const photoInp = $("#upGambar");
            let file;
 
            photoInp.change(function (e) {
                file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $("#pre-img")
                            .attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
</script>
@endsection