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
    Schema::create('detail_po', function (Blueprint $table) {
        $table->id();
        $table->string('no_order');
        $table->string('idbarang');

        // Kolom dari ERD (semua ada di node DETAIL PO)
        $table->decimal('total_pcs', 12, 2)->nullable();
        $table->integer('jml_krg')->nullable();    // jumlah karung
        $table->decimal('pcs_krg', 10, 2)->nullable();  // pcs per karung
        $table->decimal('kg_krg', 10, 2)->nullable();   // kg per karung
        $table->decimal('wrn', 10, 2)->nullable();       // berat
        $table->decimal('total_kg', 12, 2)->nullable();
        $table->decimal('jumlahharga', 15, 2)->nullable();
        $table->timestamps();

        $table->foreign('no_order')
              ->references('no_order')->on('purchase_order')
              ->cascadeOnDelete(); // hapus PO → hapus semua detail-nya
        $table->foreign('idbarang')
              ->references('idbarang')->on('barang')
              ->restrictOnDelete(); // barang tidak bisa dihapus jika masih ada di detail
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_po');
    }
};
