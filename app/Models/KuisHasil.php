<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuisHasil extends Model
{
    protected $table = 'kuis_hasil';
    protected $fillable = ['kuis_id', 'siswa_id', 'nilai', 'waktu_mulai_mengerjakan', 'waktu_selesai_mengerjakan', 'status'];

    protected function casts(): array {
        return [
            'waktu_mulai_mengerjakan' => 'datetime',
            'waktu_selesai_mengerjakan' => 'datetime'
        ];
    }
}