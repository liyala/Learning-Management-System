<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    protected $fillable = [
        'tahun_ajaran_id',
        'guru_id',
        'nama_kelas',
        'deskripsi',
        'status',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'kelas_siswa', 'kelas_id', 'siswa_id')
        ->withPivot('joined_at');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalPelajaran::class, 'kelas_id');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'kelas_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'kelas_id')->latest();
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'kelas_id');
    }

    
}