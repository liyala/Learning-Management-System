@extends('layouts.app')
@section('title', 'Kuis Online')
@section('header_title', 'Ujian: ' . $kuis->judul)

@section('content')
<div class="mb-4">
    <a href="{{ route('student.kelas.show', $kelas->id) }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Kelas</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif
@if(session('error'))
    <div class="alert alert-error shadow-sm mb-4"><span>{{ session('error') }}</span></div>
@endif

<div class="card bg-base-100 shadow-sm max-w-2xl mx-auto border-t-4 border-primary">
    <div class="card-body">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-primary">{{ $kuis->judul }}</h2>
            <p class="text-gray-500 font-semibold mt-1">{{ $kuis->mataPelajaran->nama }} • Kelas {{ $kelas->nama_kelas }}</p>
        </div>

        <div class="bg-base-200 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Durasi Ujian</p>
                    <p class="text-lg font-black text-gray-800">{{ $kuis->durasi_menit }} Menit</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Total Soal</p>
                    <p class="text-lg font-black text-gray-800">{{ $kuis->soal->count() }} Butir</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-300 text-sm text-center text-gray-600">
                <i class="fas fa-clock text-warning"></i> Bisa diakses pada: 
                <span class="font-bold">{{ $kuis->waktu_mulai->format('d M Y, H:i') }}</span> s/d <span class="font-bold">{{ $kuis->waktu_selesai->format('d M Y, H:i') }}</span>
            </div>
        </div>

        @if($kuis->deskripsi)
            <div class="mb-6 text-sm text-gray-700 p-4 border border-info bg-blue-50/30 rounded-lg">
                <p class="font-bold mb-1">Peraturan & Deskripsi:</p>
                <p class="whitespace-pre-line">{{ $kuis->deskripsi }}</p>
            </div>
        @endif

        @php $sekarang = now(); @endphp

        <!-- LOGIKA TOMBOL & STATUS -->
        @if($hasil && $hasil->status == 'selesai')
            <div class="alert alert-success bg-green-100 text-green-800 text-center rounded-lg flex flex-col justify-center py-6">
                <h3 class="font-bold text-lg"><i class="fas fa-check-circle"></i> Kuis Telah Diselesaikan!</h3>
                <p class="mt-2 text-sm">Nilai yang Anda peroleh:</p>
                <p class="text-5xl font-black text-primary mt-2">{{ $hasil->nilai }}</p>
            </div>
        @elseif($sekarang->lt($kuis->waktu_mulai))
            <div class="alert alert-warning text-center rounded-lg flex justify-center">
                <span><i class="fas fa-lock"></i> Kuis belum dimulai. Harap tunggu hingga jadwal yang ditentukan.</span>
            </div>
        @elseif($sekarang->gt($kuis->waktu_selesai))
            <div class="alert alert-error text-white text-center rounded-lg flex justify-center">
                <span><i class="fas fa-times-circle"></i> Waktu akses kuis sudah ditutup.</span>
            </div>
        @else
            <!-- Bisa dikerjakan -->
            <div class="alert alert-info text-sm mb-4">
                <i class="fas fa-exclamation-triangle"></i> Peringatan: Jangan menutup atau me-refresh browser (F5) saat ujian berlangsung. Waktu akan terus berjalan.
            </div>
            <a href="{{ route('student.kuis.kerjakan', [$kelas->id, $kuis->id]) }}" class="btn btn-primary btn-lg w-full text-white" onclick="return confirm('Apakah Anda yakin sudah siap memulai kuis ini? Waktu akan mulai berjalan mundur.');">
                <i class="fas fa-play-circle"></i> {{ $hasil ? 'Lanjutkan Mengerjakan' : 'Mulai Kerjakan Kuis Sekarang' }}
            </a>
        @endif

    </div>
</div>
@endsection