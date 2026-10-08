@extends('layouts.app')
@section('title', 'Semua Tugas')
@section('header_title', 'Pusat Tugas & Penilaian')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold mb-2">Daftar Seluruh Tugas Aktif & Arsip</h2>
    <p class="text-gray-500">Pantau tenggat waktu dan berikan nilai tugas dari berbagai kelas di satu tempat.</p>
</div>

<div class="card bg-base-100 shadow-sm">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                    <tr>
                        <th>Status / Deadline</th>
                        <th>Judul Tugas</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th class="text-center">Progres Pengumpulan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugases as $tugas)
                        @php 
                            $isClosed = \Carbon\Carbon::now()->gt($tugas->deadline); 
                            $totalSiswa = $tugas->kelas->siswa->count();
                            $dikumpulkan = $tugas->submissions->count();
                        @endphp
                        <tr>
                            <td class="whitespace-nowrap">
                                @if($isClosed)
                                    <span class="badge badge-error badge-sm text-white mb-1 w-full">Ditutup</span><br>
                                @else
                                    <span class="badge badge-success badge-sm text-white mb-1 w-full">Aktif</span><br>
                                @endif
                                <span class="text-xs text-gray-500">{{ $tugas->deadline->format('d M Y, H:i') }}</span>
                            </td>
                            <td class="font-bold text-primary">{{ $tugas->judul }}</td>
                            <td>{{ $tugas->mataPelajaran->nama }}</td>
                            <td><span class="badge badge-outline">{{ $tugas->kelas->nama_kelas }}</span></td>
                            <td class="text-center">
                                <div class="badge {{ $dikumpulkan == $totalSiswa && $totalSiswa > 0 ? 'badge-success text-white' : 'badge-warning' }} font-bold">
                                    {{ $dikumpulkan }} / {{ $totalSiswa }}
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('teacher.tugas.submissions', [$tugas->kelas_id, $tugas->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Cek & Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">Anda belum pernah membuat tugas di kelas mana pun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection