<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PurchaseOrderController;
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
Route::resource('invoice',       InvoiceController::class);
Route::resource('suratjalan',    SuratJalanController::class);