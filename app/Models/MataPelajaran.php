<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['kode', 'nama', 'deskripsi'];
}

// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// 
// class MataPelajaran extends Model
// {
//    protected $table = 'jadwal_pelajaran';
//     protected $fillable = ['kelas_id', 'mata_pelajaran_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai'];
// }