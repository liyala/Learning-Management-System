@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('header_title', 'Dashboard Panel Guru')

@section('content')
<div class="card bg-base-100 shadow-sm mb-6 border-l-4 border-primary">
    <div class="card-body">
        <h2 class="card-title text-2xl mb-2">Selamat Datang, {{ Auth::user()->nama }}! 👨‍🏫</h2>
        <p class="text-gray-600">Anda dapat memantau kelas yang Anda ajar, mengelola materi pembelajaran, dan memberikan tugas kepada siswa melalui panel ini.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card bg-info text-info-content shadow-sm">
        <div class="card-body">
            <h2 class="card-title"><i class="fas fa-chalkboard"></i> Total Kelas</h2>
            <p class="text-4xl font-bold mt-2">{{ $totalKelas }}</p>
            <p class="text-sm opacity-80 mt-1">Kelas yang Anda ajar</p>
        </div>
    </div>
    <div class="card bg-success text-success-content shadow-sm">
        <div class="card-body">
            <h2 class="card-title"><i class="fas fa-users"></i> Total Siswa</h2>
            <p class="text-4xl font-bold mt-2">{{ $totalSiswa }}</p>
            <p class="text-sm opacity-80 mt-1">Siswa di bawah bimbingan Anda</p>
        </div>
    </div>
    <div class="card bg-warning text-warning-content shadow-sm">
        <div class="card-body">
            <h2 class="card-title"><i class="fas fa-tasks"></i> Tugas Aktif</h2>
            <p class="text-4xl font-bold mt-2">{{ $tugasAktif }}</p>
            <p class="text-sm opacity-80 mt-1">Menunggu penilaian</p>
        </div>
    </div>
</div>
@endsection