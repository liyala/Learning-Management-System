<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user();
        
        // Ambil kelas yang diikuti oleh siswa ini
        $kelases = $siswa->kelas()->with('tahunAjaran', 'guru')->get();
        $totalKelas = $kelases->count();

        return view('student.dashboard', compact('siswa', 'kelases', 'totalKelas'));
    }
}