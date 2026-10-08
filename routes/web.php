<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role->name;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'guru') return redirect()->route('teacher.dashboard');
        if ($role === 'siswa') return redirect()->route('student.dashboard');
    }
    return redirect()->route('login');
});

// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
// });
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    
    // Rute Admin
        Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('manajemen-users', UserController::class)
            ->names('users')
            ->parameters(['manajemen-users' => 'user']);

        Route::resource('tahun-ajaran', App\Http\Controllers\Admin\TahunAjaranController::class)
            ->parameters(['tahun-ajaran' => 'tahunAjaran']);
        Route::patch('tahun-ajaran/{tahunAjaran}/set-active', [App\Http\Controllers\Admin\TahunAjaranController::class, 'setActive'])
            ->name('tahun-ajaran.set-active');
  
        Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class)
            ->parameters(['kelas' => 'kelas']);

        Route::get('kelas/{kelas}/anggota', [App\Http\Controllers\Admin\KelasAnggotaController::class, 'index'])->name('kelas.anggota.index');
        Route::post('kelas/{kelas}/anggota', [App\Http\Controllers\Admin\KelasAnggotaController::class, 'store'])->name('kelas.anggota.store');
        Route::delete('kelas/{kelas}/anggota/{siswa}', [App\Http\Controllers\Admin\KelasAnggotaController::class, 'destroy'])->name('kelas.anggota.destroy');
    
        Route::get('kelas/{kelas}/jadwal', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'index'])->name('kelas.jadwal.index');
        Route::post('kelas/{kelas}/jadwal', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'store'])->name('kelas.jadwal.store');
        Route::delete('kelas/{kelas}/jadwal/{jadwal}', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'destroy'])->name('kelas.jadwal.destroy');
        
        // Rute Mata Pelajaran
        Route::resource('mata-pelajaran', App\Http\Controllers\Admin\MataPelajaranController::class)
            ->only(['index', 'store', 'destroy'])
            ->parameters(['mata-pelajaran' => 'mataPelajaran']);
    
        });

    // Rute Guru
        Route::middleware(['role:guru'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
        
        // Rute Kelas Saya
        Route::get('/kelas', [App\Http\Controllers\Teacher\KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/{id}', [App\Http\Controllers\Teacher\KelasController::class, 'show'])->name('kelas.show');
    
        Route::get('/kelas/{kelas}/materi/create', [App\Http\Controllers\Teacher\MateriController::class, 'create'])->name('materi.create');
        Route::post('/kelas/{kelas}/materi', [App\Http\Controllers\Teacher\MateriController::class, 'store'])->name('materi.store');
        Route::delete('/kelas/{kelas}/materi/{materi}', [App\Http\Controllers\Teacher\MateriController::class, 'destroy'])->name('materi.destroy');
        
        // Rute Manajemen Tugas
        Route::get('/kelas/{kelas}/tugas/create', [App\Http\Controllers\Teacher\TugasController::class, 'create'])->name('tugas.create');
        Route::post('/kelas/{kelas}/tugas', [App\Http\Controllers\Teacher\TugasController::class, 'store'])->name('tugas.store');
        Route::delete('/kelas/{kelas}/tugas/{tugas}', [App\Http\Controllers\Teacher\TugasController::class, 'destroy'])->name('tugas.destroy');
        
        // Rute Penilaian Tugas
        Route::get('/kelas/{kelas}/tugas/{tugas}/submissions', [App\Http\Controllers\Teacher\PenilaianController::class, 'index'])->name('tugas.submissions');
        Route::put('/kelas/{kelas}/tugas/{tugas}/submissions/{submission}', [App\Http\Controllers\Teacher\PenilaianController::class, 'update'])->name('tugas.grade');

        // Rute Pengumuman Kelas
        Route::post('/kelas/{kelas}/pengumuman', [App\Http\Controllers\Teacher\PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::delete('/kelas/{kelas}/pengumuman/{pengumuman}', [App\Http\Controllers\Teacher\PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
        
        // Rute Kuis
        Route::get('/kelas/{kelas}/kuis/create', [App\Http\Controllers\Teacher\KuisController::class, 'create'])->name('kuis.create');
        Route::post('/kelas/{kelas}/kuis', [App\Http\Controllers\Teacher\KuisController::class, 'store'])->name('kuis.store');
        Route::get('/kelas/{kelas}/kuis/{kuis}', [App\Http\Controllers\Teacher\KuisController::class, 'show'])->name('kuis.show');
        Route::post('/kelas/{kelas}/kuis/{kuis}/soal', [App\Http\Controllers\Teacher\KuisController::class, 'storeSoal'])->name('kuis.soal.store');
        Route::delete('/kelas/{kelas}/kuis/{kuis}/soal/{soal}', [App\Http\Controllers\Teacher\KuisController::class, 'destroySoal'])->name('kuis.soal.destroy');
        
        // Rute Kuis (Tambahan Edit, Update, Destroy Kuis)
        Route::get('/kelas/{kelas}/kuis/{kuis}/edit', [App\Http\Controllers\Teacher\KuisController::class, 'edit'])->name('kuis.edit');
        Route::put('/kelas/{kelas}/kuis/{kuis}', [App\Http\Controllers\Teacher\KuisController::class, 'update'])->name('kuis.update');
        Route::delete('/kelas/{kelas}/kuis/{kuis}', [App\Http\Controllers\Teacher\KuisController::class, 'destroy'])->name('kuis.destroy');
        
        Route::get('/materi', [App\Http\Controllers\Teacher\MateriController::class, 'index'])->name('materi.index');
        Route::get('/tugas', [App\Http\Controllers\Teacher\TugasController::class, 'index'])->name('tugas.index');

        });
        // Rute Global untuk Materi dan Tugas (di sidebar)
        
    // Rute Siswa
        Route::middleware(['role:siswa'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        
        // Rute Kelas Siswa
        Route::get('/kelas', [App\Http\Controllers\Student\KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/{kelas}', [App\Http\Controllers\Student\KelasController::class, 'show'])->name('kelas.show');
        
        // Rute Tugas (Detail & Pengumpulan)
        Route::get('/kelas/{kelas}/tugas/{tugas}', [App\Http\Controllers\Student\TugasController::class, 'show'])->name('tugas.show');
        Route::post('/kelas/{kelas}/tugas/{tugas}', [App\Http\Controllers\Student\TugasController::class, 'store'])->name('tugas.submit');
    
        Route::get('/nilai', [App\Http\Controllers\Student\NilaiController::class, 'index'])->name('nilai.index');

        // Rute Kuis / Ujian Online
        Route::get('/kelas/{kelas}/kuis/{kuis}', [App\Http\Controllers\Student\KuisController::class, 'show'])->name('kuis.show');
        Route::get('/kelas/{kelas}/kuis/{kuis}/kerjakan', [App\Http\Controllers\Student\KuisController::class, 'kerjakan'])->name('kuis.kerjakan');
        Route::post('/kelas/{kelas}/kuis/{kuis}/submit', [App\Http\Controllers\Student\KuisController::class, 'submit'])->name('kuis.submit');
        
       
       
        });
});