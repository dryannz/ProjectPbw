<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DetailPoController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SuratJalanController;

// Halaman login
Route::get('/', fn() => view('auth.login'))->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

// Settings
Route::get('/settings', fn() => view('settings'))->name('settings');

// Resource routes (otomatis buat index, create, store, edit, update, destroy)
Route::resource('petugas',       PetugasController::class);
Route::resource('customer',     CustomerController::class);
Route::resource('barang',        BarangController::class);
Route::resource('purchaseorder', PurchaseOrderController::class);
 Route::prefix('purchaseorder/{no_order}/detail')->name('purchaseorder.detail.')->group(function () {
        Route::get('/',                     [DetailPoController::class, 'index'])   ->name('index');
        Route::get('/tambah',               [DetailPoController::class, 'create'])  ->name('create');
        Route::post('/',                    [DetailPoController::class, 'store'])   ->name('store');
        Route::get('/{idbarang}/ubah',      [DetailPoController::class, 'edit'])    ->name('edit');
        Route::put('/{idbarang}',           [DetailPoController::class, 'update'])  ->name('update');
        Route::delete('/{idbarang}',        [DetailPoController::class, 'destroy']) ->name('destroy');
    });
Route::resource('invoice',       InvoiceController::class);
Route::middleware(['auth'])->group(function () {

    // Invoice CRUD
    Route::get('/invoice',                  [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/tambah',           [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/tambah',          [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{no_invoice}/ubah',[InvoiceController::class, 'edit'])->name('invoice.edit');
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
Route::resource('suratjalan',    SuratJalanController::class);