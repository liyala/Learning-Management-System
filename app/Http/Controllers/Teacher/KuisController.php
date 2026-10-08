<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\KuisSoal;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisController extends Controller
{
    // Halaman Buat Kuis
    public function create(Kelas $kelas)
    {
        if ($kelas->guru_id !== Auth::id() && !$kelas->jadwal()->where('guru_id', Auth::id())->exists()) abort(403);
        $mapels = MataPelajaran::orderBy('nama')->get();
        return view('teacher.kuis.create', compact('kelas', 'mapels'));
    }

    // Simpan Pengaturan Kuis
    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'durasi_menit' => 'required|integer|min:5',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'status' => 'required|in:draft,published'
        ]);

        $kuis = $kelas->kuis()->create([
            'guru_id' => Auth::id(),
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'durasi_menit' => $request->durasi_menit,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => $request->status,
        ]);

        session()->flash('active_tab', 'kuis');
        // Arahkan langsung ke halaman manajemen soal setelah kuis dibuat
        return redirect()->route('teacher.kuis.show', [$kelas->id, $kuis->id])->with('success', 'Pengaturan Kuis tersimpan. Silakan masukkan butir soal.');
    }

    // Halaman Detail Kuis (Untuk Manajemen Soal)
    public function show(Kelas $kelas, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::id()) abort(403);
        return view('teacher.kuis.show', compact('kelas', 'kuis'));
    }

    // Simpan Butir Soal Baru
    public function storeSoal(Request $request, Kelas $kelas, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::id()) abort(403);

        $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'kunci_jawaban' => 'required|in:a,b,c,d',
            'bobot' => 'required|integer|min:1'
        ]);

        $kuis->soal()->create($request->all());
        return back()->with('success', 'Soal berhasil ditambahkan.');
    }
    
    // Hapus Butir Soal
    public function destroySoal(Kelas $kelas, Kuis $kuis, KuisSoal $soal)
    {
        if ($kuis->guru_id !== Auth::id()) abort(403);
        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }
    // Halaman Edit Pengaturan Kuis
    public function edit(Kelas $kelas, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::id()) abort(403);
        $mapels = MataPelajaran::orderBy('nama')->get();
        return view('teacher.kuis.edit', compact('kelas', 'kuis', 'mapels'));
    }

    // Simpan Perubahan Pengaturan Kuis
    public function update(Request $request, Kelas $kelas, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::id()) abort(403);

        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'durasi_menit' => 'required|integer|min:5',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'status' => 'required|in:draft,published'
        ]);

        $kuis->update([
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'durasi_menit' => $request->durasi_menit,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => $request->status,
        ]);

        session()->flash('active_tab', 'kuis');
        return redirect()->route('teacher.kelas.show', $kelas->id)->with('success', 'Pengaturan Kuis berhasil diperbarui.');
    }

    // Hapus Kuis (Beserta seluruh soal dan nilai siswanya secara otomatis)
    public function destroy(Kelas $kelas, Kuis $kuis)
    {
        if ($kuis->guru_id !== Auth::id()) abort(403);
        
        $kuis->delete();
        
        session()->flash('active_tab', 'kuis');
        return redirect()->route('teacher.kelas.show', $kelas->id)->with('success', 'Kuis berhasil dihapus dari kelas.');
    }
}