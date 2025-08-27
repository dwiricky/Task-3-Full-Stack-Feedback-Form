@extends('admin.layouts.master')

@section('body')
<main class="main-content border-radius-lg ">
    <!-- Navbar -->
    @include('admin.components.navbar')
    <div class="p-4 mx-4" style="min-height: 80vh">
        <p> >> CAPSTONE#1_FS2 / Dashboard / Barang / Create </p>
        {{-- Start Here --}}
        <h2>Ini adalah halaman create barang untuk admin</h2>
        <a href="{{route('barang.index')}}" class="btn bg-gradient-info">Kembali</a>
        <form action="{{route('barang.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <img src="" id="pre-img" width="250px" class="img-fluid border rounded bg-secondary">
            <div class="input-group input-group-outline my-3">
                <input type="file" name="gambar" id="upGambar" class="form-control">
            </div>
            @error('gambar')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-outline mb-4">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama">
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
                  @foreach ($kategori as $item)
                      <option value="{{$item->id}}">{{$item->nama}}</option>
                  @endforeach
                </select>
            </div>
            @error('kategori')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-outline mb-4">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror">
            </div>
            @error('harga')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <div class="input-group input-group-outline mb-4">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror">
            </div>
            @error('stock')
                <div class="alert alert-danger text-white mt-2">
                    {{$message}}
                </div>
            @enderror
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="30" rows="10" placeholder="Deskripsi"></textarea>
            @error('deskripsi')
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