<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuis')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->decimal('nilai', 5, 2)->nullable();
            $table->dateTime('waktu_mulai_mengerjakan');
            $table->dateTime('waktu_selesai_mengerjakan')->nullable();
            $table->enum('status', ['mengerjakan', 'selesai'])->default('mengerjakan');
            $table->timestamps();
            
            // Mencegah siswa mengerjakan kuis yang sama 2 kali
            $table->unique(['kuis_id', 'siswa_id']);
        });
    }

    public function down(): void { Schema::dropIfExists('kuis_hasil'); }
};