<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function store(Request $request, Kelas $kelas)
    {
        $teacherId = Auth::id();
        
        // Hanya guru pemangku atau wali kelas yang bisa membuat pengumuman
        if ($kelas->guru_id !== $teacherId && !$kelas->jadwal()->where('guru_id', $teacherId)->exists()) {
            abort(403);
        }

        $request->validate([
            'isi' => 'required|string|max:1000'
        ]);

        $kelas->pengumuman()->create([
            'user_id' => $teacherId,
            'isi' => $request->isi
        ]);

        session()->flash('active_tab', 'pengumuman');
        return back()->with('success', 'Pengumuman berhasil diposting.');
    }

    public function destroy(Kelas $kelas, Pengumuman $pengumuman)
    {
        // Hanya pembuat pengumuman yang bisa menghapusnya
        if ($pengumuman->user_id !== Auth::id()) {
            abort(403);
        }

        $pengumuman->delete();
        
        session()->flash('active_tab', 'pengumuman');
        return back()->with('success', 'Pengumuman dihapus.');
    }
}