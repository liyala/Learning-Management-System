<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::latest()->paginate(10);
        return view('admin.mata_pelajaran.index', compact('mapels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran',
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        MataPelajaran::create($validated);
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();
        return back()->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}