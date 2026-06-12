<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DetailPoController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman login
Route::middleware('guest')->group(function () {
    Route::get('/',       [AuthController::class, 'showForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('petugas',  \App\Http\Controllers\PetugasController::class);
    Route::resource('customer', \App\Http\Controllers\CustomerController::class);
    Route::resource('barang',   \App\Http\Controllers\BarangController::class);

    // Data Transaksional
    Route::resource('purchase-order', \App\Http\Controllers\PurchaseOrderController::class);
    Route::resource('invoice',        \App\Http\Controllers\InvoiceController::class);
    Route::resource('surat-jalan',    \App\Http\Controllers\SuratJalanController::class);
});

// Resource routes (otomatis buat index, create, store, edit, update, destroy)
Route::resource('petugas',       PetugasController::class);
Route::resource('customer',     CustomerController::class);
Route::resource('barang',        BarangController::class);
Route::resource('purchaseorder', PurchaseOrderController::class);
Route::prefix('purchaseorder/{no_order}/detail')->name('purchaseorder.detail.')->group(function () {
    Route::get('/',                     [DetailPoController::class, 'index'])->name('index');
    Route::get('/tambah',               [DetailPoController::class, 'create'])->name('create');
    Route::post('/',                    [DetailPoController::class, 'store'])->name('store');
    Route::get('/{idbarang}/ubah',      [DetailPoController::class, 'edit'])->name('edit');
    Route::put('/{idbarang}',           [DetailPoController::class, 'update'])->name('update');
    Route::delete('/{idbarang}',        [DetailPoController::class, 'destroy'])->name('destroy');
});
Route::resource('invoice',       InvoiceController::class);
Route::middleware(['auth'])->group(function () {

    // Invoice CRUD
    Route::get('/invoice',                  [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/tambah',           [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/tambah',          [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{no_invoice}/ubah', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{no_invoice}',     [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{no_invoice}',  [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    // Invoice Detail (manage linked orders, DPP, PPN)
    Route::get('/invoice/{no_invoice}/detail',          [InvoiceController::class, 'detail'])->name('invoice.detail');
    Route::post('/invoice/{no_invoice}/detail/order',   [InvoiceController::class, 'addOrder'])->name('invoice.detail.addOrder');
    Route::delete('/invoice/{no_invoice}/detail/order', [InvoiceController::class, 'removeOrder'])->name('invoice.detail.removeOrder');
    Route::post('/invoice/{no_invoice}/detail/dpp',     [InvoiceController::class, 'saveDpp'])->name('invoice.detail.saveDpp');

    // Invoice Print
    Route::get('/invoice/{no_invoice}/cetak', [InvoiceController::class, 'cetak'])->name('invoice.cetak');
});
Route::middleware(['auth'])->prefix('suratjalan')->name('suratjalan.')->group(function () {

    Route::get('/',          [SuratJalanController::class, 'index'])->name('index');
    Route::get('/create',    [SuratJalanController::class, 'create'])->name('create');
    Route::post('/',         [SuratJalanController::class, 'store'])->name('store');
    Route::get('/{no_surat}',        [SuratJalanController::class, 'detail'])->name('detail');
    Route::get('/{no_surat}/edit',   [SuratJalanController::class, 'edit'])->name('edit');
    Route::put('/{no_surat}',        [SuratJalanController::class, 'update'])->name('update');
    Route::delete('/{no_surat}',     [SuratJalanController::class, 'destroy'])->name('destroy');
    Route::get('/{no_surat}/cetak',  [SuratJalanController::class, 'cetak'])->name('cetak');
});
