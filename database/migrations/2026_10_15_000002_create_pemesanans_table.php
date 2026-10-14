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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->foreignId('tamu_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('kamar_id')->constrained('kamars')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('tanggal_check_in');
            $table->date('tanggal_check_out');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['Dipesan', 'Check-in', 'Check-out', 'Dibatalkan'])->default('Dipesan');
            $table->foreignId('pembuat_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
