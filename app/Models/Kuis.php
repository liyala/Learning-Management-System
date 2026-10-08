<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';
    protected $fillable = ['kelas_id', 'mata_pelajaran_id', 'guru_id', 'judul', 'deskripsi', 'durasi_menit', 'waktu_mulai', 'waktu_selesai', 'status'];

    protected function casts(): array {
        return ['waktu_mulai' => 'datetime', 'waktu_selesai' => 'datetime'];
    }
    
    public function hasil()
    {
        return $this->hasMany(KuisHasil::class, 'kuis_id');
    }

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function soal() { return $this->hasMany(KuisSoal::class, 'kuis_id'); }
}