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
        Schema::create('invoice', function (Blueprint $table) {
            $table->string('no_invoice')->primary();
            $table->date('tgl')->nullable();
            $table->string('no_order')->nullable();
            $table->string('idpetugas_admin')->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->decimal('DPP', 15, 2)->nullable();
            $table->decimal('PPN', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('no_order')
                ->references('no_order')->on('purchase_order')
                ->nullOnDelete();
           
            $table->foreign('idpetugas_admin')
                ->references('idpetugas')->on('petugas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
