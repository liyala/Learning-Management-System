<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index(Kelas $kelas)
    {
        // Mengelompokkan jadwal berdasarkan hari dan diurutkan berdasarkan jam mulai
        $jadwals = $kelas->jadwal()->with(['mataPelajaran', 'guru'])
                         ->orderBy('jam_mulai')
                         ->get()
                         ->groupBy('hari');

        $mapels = MataPelajaran::orderBy('nama', 'asc')->get();
        
        // Ambil semua guru untuk opsi pengajar (karena bisa jadi guru mapel beda dengan wali kelas)
        $gurus = User::whereHas('role', function($q) {
            $q->where('name', 'guru');
        })->orderBy('nama', 'asc')->get();

        // Urutan hari untuk tampilan
        $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.kelas.jadwal', compact('kelas', 'jadwals', 'mapels', 'gurus', 'urutanHari'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:users,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $kelas->jadwal()->create($request->all());

        return back()->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function destroy(Kelas $kelas, JadwalPelajaran $jadwal)
    {
        $jadwal->delete();
        return back()->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}