<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasAnggotaController extends Controller
{
    public function index(Kelas $kelas)
    {
        // Ambil data siswa yang sudah ada di kelas ini
        $anggota = $kelas->siswa()->orderBy('nama', 'asc')->get();

        // Ambil data user ber-role 'siswa' yang BELUM ada di kelas ini
        $anggotaIds = $anggota->pluck('id')->toArray();
        $siswaTersedia = User::whereHas('role', function($q) {
            $q->where('name', 'siswa');
        })->whereNotIn('id', $anggotaIds)->orderBy('nama', 'asc')->get();

        return view('admin.kelas.anggota', compact('kelas', 'anggota', 'siswaTersedia'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id'
        ]);

        // Cek apakah siswa sudah ada di kelas (tindakan preventif ganda)
        if ($kelas->siswa()->where('siswa_id', $request->siswa_id)->exists()) {
            return back()->with('error', 'Siswa tersebut sudah berada di dalam kelas ini.');
        }

        // Attach siswa ke kelas
        $kelas->siswa()->attach($request->siswa_id);

        return back()->with('success', 'Siswa berhasil ditambahkan ke kelas.');
    }

    public function destroy(Kelas $kelas, User $siswa)
    {
        // Detach siswa dari kelas
        $kelas->siswa()->detach($siswa->id);

        return back()->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }
}