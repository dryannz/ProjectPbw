<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->string('no_surat')->primary();
            $table->date('tgl_surat')->nullable();
            $table->string('no_order')->nullable();
            $table->string('idpetugas_admin')->nullable();     // membuat
            $table->string('idpetugas_driver')->nullable();    // mengirim
            $table->string('idpetugas_warehouse')->nullable(); // mengecek
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('no_order')
                ->references('no_order')->on('purchase_order')
                ->nullOnDelete();
            $table->foreign('idpetugas_admin')
                ->references('idpetugas')->on('petugas')
                ->nullOnDelete();
            $table->foreign('idpetugas_driver')
                ->references('idpetugas')->on('petugas')
                ->nullOnDelete();
            $table->foreign('idpetugas_warehouse')
                ->references('idpetugas')->on('petugas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan');
    }
};
