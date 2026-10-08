<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuis')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->enum('kunci_jawaban', ['a', 'b', 'c', 'd']);
            $table->integer('bobot')->default(1); // Bobot per soal, berguna jika ada soal sulit/mudah
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kuis_soal'); }
};