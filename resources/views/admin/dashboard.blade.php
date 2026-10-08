<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card Total User -->
    <div class="card bg-base-100 shadow-sm border-l-4 border-primary">
        <div class="card-body py-4 px-6 flex-row items-center justify-between">
            <div>
                <h2 class="card-title text-gray-500 text-sm">Total Pengguna</h2>
                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
            </div>
            <div class="text-primary text-4xl opacity-80">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Card Total Guru -->
    <div class="card bg-base-100 shadow-sm border-l-4 border-success">
        <div class="card-body py-4 px-6 flex-row items-center justify-between">
            <div>
                <h2 class="card-title text-gray-500 text-sm">Total Guru</h2>
                <p class="text-3xl font-bold">{{ $totalGuru }}</p>
            </div>
            <div class="text-success text-4xl opacity-80">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <!-- Card Total Siswa -->
    <div class="card bg-base-100 shadow-sm border-l-4 border-warning">
        <div class="card-body py-4 px-6 flex-row items-center justify-between">
            <div>
                <h2 class="card-title text-gray-500 text-sm">Total Siswa</h2>
                <p class="text-3xl font-bold">{{ $totalSiswa }}</p>
            </div>
            <div class="text-warning text-4xl opacity-80">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <!-- Card Total Kelas -->
    <div class="card bg-base-100 shadow-sm border-l-4 border-info">
        <div class="card-body py-4 px-6 flex-row items-center justify-between">
            <div>
                <h2 class="card-title text-gray-500 text-sm">Total Kelas</h2>
                <p class="text-3xl font-bold">{{ $totalKelas }}</p>
            </div>
            <div class="text-info text-4xl opacity-80">
                <i class="fas fa-school"></i>
            </div>
        </div>
    </div>
</div>

<div class="card bg-base-100 shadow-sm">
    <div class="card-body">
        <h2 class="card-title mb-4">Selamat Datang, {{ Auth::user()->nama }}!</h2>
        <p>Gunakan menu di sebelah kiri untuk mengelola sistem Learning Management System. Anda memiliki akses penuh untuk menambah, mengubah, dan menghapus data pengguna, kelas, serta mata pelajaran.</p>
    </div>
</div>
@endsection