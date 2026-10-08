@extends('layouts.app')
@section('title', 'Kelas Saya')
@section('header_title', 'Kelas Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold mb-2">Daftar Kelas yang Anda Ajar</h2>
    <p class="text-gray-500">Pilih kelas di bawah ini untuk mengelola materi, tugas, dan melihat daftar siswa.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($kelases as $kelas)
        <div class="card bg-base-100 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="card-body">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="card-title text-primary">{{ $kelas->nama_kelas }}</h2>
                    @if($kelas->status === 'active')
                        <div class="badge badge-success badge-sm text-white">Aktif</div>
                    @else
                        <div class="badge badge-ghost badge-sm">Arsip</div>
                    @endif
                </div>
                
                <p class="text-sm text-gray-500 mb-4"><i class="fas fa-calendar-alt w-4"></i> {{ $kelas->tahunAjaran->nama }}</p>
                
                @if($kelas->guru_id == Auth::id())
                    <div class="badge badge-outline badge-primary mb-4 w-fit">Wali Kelas</div>
                @else
                    <div class="badge badge-outline badge-secondary mb-4 w-fit">Guru Mapel</div>
                @endif

                <div class="card-actions justify-end mt-auto">
                    <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-primary w-full"><i class="fas fa-sign-in-alt"></i> Masuk Kelas</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 bg-base-100 rounded-lg shadow-sm">
            <i class="fas fa-chalkboard text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-bold text-gray-600">Belum Ada Kelas</h3>
            <p class="text-gray-500">Anda belum ditugaskan ke kelas manapun. Silakan hubungi Administrator.</p>
        </div>
    @endforelse
</div>
@endsection