<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index(Kelas $kelas, Tugas $tugas)
    {
        // Pastikan tugas ini benar-benar milik kelas yang dituju
        if ($tugas->kelas_id !== $kelas->id) {
            abort(404);
        }

        $teacherId = Auth::id();
        
        // REVISI LOGIKA AKSES:
        // Izinkan masuk JIKA: Dia adalah pembuat tugas (Guru Mapel) ATAU Dia adalah Wali Kelas dari kelas ini
        if ($tugas->guru_id !== $teacherId && $kelas->guru_id !== $teacherId) {
            abort(403, 'Akses ditolak. Anda bukan pengampu tugas ini maupun Wali Kelas untuk kelas ini.');
        }

        // Ambil semua siswa di kelas tersebut
        $siswaList = $kelas->siswa()->orderBy('nama', 'asc')->get();
        
        // Ambil semua submission untuk tugas ini
        $submissions = $tugas->submissions->keyBy('siswa_id');

        return view('teacher.tugas.submissions', compact('kelas', 'tugas', 'siswaList', 'submissions'));
    }

    public function update(Request $request, Kelas $kelas, Tugas $tugas, TugasSubmission $submission)
    {
        $teacherId = Auth::id();
        
        // REVISI LOGIKA AKSES (Untuk menyimpan nilai):
        // Wali Kelas juga diizinkan memberikan nilai/feedback pembetulan jika dibutuhkan
        if ($tugas->guru_id !== $teacherId && $kelas->guru_id !== $teacherId) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $submission->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Nilai dan umpan balik berhasil disimpan.');
    }
}