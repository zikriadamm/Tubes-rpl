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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->enum('tipe', ['Standar', 'Deluxe', 'Suite']);
            $table->decimal('harga_per_malam', 12, 2);
            $table->enum('status', ['Tersedia', 'Terisi', 'Perawatan'])->default('Tersedia');
            $table->enum('status_kebersihan', ['Bersih', 'Kotor'])->default('Bersih');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
