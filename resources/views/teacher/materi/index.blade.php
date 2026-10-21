@extends('layouts.app')
@section('title', 'Semua Materi')
@section('header_title', 'Pusat Materi Pembelajaran')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold mb-2">Semua Materi yang Diunggah</h2>
    <p class="text-gray-500">Ini adalah riwayat seluruh materi yang pernah Anda bagikan di berbagai kelas.</p>
</div>

<div class="card bg-base-100 shadow-sm">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul Materi</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materis as $materi)
                        <tr>
                            <td class="text-sm whitespace-nowrap">{{ $materi->created_at->format('d M Y') }}</td>
                            <td class="font-bold text-primary">{{ $materi->judul }}</td>
                            <td>{{ $materi->mataPelajaran->nama }}</td>
                            <td><span class="badge badge-outline">{{ $materi->kelas->nama_kelas }}</span></td>
                            <td class="text-center whitespace-nowrap flex justify-center gap-2 items-center">
                                {{-- class="text-center flex justify-center gap-2 items-center" --}}
                                @if($materi->file_path)
                                <button class="btn btn-sm btn-info tooltip" data-tip="Unduh">
                                    <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="text-white"><i class="fas fa-download"></i></a>
                                </button>

                                @endif
                                <button class="btn btn-sm btn-info tooltip" data-tip="Buka Kelas">     
                                <a href="{{ route('teacher.kelas.show', $materi->kelas_id) }}" class="text-white" ><i class="fas fa-door-open"></i></a>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">Anda belum pernah mengunggah materi di kelas mana pun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection