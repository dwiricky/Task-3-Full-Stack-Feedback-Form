@extends('layouts.page.master')

@section('title', 'Frequently Asked Questions')

@section('css-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection

@section('content')
<div class="container-fluid flex justify-center bg-coklat p-4 text-coklat-gelap">
    <h1 class="fs-1 fw-bold"><i class="bi bi-question-square-fill"></i> Frequently Asked Questions <i class="bi bi-chat-square-text-fill"></i></h1>
</div>
<div class="container-fluid" style="min-height: 65.5vh">
    <div class="row mt-2">
        <div class="col-12 col-lg-6 p-4">
            <h3 class="py-4 fs-3 fw-bolder">Paling Sering Ditanyakan</h3>
            <div class="flex flex-col my-4 gap-y-2">
                <h5 class="fs-5 fw-bold">Jika barang sesuai, apakah bisa melakukan retur dan refund?</h5>
                <p style="text-align: justify" class="text-muted">Tentu bisa, karena kami selalu mengutamakan pembeli sesuai dengan visi misi kami, namun biaya operasional ditanggung pembeli.</p>
            </div>
            <div class="flex flex-col my-4 gap-y-2">
                <h5 class="fs-5 fw-bold">Bagaimana cara mendapatkan diskon promo atau penawaran spesial?</h5>
                <p style="text-align: justify" class="text-muted">Anda dapat memeriksa bagian promo di landingpage untuk informasi terbaru tentang diskon dan promosi produk yang tersedia.</p>
            </div>
            <div class="flex flex-col my-4 gap-y-2">
                <h5 class="fs-5 fw-bold">Bagaimana cara melacak status pengiriman pesanan saya?</h5>
                <p style="text-align: justify" class="text-muted">Anda dapat melacak status pengiriman melalui fitur status di halaman pesanan Anda. Untuk nomor resi terkait produk yang di pesan bisa konfirmasi langsung ke kontak admin sesuai dengan id pesanan Anda.</p>
            </div>
            <div class="flex flex-col my-4 gap-y-2">
                <h5 class="fs-5 fw-bold">Apakah saya bisa membatalkan pesanan setelah pembayaran?</h5>
                <p style="text-align: justify" class="text-muted">Tentu, Anda dapat membatalkan pesanan sebelum proses pengiriman dimulai. Untuk pembatalan, silakan kunjungi halaman pesanan anda dan pilih pesanan yang ingin dibatalkan, atau hubungi admin untuk bantuan.</p>
            </div>
        </div>
        <div class="col-12 col-lg-6 p-4 bg-coklat">
            <form action="mailto:valinellaprojects@gmail.com" method="POST" enctype="multipart/form-data" name="EmailForm">
                <div class="my-4">
                    <label class="fs-3 fw-bolder">Tanya Kebingungan Anda Disini</label>
                    <p style="text-align: justify;" class="">Aksi ini akan membuka mail anda untuk mengirimkan pesan silahkan klik <a href="https://wa.me/6285161214171">disini</a> untuk bertanya melalui whatsapp.</p>
                </div>
                <div class="my-4">
                    <input type="text" name="Contact-Name" id="nama" class="form-control" placeholder="Nama Kamu">
                </div>
                <div class="my-4">
                    <input type="email" name="Contact-Email" id="email" class="form-control" placeholder="Email Kamu">
                </div>
                <div class="my-4">
                    <input type="text" name="Contact-Subject" id="topik" class="form-control" placeholder="Topik">
                </div>
                <div class="my-4">
                    <textarea name="Contact-Message" id="keterangan" class="form-control" cols="30" rows="10" placeholder="Pertanyaan Kamu?"></textarea>
                </div>
                <div class="my-4">
                    <input onclick="openMailClient()" type="submit" value="Kirim" class="btn btn-coklat-gelap">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer', true)