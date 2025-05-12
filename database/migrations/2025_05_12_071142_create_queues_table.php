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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();            // kode antrian unik, misalnya: Q-23001
            $table->string('customer_name')->nullable(); // nama pelanggan
            $table->string('no_wa')->nullable();         // nomor WhatsApp
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('diproses'); // status antrian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
