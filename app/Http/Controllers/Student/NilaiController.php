<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TugasSubmission;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $siswaId = Auth::id();

        // 1. Ambil semua riwayat pengumpulan tugas siswa ini beserta relasinya
        $submissions = TugasSubmission::with(['tugas.mataPelajaran', 'tugas.kelas.tahunAjaran'])
            ->where('siswa_id', $siswaId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Hitung Rata-rata Nilai per Mata Pelajaran (Hanya untuk tugas yang sudah dinilai)
        $rapor = $submissions->whereNotNull('nilai')->groupBy(function($item) {
            return $item->tugas->mataPelajaran->nama;
        })->map(function($group) {
            return [
                'rata_rata' => round($group->avg('nilai'), 2), // Hitung rata-rata
                'total_dinilai' => $group->count(),
            ];
        });

        return view('student.nilai.index', compact('submissions', 'rapor'));
    }
}