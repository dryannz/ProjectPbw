<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_po', function (Blueprint $table) {
            $table->string('no_order', 70);
            $table->string('idbarang', 20);
            $table->char('wrn', 1)->nullable();
            $table->integer('pcs_krg')->default(0);
            $table->integer('jmlh_krg')->default(0);
            $table->integer('total_pcs')->default(0);
            $table->integer('kg_krg')->default(0);
            $table->integer('total_kg')->default(0);
            $table->decimal('jumlah_harga', 10, 0)->default(0);
            $table->timestamps();

            $table->primary(['no_order', 'idbarang']);
            $table->foreign('no_order')->references('no_order')->on('purchase_order')->onDelete('cascade');
            $table->foreign('idbarang')->references('idbarang')->on('barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_po');
    }
};
