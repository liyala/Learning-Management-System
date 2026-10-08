<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelases = Kelas::with(['tahunAjaran', 'guru'])->latest()->paginate(10);
        return view('admin.kelas.index', compact('kelases'));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        $gurus = User::whereHas('role', function($q) {
            $q->where('name', 'guru');
        })->get();

        return view('admin.kelas.create', compact('tahunAjarans', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
        ]);

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        $gurus = User::whereHas('role', function($q) {
            $q->where('name', 'guru');
        })->get();

        return view('admin.kelas.edit', compact('kelas', 'tahunAjarans', 'gurus'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:active,archived'
        ]);

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}