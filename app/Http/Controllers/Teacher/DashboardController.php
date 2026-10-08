<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Cari kelas di mana guru menjadi wali kelas ATAU ada di jadwal pelajaran kelas tersebut
        $kelasIds = Kelas::where('guru_id', $teacherId)
            ->orWhereHas('jadwal', function($q) use ($teacherId) {
                $q->where('guru_id', $teacherId);
            })->pluck('id');

        $totalKelas = $kelasIds->count();

        // Hitung total siswa unik dari kelas-kelas tersebut
        $totalSiswa = DB::table('kelas_siswa')
            ->whereIn('kelas_id', $kelasIds)
            ->distinct('siswa_id')
            ->count();

        // Dummy untuk tugas (akan dihubungkan nanti)
        $tugasAktif = 0; 

        return view('teacher.dashboard', compact('totalKelas', 'totalSiswa', 'tugasAktif'));
    }
}