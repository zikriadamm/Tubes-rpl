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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->enum('peran', ['Resepsionis', 'Manajer', 'Petugas Kebersihan', 'Tamu'])->default('Tamu');
            $table->boolean('aktif')->default(true);
            $table->string('no_hp')->nullable();
            $table->string('no_identitas')->unique();
            $table->text('alamat')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
