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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->unique()->constrained('pemesanans')->cascadeOnUpdate()->restrictOnDelete();
            $table->dateTime('tanggal_bayar');
            $table->enum('metode_pembayaran', ['Tunai', 'Transfer', 'QRIS']);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->foreignId('penerima_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
