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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim')->nullable()->unique(); 
            $table->string('nama');
            $table->string('prodi')->nullable();
            $table->string('diploma')->nullable();       // d1, d2, d3
            $table->year('tahun_masuk')->nullable();     // tahun masuk
            $table->integer('nomor_prodi')->nullable();
            $table->string('kelas')->nullable();
              // nomor/id prodi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
