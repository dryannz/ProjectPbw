<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: create_detail_invoice_table
 *
 * Tabel pivot antara invoice dan purchase_order.
 * Jalankan: php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_invoice', function (Blueprint $table) {
            $table->string('no_invoice', 70);
            $table->string('no_order', 70);

            $table->primary(['no_invoice', 'no_order']);

            $table->foreign('no_invoice')
                  ->references('no_invoice')
                  ->on('invoice')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('no_order')
                  ->references('no_order')
                  ->on('purchase_order')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_invoice');
    }
};
