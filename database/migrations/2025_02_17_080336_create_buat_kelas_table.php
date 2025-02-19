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
        Schema::create('buat_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->string('matapelajaran'); // Hapus unique agar bisa ada banyak mata pelajaran
            $table->string('nama_guru'); // Perbaikan dari 'guru' ke 'nama_guru'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buat_kelas');
    }
};
