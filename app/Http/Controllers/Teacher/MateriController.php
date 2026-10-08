<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function create(Kelas $kelas)
    {
        // Pastikan guru ini memiliki akses ke kelas ini
        $teacherId = Auth::id();
        if ($kelas->guru_id !== $teacherId && !$kelas->jadwal()->where('guru_id', $teacherId)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Ambil mata pelajaran untuk dropdown
        $mapels = MataPelajaran::orderBy('nama', 'asc')->get();

        return view('teacher.materi.create', compact('kelas', 'mapels'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            // Validasi file: pdf, doc, docx, ppt, pptx, png, jpg, max 5MB
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            // Simpan file ke folder storage/app/public/materi
            $filePath = $file->storeAs('materi', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        Materi::create([
            'kelas_id' => $kelas->id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'guru_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
        ]);

        return redirect()->route('teacher.kelas.show', $kelas->id)->with('success', 'Materi berhasil diunggah.');
    }
    public function index()
    {
        // Ambil semua materi yang pernah diunggah oleh guru ini beserta relasi kelas & mapelnya
        $materis = Materi::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', Auth::id())
            ->latest()
            ->get();

        return view('teacher.materi.index', compact('materis'));
    }

    public function destroy(Kelas $kelas, Materi $materi)
    {
        if ($materi->guru_id !== Auth::id()) {
            abort(403, 'Anda tidak dapat menghapus materi milik guru lain.');
        }

        // Hapus file fisik dari storage jika ada
        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }
}