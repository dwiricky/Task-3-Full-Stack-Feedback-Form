@extends('admin.layouts.master')

@section('body')
<main class="main-content border-radius-lg">
    <!-- Navbar -->
    @include('admin.components.navbar')
    <div class="p-4 mx-4" style="min-height: 80vh">
        <p> >> CAPSTONE#1_FS2 / Dashboard / Transaksi</p>
        {{-- Start Here --}}
        <h2>Ini adalah halaman Transaksi untuk Admin</h2>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
        <div class="card">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Transaksi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Produk</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pembeli</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor HP</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>

                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detail Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formattedTransaksis as $index => $formattedTransaksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $formattedTransaksi['id_transaksi'] }}</td>
                                <td>{{ $formattedTransaksi['nama_produk'] }}</td>
                                <td>{{ $formattedTransaksi['nama_pembeli'] }}</td>
                                <td>{{ $formattedTransaksi['nomor_hp'] }}</td>
                                <td>{{ $formattedTransaksi['alamat'] }}</td>
                                <td>{{ $formattedTransaksi['status'] }}</td>
                                <td>
                                <a href="{{ route('transaksi.detail', $formattedTransaksi['id_transaksi']) }}" class="btn bg-gradient-info">Detail Order</a>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.components.footer')
</main>
@endsection
