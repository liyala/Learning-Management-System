<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guruId = Auth::id();

        // 1. Ambil data Materi terbaru
        $materis = Materi::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->latest()
            ->get();

        // 2. Ambil data Tugas terbaru beserta relasi pengumpulannya
        $tugases = Tugas::with(['kelas', 'mataPelajaran', 'submissions'])
            ->where('guru_id', $guruId)
            ->latest()
            ->get();

        // 3. Ekstrak dan gabungkan daftar Kelas unik dari Materi dan Tugas
        $daftarKelas = $materis->pluck('kelas')
            ->merge($tugases->pluck('kelas'))
            ->filter()
            ->unique('id')
            ->values();

        // 4. Hitung angka untuk Kartu Statistik (Stat Cards)
        $totalKelas = $daftarKelas->count();
        $totalMateri = $materis->count();
        $tugasAktif = $tugases->filter(fn($t) => Carbon::now()->lte($t->deadline))->count();
        $totalSubmissions = $tugases->sum(fn($t) => $t->submissions ? $t->submissions->count() : 0);

        // 5. Kirim semua variabel ke View
        return view('teacher.dashboard', compact(
            'materis', 
            'tugases', 
            'daftarKelas', 
            'totalKelas', 
            'totalMateri', 
            'tugasAktif', 
            'totalSubmissions'
        ));
    }
}