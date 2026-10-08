<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('joined_at')->useCurrent();
            
            // Mencegah 1 siswa masuk ke kelas yang sama lebih dari 1 kali
            $table->unique(['kelas_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_siswa');
    }
};