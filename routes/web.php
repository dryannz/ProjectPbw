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

// =============================================
// HALAMAN LANDING PAGE (publik)
// =============================================
Route::get('/', function () {
    return view('landing.index');
})->name('home');

// =============================================
// AUTH
// =============================================
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =============================================
// AREA PROTECTED — auth + role
// =============================================
Route::middleware(['auth', 'role'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('petugas',  PetugasController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('barang',   BarangController::class);

    // Purchase Order
    Route::resource('purchaseorder', PurchaseOrderController::class);
    Route::prefix('purchaseorder/{no_order}/detail')
        ->name('purchaseorder.detail.')
        ->group(function () {
            Route::get('/',                [DetailPoController::class, 'index'])->name('index');
            Route::get('/tambah',          [DetailPoController::class, 'create'])->name('create');
            Route::post('/',               [DetailPoController::class, 'store'])->name('store');
            Route::get('/{idbarang}/ubah', [DetailPoController::class, 'edit'])->name('edit');
            Route::put('/{idbarang}',      [DetailPoController::class, 'update'])->name('update');
            Route::delete('/{idbarang}',   [DetailPoController::class, 'destroy'])->name('destroy');
        });

    // Invoice
    Route::get('/invoice',                             [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/tambah',                      [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/tambah',                     [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{no_invoice}/ubah',           [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{no_invoice}',                [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{no_invoice}',             [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/{no_invoice}/detail',         [InvoiceController::class, 'detail'])->name('invoice.detail');
    Route::post('/invoice/{no_invoice}/detail/order',  [InvoiceController::class, 'addOrder'])->name('invoice.detail.addOrder');
    Route::delete('/invoice/{no_invoice}/detail/order',[InvoiceController::class, 'removeOrder'])->name('invoice.detail.removeOrder');
    Route::post('/invoice/{no_invoice}/detail/dpp',    [InvoiceController::class, 'saveDpp'])->name('invoice.detail.saveDpp');
    Route::get('/invoice/{no_invoice}/cetak',          [InvoiceController::class, 'cetak'])->name('invoice.cetak');

    // Surat Jalan
    Route::prefix('suratjalan')->name('suratjalan.')->group(function () {
        Route::get('/',                [SuratJalanController::class, 'index'])->name('index');
        Route::get('/create',          [SuratJalanController::class, 'create'])->name('create');
        Route::post('/',               [SuratJalanController::class, 'store'])->name('store');
        Route::get('/{no_surat}',      [SuratJalanController::class, 'detail'])->name('detail');
        Route::get('/{no_surat}/edit', [SuratJalanController::class, 'edit'])->name('edit');
        Route::put('/{no_surat}',      [SuratJalanController::class, 'update'])->name('update');
        Route::delete('/{no_surat}',   [SuratJalanController::class, 'destroy'])->name('destroy');
        Route::get('/{no_surat}/cetak',[SuratJalanController::class, 'cetak'])->name('cetak');
    });
});