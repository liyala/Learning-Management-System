<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    
    protected $fillable = ['kelas_id', 'user_id', 'isi'];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}