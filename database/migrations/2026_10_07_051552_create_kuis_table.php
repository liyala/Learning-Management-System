<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->integer('durasi_menit')->default(60); // Lama waktu pengerjaan
            $table->dateTime('waktu_mulai')->nullable(); // Kapan kuis bisa mulai diakses
            $table->dateTime('waktu_selesai')->nullable(); // Batas akhir akses kuis
            $table->enum('status', ['draft', 'published'])->default('draft'); // Draft = belum bisa dilihat siswa
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kuis'); }
};