<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini menggantikan tabel 'users' default Laravel
 * dengan tabel 'petugas' sesuai skema aplikasi PT Yoko Fastener.
 * 
 * Jalankan: php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        // Tabel Petugas (digunakan sebagai users/auth)
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('idpetugas');
            $table->string('name');
            $table->string('jabatan')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Customer
        Schema::create('customer', function (Blueprint $table) {
            $table->id('idcustomer');
            $table->string('kepada_yth');
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->timestamps();
        });

        // Tabel Barang
        Schema::create('barang', function (Blueprint $table) {
            $table->id('idbarang');
            $table->string('nama_barang');
            $table->string('satuan')->nullable();
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->timestamps();
        });

        // Tabel Purchase Order
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->string('no_order')->primary();
            $table->foreignId('idcustomer')->constrained('customer', 'idcustomer');
            $table->date('tgl_order');
            $table->date('schedule_delivery')->nullable();
            $table->timestamps();
        });

        // Tabel Detail PO
        Schema::create('detail_po', function (Blueprint $table) {
            $table->id();
            $table->string('no_order');
            $table->foreign('no_order')->references('no_order')->on('purchase_order');
            $table->foreignId('idbarang')->constrained('barang', 'idbarang');
            $table->integer('jumlah')->default(0);
            $table->decimal('jumlah_harga', 15, 2)->default(0);
            $table->timestamps();
        });

        // Tabel Invoice
        Schema::create('invoice', function (Blueprint $table) {
            $table->string('no_invoice')->primary();
            $table->date('tgl_invoice');
            $table->timestamps();
        });

        // Tabel Detail Invoice
        Schema::create('detail_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->foreign('no_invoice')->references('no_invoice')->on('invoice');
            $table->string('no_order');
            $table->foreign('no_order')->references('no_order')->on('purchase_order');
            $table->timestamps();
        });

        // Tabel Surat Jalan
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->string('no_surat')->primary();
            $table->date('tgl_surat');
            $table->string('no_invoice')->nullable();
            $table->timestamps();
        });

        // Tabel Detail Surat Jalan
        Schema::create('detail_surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat');
            $table->foreign('no_surat')->references('no_surat')->on('surat_jalan');
            $table->string('no_invoice');
            $table->foreign('no_invoice')->references('no_invoice')->on('invoice');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_surat_jalan');
        Schema::dropIfExists('surat_jalan');
        Schema::dropIfExists('detail_invoice');
        Schema::dropIfExists('invoice');
        Schema::dropIfExists('detail_po');
        Schema::dropIfExists('purchase_order');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('petugas');
    }
};
