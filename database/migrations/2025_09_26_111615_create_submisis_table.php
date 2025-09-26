<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->string('file_url'); // file tugas yang dikumpulkan
            $table->text('komentar')->nullable(); // komentar tambahan
            $table->boolean('selesai')->default(false); // sudah dinilai atau belum
            $table->integer('nilai')->nullable(); // nilai tugas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_mahasiswa');
    }
};
