<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\DataController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ViewController::class, 'index'])->name('home');
Route::get('/detail-promo/{id}', [ViewController::class, 'detailPromo'])->name('detail-promo');
Route::get('/promo', [ViewController::class, 'promo'])->name('list-promo');
Route::get('/detail-produk/{id}', [ViewController::class, 'detailProduk'])->name('detail-produk');
Route::get('/list-produk', [ViewController::class, 'listProduk'])->name('list-produk');
route::get('/faq', [ViewController::class, 'faq'])->name('faq');
route::get('/about-us', [ViewController::class, 'aboutUs'])->name('about-us');
Route::get('/products-by-category', [BarangController::class, 'getProductsByCategory']);
Route::get('/produk/{id}/ulasan', [UlasanController::class, 'getUlasanJson'])->name('ulasan.json');

Route::middleware('is_guest')->group(function() {
    route::get('/order-complete', [ViewController::class, 'orderComplete'])->name('order-complete');
    route::get('/data-pribadi', [ViewController::class, 'dataPribadi'])->name('data-pribadi');
    route::get('/order-status', [ViewController::class, 'orderStatus'])->name('order-status');
    Route::get('/order-detail/{id}', [ViewController::class, 'orderDetail'])->name('order-detail');
    Route::get('/order-detail/{orderId}', [ViewController::class, 'showOrderDetail'])->name('order.detail');
    Route::get('/order/done/{id}', [ViewController::class, 'doneOrder'])->name('order.done');
    Route::get('/order/cancel/{id}', [ViewController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/ulasan/{barang_id}', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::post('/update-data/{id}', [DataController::class, 'updateData'])->name('update-data');

    Route::get('cart', [ViewController::class, 'cart'])->name('cart');
    Route::get('add-to-cart/{id}', [ViewController::class, 'addToCart'])->name('add.to.cart');
    Route::patch('update-cart', [ViewController::class, 'update'])->name('update.cart');
    Route::delete('remove-from-cart', [ViewController::class, 'remove'])->name('remove.from.cart');
    Route::post('checkout', [ViewController::class, 'checkout'])->name('checkout');
    Route::delete('clear-cart', [ViewController::class, 'clearCart'])->name('clear.cart');
});

Route::middleware('is_admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/dashboard/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/dashboard/barang/create', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/dashboard/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/dashboard/barang/edit/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/dashboard/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/dashboard/promo', [PromoController::class, 'index'])->name('promo.index');
    Route::get('/dashboard/promo/create', [PromoController::class, 'create'])->name('promo.create');
    Route::post('/dashboard/promo/create', [PromoController::class, 'store'])->name('promo.store');
    Route::get('/dashboard/promo/{id}/edit', [PromoController::class, 'edit'])->name('promo.edit');
    Route::put('/dashboard/promo/{id}/update', [PromoController::class, 'update'])->name('promo.update');
    Route::get('/dashboard/promo/{id}/destroy', [PromoController::class, 'destroy'])->name('promo.destroy');
});

Route::middleware('is_superadmin')->group(function () {
    Route::get('/dashboard/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/dashboard/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/dashboard/kategori/create', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/dashboard/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::post('/dashboard/kategori/edit/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::get('/dashboard/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/dashboard/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/dashboard/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.detail');
    Route::get('/dashboard/transaksi/detail/{id}', [TransaksiController::class, 'detail'])->name('admin.transaksi.detail_transaksi');
    Route::put('/dashboard/transaksi/proses/{id}', [TransaksiController::class, 'proses'])->name('transaksi.proses');
});
Route::get('/check-cart-session', function () {
    dd(session()->get('cart'));
});
require __DIR__ . '/auth.php';
