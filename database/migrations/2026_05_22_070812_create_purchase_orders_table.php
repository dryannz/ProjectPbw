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
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->string('no_order')->primary();
            $table->date('tgl_order')->nullable();
            $table->date('schedule_delivery')->nullable();
            $table->string('idcustomer')->nullable();
            $table->timestamps();

            $table->foreign('idcustomer')
                ->references('idcustomer')->on('customer')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_po');
        Schema::dropIfExists('purchase_orders');
    }
};
