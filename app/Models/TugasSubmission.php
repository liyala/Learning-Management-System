<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasSubmission extends Model
{
    protected $table = 'tugas_submission';
    
    protected $fillable = [
        'tugas_id', 'siswa_id', 'file_jawaban', 'catatan_siswa', 'nilai', 'feedback'
    ];

    public function tugas() { return $this->belongsTo(Tugas::class); }
    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
}