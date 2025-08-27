@extends('admin.layouts.master')

@section('body')
    <main class="main-content border-radius-lg ">
        <!-- Navbar -->
        @include('admin.components.navbar')
        <div class="p-4 mx-4" style="min-height: 80vh">
            <p> >> CAPSTONE#1_FS2 / Dashboard / Kategori</p>
            {{-- Start Here --}}
            <h2>Ini adalah halaman kategori untuk super-admin</h2>
            <a href="{{ route('kategori.create') }}" class="btn bg-gradient-info">tambah</a>
            @if (session('success'))
                <div class="alert alert-success text-white">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger text-white">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0 d-none d-md-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Kategori</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terakhir
                                    Diedit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $item)
                                <tr>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <span class="mx-3 text-xs">{{ $item->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-xs">{{ $item->created_at }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-xs">{{ $item->updated_at }}</span>
                                        </div>
                                    </td>
                                    <td class="d-flex gap-1 justify-content-center">
                                        <form action="{{ route('kategori.edit', $item->id) }}">
                                            <button class="btn bg-gradient-warning">Edit</button>
                                        </form>
                                        <a onclick="confirmDelete(this)"
                                            data-url="{{ route('kategori.destroy', ['id' => $item->id]) }}"
                                            class="btn bg-gradient-danger" role="button">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-3">
                        {{ $kategori->links() }}
                    </div>
                </div>
            </div>

            <div class="d-md-none">
                @foreach ($kategori as $item)
                    <div class="card mb-4 mt-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text">
                                <strong>Dibuat:</strong> {{ $item->created_at }}<br>
                                <strong>Terakhir Diedit:</strong> {{ $item->updated_at }}
                            </p>
                            <div class="d-flex gap-1">
                                <form action="{{ route('kategori.edit', $item->id) }}">
                                    <button class="btn bg-gradient-warning">Edit</button>
                                </form>
                                <a onclick="confirmDelete(this)"
                                    data-url="{{ route('kategori.destroy', ['id' => $item->id]) }}"
                                    class="btn bg-gradient-danger" role="button">Hapus</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="px-3">
                    {{ $kategori->links() }}
                </div>
            </div>

        </div>
        @include('admin.components.footer')
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        confirmDelete = function(button) {
            var url = $(button).data('url');
            swal({
                'title': 'Konfirmasi Hapus',
                'text': 'Apakah Kamu Yakin Ingin Menghapus Data Ini?',
                'dangermode': true,
                'buttons': true
            }).then(function(value) {
                if (value) {
                    window.location = url;
                }
            })
        }
    </script>
@endsection
