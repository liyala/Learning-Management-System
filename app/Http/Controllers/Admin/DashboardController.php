<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah user berdasarkan role
        $totalUsers = User::count();
        $totalAdmin = User::whereHas('role', function($q) { $q->where('name', 'admin'); })->count();
        $totalGuru = User::whereHas('role', function($q) { $q->where('name', 'guru'); })->count();
        $totalSiswa = User::whereHas('role', function($q) { $q->where('name', 'siswa'); })->count();

        // Nanti kita tambahkan total kelas dan mata pelajaran saat tabelnya sudah ada modelnya
        $totalKelas = 0; 
        $totalMapel = 0;

        return view('admin.dashboard', compact(
            'totalUsers', 'totalAdmin', 'totalGuru', 'totalSiswa', 'totalKelas', 'totalMapel'
        ));
    }
}