<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function show(Kelas $kelas, Tugas $tugas)
    {
        if (!$kelas->siswa()->where('siswa_id', Auth::id())->exists() || $tugas->kelas_id !== $kelas->id) {
            abort(403);
        }

        // Cari tahu apakah siswa ini sudah mengumpulkan tugas
        $submission = TugasSubmission::where('tugas_id', $tugas->id)
                        ->where('siswa_id', Auth::id())
                        ->first();

        return view('student.tugas.show', compact('kelas', 'tugas', 'submission'));
    }

    public function store(Request $request, Kelas $kelas, Tugas $tugas)
    {
        if (!$kelas->siswa()->where('siswa_id', Auth::id())->exists()) abort(403);

        $submission = TugasSubmission::where('tugas_id', $tugas->id)->where('siswa_id', Auth::id())->first();

        // Cegah unggah ulang jika guru sudah memberikan nilai
        if ($submission && $submission->nilai !== null) {
            return back()->with('error', 'Tugas sudah dinilai oleh guru. Anda tidak dapat mengubahnya lagi.');
        }

        $request->validate([
            'file_jawaban' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'catatan_siswa' => 'nullable|string'
        ]);

        $filePath = null;
        if ($request->hasFile('file_jawaban')) {
            // Hapus file lama jika ada (untuk kasus Re-submit)
            if ($submission && $submission->file_jawaban && Storage::disk('public')->exists($submission->file_jawaban)) {
                Storage::disk('public')->delete($submission->file_jawaban);
            }

            $file = $request->file('file_jawaban');
            $filePath = $file->storeAs('jawaban', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        TugasSubmission::updateOrCreate(
            ['tugas_id' => $tugas->id, 'siswa_id' => Auth::id()],
            [
                'file_jawaban' => $filePath ?? $submission->file_jawaban,
                'catatan_siswa' => $request->catatan_siswa,
            ]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}