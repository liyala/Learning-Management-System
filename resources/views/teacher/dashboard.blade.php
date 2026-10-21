@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('header_title', 'Dashboard')

@section('content')

<!-- 1. HEADER SAPAAN MINIMALIS -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl md:text-2xl font-bold">Halo, {{ Auth::user()->nama }} </h2>
        <p class="text-sm opacity-70 mt-0.5">
            Berikut adalah ringkasan aktivitas pembelajaran Anda hari ini, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}.
        </p>
    </div>
    <a href="{{ route('teacher.kelas.index') }}" class="btn btn-primary btn-sm md:btn-md self-start sm:self-auto">
        <i class="fas fa-chalkboard"></i> Kelola Kelas Saya
    </a>
</div>

<!-- 2. RINGKASAN STATISTIK (4 KARTU SIMPEL) -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-6 md:p-8 flex-row items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-lg shrink-0">
                <i class="fas fa-door-open"></i>
            </div>
            <div>
                <div class="text-2xl font-bold leading-none">{{ $totalKelas }}</div>
                <div class="text-sm opacity-60 mt-1">Kelas Diampu</div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-4 md:p-5 flex-row items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-info/10 text-info flex items-center justify-center text-lg shrink-0">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <div class="text-2xl font-bold leading-none">{{ $totalMateri }}</div>
                <div class="text-sm opacity-60 mt-1">Materi Diunggah</div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-4 md:p-5 flex-row items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-warning/10 text-warning flex items-center justify-center text-lg shrink-0">
                <i class="fas fa-tasks"></i>
            </div>
            <div>
                <div class="text-2xl font-bold leading-none">{{ $tugasAktif }}</div>
                <div class="text-sm opacity-60 mt-1">Tugas Aktif</div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-4 md:p-5 flex-row items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-success/10 text-success flex items-center justify-center text-lg shrink-0">
                <i class="fas fa-inbox"></i>
            </div>
            <div>
                <div class="text-2xl font-bold leading-none">{{ $totalSubmissions }}</div>
                <div class="text-sm opacity-60 mt-1">Tugas Terkumpul</div>
            </div>
        </div>
    </div>
</div>

<!-- 3. AREA KONTEN UTAMA -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- KOLOM KIRI (2/3): TABEL TUGAS TERBARU -->
    <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-0">
                <div class="p-5 flex items-center justify-between border-b border-base-200">
                    <h3 class="font-bold text-base">Tugas & Penilaian Terbaru</h3>
                    <a href="{{ route('teacher.tugas.index') }}" class="text-xs font-semibold text-primary hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full min-w-[540px]">
                        <thead class="bg-base-200">
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Kelas</th>
                                <th>Tenggat</th>
                                <th class="text-center">Terkumpul</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugases->take(5) as $tugas)
                                @php
                                    $isClosed = \Carbon\Carbon::now()->gt($tugas->deadline);
                                    $totalSiswa = $tugas->kelas && $tugas->kelas->siswa ? $tugas->kelas->siswa->count() : 0;
                                    $dikumpulkan = $tugas->submissions ? $tugas->submissions->count() : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="font-bold text-primary">{{ $tugas->judul }}</div>
                                        <div class="text-xs opacity-60">{{ $tugas->mataPelajaran->nama ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline badge-sm">{{ $tugas->kelas->nama_kelas ?? '-' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap text-xs">
                                        <div>{{ $tugas->deadline->format('d M Y, H:i') }}</div>
                                        <span class="text-[11px] font-semibold {{ $isClosed ? 'text-error' : 'text-success' }}">
                                            {{ $isClosed ? 'Ditutup' : 'Aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-ghost badge-sm font-medium">
                                            {{ $dikumpulkan }} / {{ $totalSiswa }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('teacher.tugas.submissions', [$tugas->kelas_id, $tugas->id]) }}" class="btn btn-xs btn-primary">
                                            Nilai
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 opacity-60 text-sm">
                                        Belum ada tugas yang dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN (1/3): KELAS SAYA & MATERI TERAKHIR -->
    <div class="space-y-6">

        <!-- Kartu Kelas Saya -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-base">Kelas Saya</h3>
                    <a href="{{ route('teacher.kelas.index') }}" class="text-xs font-semibold text-primary hover:underline">
                        Semua
                    </a>
                </div>

                <div class="divide-y divide-base-200">
                    @forelse($daftarKelas->take(4) as $itemKelas)
                        <a href="{{ route('teacher.kelas.show', $itemKelas->id) }}" class="py-3 flex items-center justify-between hover:opacity-80 transition">
                            <div>
                                <div class="font-semibold text-sm">{{ $itemKelas->nama_kelas ?? 'Kelas' }}</div>
                                <div class="text-xs opacity-60">
                                    {{ isset($itemKelas->siswa) ? $itemKelas->siswa->count() . ' Siswa' : 'Buka detail kelas' }}
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-xs opacity-40"></i>
                        </a>
                    @empty
                        <div class="py-6 text-center text-sm opacity-60">
                            Lihat daftar kelas di menu <a href="{{ route('teacher.kelas.index') }}" class="text-primary underline">Kelas Saya</a>.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Kartu Materi Terakhir -->
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-base">Materi Terakhir</h3>
                    <a href="{{ route('teacher.materi.index') }}" class="text-xs font-semibold text-primary hover:underline">
                        Semua
                    </a>
                </div>

                <div class="divide-y divide-base-200">
                    @forelse($materis->take(4) as $materi)
                        <div class="py-3 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <div class="font-semibold text-sm truncate text-primary">{{ $materi->judul }}</div>
                                <div class="text-xs opacity-60 truncate">
                                    {{ $materi->kelas->nama_kelas ?? '-' }} &bull; {{ $materi->created_at->format('d M Y') }}
                                </div>
                            </div>
                            @if($materi->file_path)
                                <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="btn btn-ghost btn-xs shrink-0" title="Unduh Materi">
                                    <i class="fas fa-download"></i>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="py-6 text-center text-sm opacity-60">
                            Belum ada materi diunggah.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection