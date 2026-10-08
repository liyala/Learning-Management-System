<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Ambil kelas beserta tahun ajaran yang diajar oleh guru ini
        $kelases = Kelas::with('tahunAjaran')
            ->where('guru_id', $teacherId)
            ->orWhereHas('jadwal', function($q) use ($teacherId) {
                $q->where('guru_id', $teacherId);
            })
            ->latest()
            ->get();

        return view('teacher.kelas.index', compact('kelases'));
    }

    public function show($id)
    {
        $teacherId = Auth::id();

        // Pastikan kelas tersebut benar-benar diajar oleh guru yang login
        $kelas = Kelas::with(['tahunAjaran', 'siswa', 'jadwal.mataPelajaran'])
            ->where('id', $id)
            ->where(function($query) use ($teacherId) {
                $query->where('guru_id', $teacherId)
                      ->orWhereHas('jadwal', function($q) use ($teacherId) {
                          $q->where('guru_id', $teacherId);
                      });
            })
            ->firstOrFail();

        // Ambil jadwal khusus untuk guru ini di kelas tersebut
        $jadwalSaya = $kelas->jadwal->where('guru_id', $teacherId);

        return view('teacher.kelas.show', compact('kelas', 'jadwalSaya'));
    }
}