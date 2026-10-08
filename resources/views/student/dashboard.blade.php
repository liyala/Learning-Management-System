@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('header_title', 'Dashboard Pembelajaran')

@section('content')
<div class="card bg-base-100 shadow-sm border-l-4 border-info mb-6">
    <div class="card-body p-6">
        <h2 class="text-2xl font-bold mb-2">Halo, {{ Auth::user()->nama }}! 👋</h2>
        <p class="text-gray-600">Selamat datang di portal belajarmu. Jangan lupa periksa kelas dan tugas hari ini!</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="card bg-primary text-primary-content shadow-sm">
        <div class="card-body">
            <h2 class="card-title"><i class="fas fa-school"></i> Kelas Terdaftar</h2>
            <p class="text-4xl font-bold mt-2">{{ $totalKelas }}</p>
        </div>
    </div>
</div>
@endsection