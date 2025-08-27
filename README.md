
# Panduan Sistem Ulasan Produk

Dokumen ini menjelaskan alur kerja dan panduan teknis untuk fitur-fitur utama pada aplikasi, khususnya yang berkaitan dengan manajemen produk dan ulasan.
UNTUK MEMULAI LARAVEL JANGAN LUPA "npm run dev"

## Daftar Isi
1.  [Alur Kerja Utama](#1-alur-kerja-utama)
    -   [Menambahkan Barang Baru (Sebagai Admin)](#menambahkan-barang-baru-sebagai-admin)
    -   [Menambahkan Komentar (Setelah Membeli)](#menambahkan-komentar-setelah-membeli)
    -   [Menampilkan Ulasan (Untuk Semua Pengunjung)](#menampilkan-ulasan-untuk-semua-pengunjung)
2.  [Panduan Teknis: Fetch Ulasan dengan JavaScript](#2-panduan-teknis-fetch-ulasan-dengan-javascript)
    -   [Langkah 1: Membuat Route API Publik](#langkah-1-membuat-route-api-publik)
    -   [Langkah 2: Membuat Metode Controller untuk JSON](#langkah-2-membuat-metode-controller-untuk-json)
    -   [Langkah 3: Mengambil Data di Frontend (Blade & JS)](#langkah-3-mengambil-data-di-frontend-blade--js)

---

## 1. Alur Kerja Utama

### Menambahkan Barang Baru (Sebagai Admin)
Proses ini dilakukan melalui *form* yang hanya bisa diakses oleh admin untuk menambahkan data produk baru ke dalam tabel `barang`.

1.  **Form**: Admin mengisi detail produk seperti nama, deskripsi, harga, kategori, dan mengunggah gambar.
2.  **Controller**: `BarangController@store` menerima data dari *form*.
3.  **Proses**:
    -   Validasi input.
    -   Menyimpan gambar ke `storage/app/public`.
    -   Membuat *record* baru di tabel `barang` dan `stock`.
4.  **Redirect**: Admin diarahkan kembali ke halaman daftar produk dengan pesan sukses.

### Menambahkan Komentar (Setelah Membeli)
Fitur ini dirancang secara spesifik agar **hanya pengguna yang sudah login dan terverifikasi telah membeli produk tersebut** yang dapat memberikan ulasan.

1.  **Kondisi Awal**: Pengguna mengunjungi halaman detail sebuah produk.
2.  **Pengecekan di Backend/Blade**: Sebelum menampilkan form ulasan, sistem melakukan dua lapis pengecekan penting:
    -   **Pengecekan Login**: Menggunakan `@auth` untuk memastikan ada sesi pengguna yang aktif. Jika tidak, form tidak akan ditampilkan.
    -   **Pengecekan Riwayat Pembelian**: Memanggil metode `userHasPurchased()` pada model `Barang`.
        -   Metode ini akan memeriksa tabel `transaksi` untuk mencari record milik pengguna yang login, dengan status 'selesai', dan yang detailnya mencantumkan produk ini.
        -   Ini dilakukan dengan `@if (Auth::user()->pernahBeli($produk->id))`.
3.  **Tampilan Form**:
    -   **Jika Syarat Terpenuhi**: *Form* untuk menambah ulasan (rating dan komentar) akan ditampilkan.
    -   **Jika Belum Login**: Pengguna akan melihat pesan untuk login.
    -   **Jika Sudah Login Tapi Belum Beli**: Pengguna akan melihat pesan seperti "Anda harus membeli produk ini terlebih dahulu untuk memberikan ulasan."
4.  **Controller**: `UlasanController@store` menerima data dari *form*.
5.  **Proses**:
    -   Validasi input (rating dan komentar wajib diisi).
    -   Membuat *record* baru di tabel `ulasan` dengan `id_barang` dan `id_user` yang sesuai.
6.  **Redirect**: Pengguna diarahkan kembali ke halaman detail produk dengan pesan sukses, dan ulasannya akan langsung terlihat.

### Menampilkan Ulasan (Untuk Semua Pengunjung)
Proses ini dirancang agar cepat dan dapat diakses oleh siapa saja, termasuk tamu yang tidak login.

1.  **JavaScript Fetch API**: Sebuah skrip JavaScript di halaman detail produk berjalan otomatis.
2.  **Request ke API**: Skrip melakukan `fetch` *request* ke *endpoint* publik, contoh: `GET /produk/{id}/ulasan`.
3.  **Controller API**: `UlasanController@getUlasanJson` menerima *request*, mengambil data dari database, dan mengembalikannya sebagai **JSON**.
4.  **Render di Frontend**: JavaScript menerima data JSON, lalu secara dinamis membuat elemen-elemen HTML (kartu ulasan) dan menyisipkannya ke dalam halaman tanpa perlu me-reload.

---

## 2. Panduan Teknis: Fetch Ulasan dengan JavaScript

Ini adalah panduan untuk mengimplementasikan pengambilan data ulasan secara asinkron dari frontend.

### Langkah 1: Membuat Route API Publik
Di file `routes/web.php` atau `routes/api.php`, buat sebuah *route* `GET` yang tidak dilindungi oleh *middleware* otentikasi.

```php
// File: routes/web.php
use App\Http\Controllers\UlasanController;

// Route ini bisa diakses siapa saja untuk mengambil data ulasan dalam format JSON
Route::get('/produk/{id}/ulasan', [UlasanController::class, 'getUlasanJson'])->name('ulasan.json');
```

### Langkah 2: Membuat Metode Controller untuk JSON
Di `UlasanController`, buat metode yang akan merespons *route* di atas.

```php
// File: app/Http/Controllers/UlasanController.php

use App\Models\Barang;
use Illuminate\Http\JsonResponse;

class UlasanController extends Controller
{
    // ... metode lainnya ...

    public function getUlasanJson($id): JsonResponse
    {
        $barang = Barang::findOrFail($id);
        $ulasan = $barang->ulasan()->with('user:id,nama')->latest()->get();
        return response()->json($ulasan);
    }
}
```

### Langkah 3: Mengambil Data di Frontend (Blade & JS)
Di *template* Blade detail produk, siapkan sebuah kontainer HTML dan tambahkan skrip JavaScript untuk melakukan *fetch* dan menampilkan data.

```html
<!-- File: resources/views/page/detail-produk.blade.php -->

<!-- 1. Siapkan kontainer kosong untuk menampung ulasan -->
<h3 class="fw-bold fs-3 mt-4">ULASAN PRODUK</h3>
<div id="ulasan-container" class="row gap-y-4 mt-4">
    <div class="col-12 text-center"><p>Memuat ulasan...</p></div>
</div>

<!-- 2. Tambahkan skrip di section JavaScript Anda -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ulasanContainer = document.getElementById('ulasan-container');
    const produkId = {{ $produk->id }};

    fetch(`/produk/${produkId}/ulasan`)
        .then(response => response.json())
        .then(data => {
            ulasanContainer.innerHTML = ''; // Kosongkan kontainer

            if (data.length === 0) {
                ulasanContainer.innerHTML = '<div class="col-12"><p>Belum ada ulasan untuk produk ini.</p></div>';
                return;
            }

            data.forEach(review => {
                const userName = review.user ? review.user.nama : 'Pengguna Telah Dihapus';
                const reviewCard = `
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">${userName}</h5>
                                <p class="card-text">${review.komentar}</p>
                                <small class="text-muted">${new Date(review.created_at).toLocaleDateString()}</small>
                            </div>
                        </div>
                    </div>
                `;
                ulasanContainer.innerHTML += reviewCard;
            });
        })
        .catch(error => {
            console.error('Gagal mengambil data ulasan:', error);
            ulasanContainer.innerHTML = '<div class="col-12"><p class="text-danger">Terjadi kesalahan saat memuat ulasan.</p></div>';
        });
});
</script>
```
