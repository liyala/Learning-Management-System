@extends('layouts.app')
@section('title', 'Nilai & Rapor')
@section('header_title', 'Rekapitulasi Nilai & Rapor')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold mb-2">Transkrip Nilai Akademik</h2>
    <p class="text-gray-500">Berikut adalah rekapitulasi rata-rata nilai per mata pelajaran dan riwayat tugasmu.</p>
</div>

<!-- Bagian 1: Mini Rapor (Rata-rata per Mapel) -->
<h3 class="font-bold text-lg mb-4 border-b pb-2"><i class="fas fa-chart-bar text-primary"></i> Rata-rata per Mata Pelajaran</h3>
<div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4 mb-8">
    @forelse($rapor as $mapel => $data)
        <div class="card bg-base-100 shadow-sm border border-gray-100">
            <div class="card-body p-5 text-center">
                <h4 class="font-bold text-md text-gray-600 mb-2">{{ $mapel }}</h4>
                <div class="radial-progress text-primary font-bold mx-auto" 
                     style="--value:{{ $data['rata_rata'] }}; --size:5rem; --thickness: 0.5rem;" 
                     role="progressbar">
                    {{ $data['rata_rata'] }}
                </div>
                <p class="text-xs text-gray-400 mt-3">Dari {{ $data['total_dinilai'] }} Tugas Dinilai</p>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="alert alert-info bg-blue-50 text-blue-800 shadow-sm">
                <i class="fas fa-info-circle"></i> Belum ada tugas yang dinilai oleh guru untuk merangkum rata-rata.
            </div>
        </div>
    @endforelse
</div>

<!-- Bagian 2: Riwayat Detail Tugas -->
<h3 class="font-bold text-lg mb-4 border-b pb-2"><i class="fas fa-history text-info"></i> Riwayat Pengumpulan Tugas</h3>
<div class="card bg-base-100 shadow-sm">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                    <tr>
                        <th class="py-4">Mata Pelajaran</th>
                        <th>Judul Tugas</th>
                        <th>Tanggal Kumpul</th>
                        <th class="text-center">Nilai</th>
                        <th>Catatan Guru</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $sub)
                        <tr>
                            <td class="font-semibold">{{ $sub->tugas->mataPelajaran->nama }}</td>
                            <td>{{ $sub->tugas->judul }}</td>
                            <td class="text-sm">{{ $sub->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center font-bold text-lg">
                                @if($sub->nilai !== null)
                                    <span class="{{ $sub->nilai < 70 ? 'text-error' : 'text-success' }}">{{ $sub->nilai }}</span>
                                @else
                                    <span class="badge badge-ghost badge-sm">Menunggu</span>
                                @endif
                            </td>
                            <td class="text-sm italic text-gray-500 max-w-xs truncate" title="{{ $sub->feedback }}">
                                {{ $sub->feedback ?: '-' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('student.tugas.show', [$sub->tugas->kelas_id, $sub->tugas_id]) }}" class="btn btn-xs btn-primary btn-outline">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">Kamu belum pernah mengumpulkan tugas apapun. Ayo mulai kerjakan tugasmu!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection