<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    
    protected $fillable = [
        'kelas_id', 'mata_pelajaran_id', 'guru_id', 'judul', 'deskripsi', 'file_path'
    ];

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function guru() { return $this->belongsTo(User::class, 'guru_id'); }
}