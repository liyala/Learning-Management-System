<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    
    protected $fillable = [
        'kelas_id', 'mata_pelajaran_id', 'guru_id', 'judul', 'deskripsi', 'file_pendukung', 'deadline'
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }
    
    public function submissions()
    {
        return $this->hasMany(TugasSubmission::class, 'tugas_id');
    }

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function guru() { return $this->belongsTo(User::class, 'guru_id'); }
}