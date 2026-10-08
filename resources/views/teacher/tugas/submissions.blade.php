@extends('layouts.app')
@section('title', 'Penilaian Tugas')
@section('header_title', 'Penilaian Tugas')

@section('content')
<div class="mb-4">
    <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Detail Kelas</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif

<!-- Info Tugas -->
<div class="card bg-base-100 shadow-sm border-t-4 border-primary mb-6">
    <div class="card-body">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="card-title text-xl text-primary mb-1">{{ $tugas->judul }}</h2>
                <p class="text-sm font-semibold text-gray-600 mb-4">{{ $tugas->mataPelajaran->nama }} • Kelas {{ $kelas->nama_kelas }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 mb-1">Tenggat Waktu:</p>
                <div class="badge {{ \Carbon\Carbon::now()->gt($tugas->deadline) ? 'badge-error' : 'badge-warning' }} text-white font-bold p-3">
                    {{ $tugas->deadline->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
        <div class="bg-base-200 p-4 rounded-lg text-sm text-gray-700">
            <strong>Instruksi:</strong><br>
            {{ $tugas->deskripsi }}
        </div>
    </div>
</div>

<!-- Tabel Pengumpulan -->
<div class="card bg-base-100 shadow-sm">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title"><i class="fas fa-users text-info"></i> Status Pengumpulan Siswa</h2>
            <div class="badge badge-primary">{{ $submissions->count() }} / {{ $siswaList->count() }} Mengumpulkan</div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Waktu Kumpul</th>
                        <th>File / Jawaban</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaList as $siswa)
                        @php $submission = $submissions->has($siswa->id) ? $submissions[$siswa->id] : null; @endphp
                        <tr>
                            <td class="font-semibold">{{ $siswa->nama }}</td>
                            <td>
                                @if($submission)
                                    @if($submission->created_at->gt($tugas->deadline))
                                        <span class="text-error text-sm tooltip" data-tip="Terlambat"><i class="fas fa-exclamation-circle"></i> {{ $submission->created_at->format('d/m/Y H:i') }}</span>
                                    @else
                                        <span class="text-success text-sm"><i class="fas fa-check-circle"></i> {{ $submission->created_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-sm italic">Belum mengumpulkan</span>
                                @endif
                            </td>
                            <td>
                                @if($submission)
                                    <a href="{{ asset('storage/' . $submission->file_jawaban) }}" target="_blank" class="btn btn-xs btn-outline btn-info"><i class="fas fa-download"></i> Unduh File</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center font-bold text-lg {{ $submission && $submission->nilai ? 'text-primary' : 'text-gray-400' }}">
                                {{ $submission->nilai ?? '-' }}
                            </td>
                            <td class="text-center">
                                @if($submission)
                                    <!-- Tombol Buka Modal Penilaian -->
                                    <button class="btn btn-sm btn-primary" onclick="document.getElementById('modal_nilai_{{ $submission->id }}').showModal()">
                                        <i class="fas fa-star"></i> Beri Nilai
                                    </button>

                                    <!-- Modal Penilaian (DaisyUI) -->
                                    <dialog id="modal_nilai_{{ $submission->id }}" class="modal">
                                        <div class="modal-box text-left">
                                            <form method="dialog">
                                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="font-bold text-lg mb-4">Penilaian: {{ $siswa->nama }}</h3>
                                            
                                            @if($submission->catatan_siswa)
                                                <div class="bg-base-200 p-3 rounded mb-4 text-sm">
                                                    <strong>Catatan Siswa:</strong> "{{ $submission->catatan_siswa }}"
                                                </div>
                                            @endif

                                            <form action="{{ route('teacher.tugas.grade', [$kelas->id, $tugas->id, $submission->id]) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="form-control mb-4">
                                                    <label class="label"><span class="label-text font-bold">Skor Nilai (0 - 100)</span></label>
                                                    <input type="number" name="nilai" value="{{ $submission->nilai }}" class="input input-bordered input-primary text-xl font-bold w-full" min="0" max="100" required>
                                                </div>
                                                <div class="form-control mb-6">
                                                    <label class="label"><span class="label-text font-bold">Feedback / Umpan Balik (Opsional)</span></label>
                                                    <textarea name="feedback" class="textarea textarea-bordered h-24" placeholder="Berikan komentar untuk pekerjaan siswa ini...">{{ $submission->feedback }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-full"><i class="fas fa-save"></i> Simpan Nilai</button>
                                            </form>
                                        </div>
                                    </dialog>
                                @else
                                    <button class="btn btn-sm btn-disabled" disabled>Beri Nilai</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection