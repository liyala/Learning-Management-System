<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::latest()->paginate(10);
        return view('admin.tahun_ajaran.index', compact('tahunAjarans'));
    }

    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:tahun_ajaran,nama',
        ]);

        TahunAjaran::create([
            'nama' => $request->nama,
            'status' => 'inactive', // Default selalu inactive saat dibuat
        ]);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:tahun_ajaran,nama,' . $tahunAjaran->id,
        ]);

        $tahunAjaran->update(['nama' => $request->nama]);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->status === 'active') {
            return back()->with('error', 'Tidak dapat menghapus Tahun Ajaran yang sedang aktif.');
        }

        $tahunAjaran->delete();
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun Ajaran berhasil dihapus.');
    }

    // Fungsi khusus untuk mengaktifkan satu tahun ajaran dan menonaktifkan yang lain
    public function setActive(TahunAjaran $tahunAjaran)
    {
        // Nonaktifkan semua tahun ajaran terlebih dahulu
        TahunAjaran::query()->update(['status' => 'inactive']);
        
        // Aktifkan tahun ajaran yang dipilih
        $tahunAjaran->update(['status' => 'active']);

        return back()->with('success', 'Tahun Ajaran ' . $tahunAjaran->nama . ' berhasil diaktifkan.');
    }
}