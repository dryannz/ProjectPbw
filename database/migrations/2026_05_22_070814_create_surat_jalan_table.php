<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->string('no_surat')->primary();
            $table->string('no_invoice')->nullable();
            $table->unsignedBigInteger('idpetugas_admin')->nullable();
            $table->unsignedBigInteger('idpetugas_warehouse')->nullable();
            $table->unsignedBigInteger('idpetugas_driver')->nullable();
            $table->date('tgl_surat');
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('idpetugas_admin')->references('idpetugas')->on('petugas')->nullOnDelete();
            $table->foreign('idpetugas_warehouse')->references('idpetugas')->on('petugas')->nullOnDelete();
            $table->foreign('idpetugas_driver')->references('idpetugas')->on('petugas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_jalan');
    }
};
