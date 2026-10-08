<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\KuisHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisController extends Controller
{
    // Halaman Info Kuis (Sebelum Mulai & Sesudah Selesai)
    public function show(Kelas $kelas, Kuis $kuis)
    {
        if (!$kelas->siswa()->where('siswa_id', Auth::id())->exists() || $kuis->status !== 'published') abort(403);

        $hasil = KuisHasil::where('kuis_id', $kuis->id)->where('siswa_id', Auth::id())->first();
        
        return view('student.kuis.show', compact('kelas', 'kuis', 'hasil'));
    }

    // Mesin Ujian (Tampilan Soal & Timer)
    public function kerjakan(Kelas $kelas, Kuis $kuis)
    {
        if (!$kelas->siswa()->where('siswa_id', Auth::id())->exists() || $kuis->status !== 'published') abort(403);

        $sekarang = now();
        if ($sekarang->lt($kuis->waktu_mulai) || $sekarang->gt($kuis->waktu_selesai)) {
            return redirect()->route('student.kuis.show', [$kelas->id, $kuis->id])->with('error', 'Kuis sedang tidak aktif.');
        }

        // Catat waktu mulai jika baru pertama kali klik "Mulai"
        $hasil = KuisHasil::firstOrCreate(
            ['kuis_id' => $kuis->id, 'siswa_id' => Auth::id()],
            ['waktu_mulai_mengerjakan' => $sekarang, 'status' => 'mengerjakan']
        );

        if ($hasil->status === 'selesai') {
            return redirect()->route('student.kuis.show', [$kelas->id, $kuis->id])->with('success', 'Anda sudah menyelesaikan kuis ini.');
        }

        // Hitung sisa waktu (Detik)
        $waktuBerjalan = $sekarang->diffInSeconds($hasil->waktu_mulai_mengerjakan);
        $sisaWaktuDetik = ($kuis->durasi_menit * 60) - $waktuBerjalan;

        if ($sisaWaktuDetik <= 0) {
            // Waktu habis, otomatis selesai dengan nilai 0 (jika belum submit)
            return $this->autoSubmitHabisWaktu($kelas, $kuis, $hasil);
        }

        $soals = $kuis->soal()->inRandomOrder()->get(); // Acak soal

        return view('student.kuis.kerjakan', compact('kelas', 'kuis', 'soals', 'sisaWaktuDetik'));
    }

    // Proses Hitung Nilai Otomatis (Auto-Grading)
    public function submit(Request $request, Kelas $kelas, Kuis $kuis)
    {
        $hasil = KuisHasil::where('kuis_id', $kuis->id)->where('siswa_id', Auth::id())->firstOrFail();

        if ($hasil->status === 'selesai') {
            return redirect()->route('student.kuis.show', [$kelas->id, $kuis->id]);
        }

        $soals = $kuis->soal;
        $jawabanSiswa = $request->jawaban ?? []; // Berisi array [id_soal => 'a/b/c/d']
        
        $skorDidapat = 0;
        $totalBobot = $soals->sum('bobot') ?: 1; // Hindari pembagian 0

        foreach ($soals as $soal) {
            if (isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id] === $soal->kunci_jawaban) {
                $skorDidapat += $soal->bobot;
            }
        }

        // Hitung persentase nilai (Maksimal 100)
        $nilaiAkhir = ($skorDidapat / $totalBobot) * 100;

        $hasil->update([
            'nilai' => $nilaiAkhir,
            'waktu_selesai_mengerjakan' => now(),
            'status' => 'selesai'
        ]);

        return redirect()->route('student.kuis.show', [$kelas->id, $kuis->id])->with('success', 'Kuis berhasil diselesaikan!');
    }

    private function autoSubmitHabisWaktu($kelas, $kuis, $hasil)
    {
        $hasil->update([
            'nilai' => 0,
            'waktu_selesai_mengerjakan' => now(),
            'status' => 'selesai'
        ]);
        return redirect()->route('student.kuis.show', [$kelas->id, $kuis->id])->with('error', 'Waktu Anda telah habis. Kuis otomatis ditutup.');
    }
}