<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $kelases = Auth::user()->kelas()->with('tahunAjaran', 'guru')->latest()->get();
        return view('student.kelas.index', compact('kelases'));
    }

    public function show(Kelas $kelas)
    {
        // Keamanan: Pastikan siswa benar-benar terdaftar di kelas ini
        if (!$kelas->siswa()->where('siswa_id', Auth::id())->exists()) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        // Ambil data lengkap kelas (Materi, Tugas, Jadwal, Teman sekelas)
        $kelas->load(['materi.mataPelajaran', 'tugas.mataPelajaran', 'jadwal.mataPelajaran', 'siswa']);
        
        $jadwalSaya = $kelas->jadwal()->orderBy('jam_mulai')->get()->groupBy('hari');

        return view('student.kelas.show', compact('kelas', 'jadwalSaya'));
    }
}