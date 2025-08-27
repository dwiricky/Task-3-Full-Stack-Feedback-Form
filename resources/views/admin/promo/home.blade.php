@extends('admin.layouts.master')

@section('body')
    <main class="main-content border-radius-lg ">
        <!-- Navbar -->
        @include('admin.components.navbar')
        <div class="p-4 mx-4" style="min-height: 80vh">
            <p> >> CAPSTONE#1_FS2 / Dashboard / Promo</p>
            {{-- Start Here --}}
            <h2>Ini adalah halaman promo untuk Admin</h2>
            <a href="{{ route('promo.create') }}" class="btn bg-gradient-info">tambah</a>

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
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Promo
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Barang Promo
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengurangan
                                    Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promo as $item)
                                <tr>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <span class="mx-3 text-xs">{{ $item->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start">
                                        <div class="d-flex align-items-center"
                                            style="word-break: break-word; white-space: normal;">
                                            <span
                                                class="mx-3 text-xs">{{ $item->promoBarang->pluck('nama')->implode(' | ') }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <span class="mx-3 text-xs">{{ $item->deskripsi }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <span class="mx-3 text-xs">{{ $item->pengurangan_harga }}</span>
                                        </div>
                                    </td>
                                    <td class="d-flex gap-1 justify-content-center">
                                        <form action="{{ route('promo.edit', $item->id) }}" method="GET">
                                            <button type="submit" class="btn bg-gradient-warning">Edit</button>
                                        </form>
                                        <a onclick="confirmDelete(this)" data-url="{{ route('promo.destroy', $item->id) }}"
                                            class="btn bg-gradient-danger" role="button">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-3">
                        {{ $promo->links() }}
                    </div>
                </div>
            </div>

            <div class="d-md-none">
                @forelse ($promo as $item)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text">
                                <strong>Barang Promo:</strong>
                                {{ $item->promoBarang->pluck('nama')->implode(' | ') }}<br>
                                <strong>Deskripsi:</strong> {{ $item->deskripsi }}<br>
                                <strong>Pengurangan Harga:</strong> {{ $item->pengurangan_harga }}
                            </p>
                            <div class="d-flex gap-1">
                                <form action="{{ route('promo.edit', $item->id) }}" method="GET">
                                    <button type="submit" class="btn bg-gradient-warning">Edit</button>
                                </form>
                                <a onclick="confirmDelete(this)" data-url="{{ route('promo.destroy', $item->id) }}"
                                    class="btn bg-gradient-danger" role="button">Hapus</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card-body text-center">
                        <p class="card-text">Data Kosong</p>
                    </div>
                @endforelse
                <div class="px-3">
                    {{ $promo->links() }}
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
