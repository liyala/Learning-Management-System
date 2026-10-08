<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function create(Kelas $kelas)
    {
        $teacherId = Auth::id();
        if ($kelas->guru_id !== $teacherId && !$kelas->jadwal()->where('guru_id', $teacherId)->exists()) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $mapels = MataPelajaran::orderBy('nama', 'asc')->get();
        return view('teacher.tugas.create', compact('kelas', 'mapels'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string', // Deskripsi wajib agar instruksi tugas jelas
            'deadline' => 'required|date|after:today',
            'file_pendukung' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            $filePath = $file->storeAs('tugas', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        Tugas::create([
            'kelas_id' => $kelas->id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'guru_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'file_pendukung' => $filePath,
        ]);

        // Opsional: Gunakan cookie/session untuk kembali ke tab Tugas
        session()->flash('active_tab', 'tugas');
        return redirect()->route('teacher.kelas.show', $kelas->id)->with('success', 'Tugas berhasil dibuat.');
    }

    public function destroy(Kelas $kelas, Tugas $tugas)
    {
        if ($tugas->guru_id !== Auth::id()) {
            abort(403, 'Anda tidak dapat menghapus tugas milik guru lain.');
        }

        if ($tugas->file_pendukung && Storage::disk('public')->exists($tugas->file_pendukung)) {
            Storage::disk('public')->delete($tugas->file_pendukung);
        }

        $tugas->delete();

        session()->flash('active_tab', 'tugas');
        return back()->with('success', 'Tugas berhasil dihapus.');
    }
    public function index()
    {
        // Ambil semua tugas yang pernah dibuat oleh guru ini
        $tugases = Tugas::with(['kelas', 'mataPelajaran', 'submissions'])
            ->where('guru_id', Auth::id())
            ->latest()
            ->get();

        return view('teacher.tugas.index', compact('tugases'));
    }
}