@extends('layouts.app')
@section('title', 'Kelas Saya')
@section('header_title', 'Kelas Saya')

@section('content')
<div class="mb-4 px-2 md:px-0">
    <h2 class="text-lg md:text-xl font-bold">Daftar Kelasmu</h2>
    <p class="text-sm md:text-base text-gray-500">Pilih kelas untuk melihat materi dan tugas.</p>
</div>

<!-- Grid responsif: 1 kolom di HP, 2 di Tablet, 3 di Desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
    @forelse($kelases as $kelas)
        <div class="card bg-base-100 shadow-sm hover:shadow-md transition border border-gray-100">
            <div class="card-body p-5 md:p-6">
                <h2 class="card-title text-primary text-lg md:text-xl">{{ $kelas->nama_kelas }}</h2>
                <div class="space-y-1 mt-2">
                    <p class="text-xs md:text-sm text-gray-500"><i class="fas fa-calendar-alt w-4"></i> {{ $kelas->tahunAjaran->nama }}</p>
                    <p class="text-xs md:text-sm text-gray-500"><i class="fas fa-chalkboard-teacher w-4"></i> Wali: {{ $kelas->guru->nama }}</p>
                </div>
                
                <div class="card-actions justify-end mt-4">
                    <!-- Tombol di HP akan sedikit lebih padat tapi tetap full-width -->
                    <a href="{{ route('student.kelas.show', $kelas->id) }}" class="btn btn-primary btn-sm md:btn-md w-full">
                        <i class="fas fa-door-open"></i> Masuk Kelas
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-10 bg-base-100 shadow-sm rounded-lg mx-2 md:mx-0">
            <i class="fas fa-info-circle text-4xl text-gray-300 mb-3"></i>
            <p class="text-sm md:text-base text-gray-500">Kamu belum terdaftar di kelas manapun. Hubungi gurumu.</p>
        </div>
    @endforelse
</div>
@endsection