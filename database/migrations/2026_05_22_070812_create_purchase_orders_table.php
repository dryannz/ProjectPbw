<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->string('no_order', 70)->primary();
            $table->string('idcustomer', 20);
            $table->date('tgl_order');
            $table->date('schedule_delivery');
            $table->timestamps();

            $table->foreign('idcustomer')->references('idcustomer')->on('customer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};
