@extends('layouts.page.master')

@section('title', 'Keranjang Saya')
@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/page/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">
@endsection

@section('content')
    @php
        $pajak = $total * 0.1; // Menghitung pajak 10%
        $totalPajak = $total + $pajak; // Menambahkan pajak ke total belanja
    @endphp
    <div class="container-fluid p-5 bg-coklat text-coklat-gelap">
        <h1 class="fs-1 fw-bold"><i class="bi bi-cart"></i> Keranjang Belanja Saya</h1>
    </div>
    <div class="container" id="session">
        @if (session('success'))
            <div class="bg-coklat text-coklat-gelap fs-3 p-2 px-4 rounded mt-1 d-flex justify-content-between">
                {{ session('success') }}
                <a id="hideSession"><i class="bi bi-x"></i></a>
            </div>
        @endif
    </div>
    <div class="container" style="min-height: 65.5vh">
        <div class="row">
            <div class="col-12 col-lg-6 p-4">
                <div class="d-flex justify-content-between py-4">
                    <div class="text-center w-100 fw-bold fs-4">
                        Produk
                    </div>
                    <div class="text-center w-100 fw-bold fs-4">
                        Harga
                    </div>
                    <div class="text-center w-100 fw-bold fs-4">
                        Jumlah
                    </div>
                    <div class="text-center w-100 fw-bold fs-4">
                        Total
                    </div>
                    <div class="text-center w-100 fw-bold fs-4">
                        Aksi
                    </div>
                    <div class="my-4" id="success-message"></div>
                </div>
                @php $total = 0 @endphp
                @if (session('cart'))
                    @foreach (session('cart') as $id => $details)
                        @php $total += $details['harga'] * $details['quantity'] @endphp
                        <div class="d-flex justify-content-between align-items-center py-2" data-id="{{ $id }}">
                            <div class="w-100">
                                <img src="{{ asset('storage/' . $details['gambar']) }}" class="img-fluid product-image"
                                    alt="Gambar Produk">
                            </div>
                            {{-- harga --}}
                            <div class="text-center w-100">
                                Rp. {{ number_format($details['harga'], 0, ',', '.') }}
                            </div>
                            {{-- quan --}}
                            <div class="text-center w-100">
                                <input type="number" value="{{ $details['quantity'] }}" min="1"
                                    class="form-control quantity update-cart" data-id="{{ $id }}" />
                            </div>
                            {{-- harga*quan --}}
                            <div class="text-center w-100 subtotal" id="subtotal_{{ $id }}">
                                Rp. {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}
                            </div>
                            <div class="text-center w-100">
                                <form action="{{ route('remove.from.cart', $id) }}" method="POST"
                                    class="remove-from-cart">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
                <hr class="border-2">
                <div class="d-flex justify-content-between w-100 py-4">
                    <a onclick="history.back()" class="btn btn-coklat-gelap mb-3">Kembali</a>
                </div>
            </div>

            <div class="col-12 col-lg-6 p-4">
                <div class="bg-light p-4 my-4">
                    <div class="my-4 text-center">
                        <label class="fs-3 fw-bolder">Cart Totals</label>
                    </div>
                    <div class="my-4">
                        <div class="d-flex justify-content-between my-4">
                            <h2>Subtotal : </h2>
                            <h2 id="subtotal-display">Rp. {{ number_format($total, 0, ',', '.') }}</h2>
                        </div>
                        <hr>
                    </div>
                    <div class="my-4">
                        <div class="d-flex justify-content-between my-4">
                            <h2>Total : </h2>
                            <h2 id="total-display">Rp. {{ number_format($totalPajak, 0, ',', '.') }}</h2>
                        </div>
                        <hr>
                    </div>
                    <div class="my-4">
                        <p class="text-coklat-gelap">* Sudah termasuk pajak 10% dan Pengurangan promo bila ada</p>
                    </div>
                    <div class="my-4 w-100">
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" id="total" name="total" value="{{ $totalPajak }}">
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $details)
                                    <input type="hidden" name="products[{{ $id }}][id_barang]"
                                        value="{{ $details['id_barang'] }}">
                                    <input type="hidden" name="products[{{ $id }}][nama]"
                                        value="{{ $details['nama'] }}">
                                    <input type="hidden" name="products[{{ $id }}][harga]"
                                        value="{{ $details['harga'] }}">
                                    <input type="hidden" name="products[{{ $id }}][quantity]"
                                        value="{{ $details['quantity'] }}">
                                @endforeach
                            @endif

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pembeli:</label>
                                <input type="text" class="form-control border rounded" name="nama" id="nama"
                                    @if (session('cart') == null) disabled placeholder="Tidak dapat mengisi form, keranjang anda kosong" @endif
                                    value="{{ Auth::user()->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat:</label>
                                <textarea class="form-control border rounded" name="alamat" id="alamat" rows="3"
                                    @if (session('cart') == null) disabled placeholder="Tidak dapat mengisi form, keranjang anda kosong" @endif
                                    required>{{ Auth::user()->alamat }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label">Nomor HP:</label>
                                <input type="text" class="form-control border rounded" name="nomor_hp" id="nomor_hp"
                                    @if (session('cart') == null) disabled placeholder="Tidak dapat mengisi form, keranjang anda kosong" @endif
                                    value="{{ Auth::user()->nomor_hp }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="pengiriman" class="form-label">Pengiriman:</label>
                                <select class="form-select border rounded @error('pengiriman') is-invalid @enderror"
                                    name="pengiriman" id="pengiriman" @if (session('cart') == null) disabled @endif
                                    required>
                                    <option selected disabled hidden>Pilih Pengiriman</option>
                                    <option value="ninja-express">Ninja Express</option>
                                    <option value="jnt-cargo">JNT Cargo</option>
                                    <option value="jne-cargo">JNE Cargo</option>
                                </select>
                                @error('pengiriman')
                                    <div class="alert bg-danger text-white mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-coklat-gelap text-white w-100"
                                @if (session('cart') == null) disabled @endif>Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer', true)
@section('js-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            document.getElementById('hideSession').addEventListener('click', function() {
                document.getElementById('session').style.display = 'none';
            });
        });

        $(document).on('input', '.update-cart', function(e) {
            e.preventDefault();

            var ele = $(this);
            var quantity = ele.val();
            var id = ele.closest("div[data-id]").data("id");

            if (quantity === '' || quantity <= 0) {
                return; // Jika quantity kosong atau nol, tidak mengirim permintaan AJAX
            }

            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: quantity
                },
                success: function(response) {
                    // Update subtotal
                    $('#subtotal_' + id).text("Rp. " + response.subtotal);

                    // Update total
                    $('#cart-total').text("Rp. " + response.total);

                    // Update total di bagian summary
                    $('#subtotal-display').text("Rp. " + response.total);
                    $('#total-display').text("Rp. " + response.totalPajak);

                    // Update nilai quantity dan total secara langsung
                    $('input[name="products[' + id + '][quantity]"]').val(quantity);
                    $('#total').val(response.totalPajak);
                }
            });
        })

        $(".remove-from-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);
            var id = ele.closest("div[data-id]").data("id");
            var quantity = $(".quantity").val();

            if (confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        quantity: quantity
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        })
    </script>
@endsection
