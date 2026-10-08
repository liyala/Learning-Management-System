@extends('layouts.app')
@section('title', 'Kerjakan Tugas')
@section('header_title', 'Tugas: ' . $tugas->judul)

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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Instruksi Tugas -->
    <div class="card bg-base-100 shadow-sm border-t-4 border-primary">
        <div class="card-body">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="card-title text-xl text-primary">{{ $tugas->judul }}</h2>
                    <p class="text-sm font-semibold text-gray-500">{{ $tugas->mataPelajaran->nama }}</p>
                </div>
                <div class="badge {{ \Carbon\Carbon::now()->gt($tugas->deadline) ? 'badge-error' : 'badge-warning' }} text-white p-3 font-bold">
                    Tenggat: {{ $tugas->deadline->format('d M Y, H:i') }}
                </div>
            </div>
            
            <div class="bg-base-200 p-4 rounded-lg mb-4 text-sm text-gray-700 whitespace-pre-line">
                <strong>Instruksi Guru:</strong>
                {{ $tugas->deskripsi }}
            </div>

            @if($tugas->file_pendukung)
                <a href="{{ asset('storage/' . $tugas->file_pendukung) }}" target="_blank" class="btn btn-outline btn-info w-full"><i class="fas fa-download"></i> Unduh File Soal/Materi dari Guru</a>
            @endif
        </div>
    </div>

    <!-- Form Pengumpulan -->
    <div class="card bg-base-100 shadow-sm border-t-4 {{ $submission && $submission->nilai !== null ? 'border-success' : 'border-info' }}">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4"><i class="fas fa-upload text-info"></i> Form Pengumpulan Tugas</h2>
            
            @if($submission && $submission->nilai !== null)
                <!-- Jika Tugas Sudah Dinilai -->
                <div class="alert alert-success bg-green-100 text-green-800 mb-4 rounded-lg">
                    <div>
                        <h3 class="font-bold"><i class="fas fa-check-circle"></i> Tugas Telah Dinilai!</h3>
                        <p class="text-4xl font-black text-primary mt-2 mb-1">Skor: {{ $submission->nilai }}</p>
                        @if($submission->feedback)
                            <p class="text-sm bg-white p-2 rounded mt-2 border border-green-200"><strong>Catatan Guru:</strong> "{{ $submission->feedback }}"</p>
                        @endif
                    </div>
                </div>
                <a href="{{ asset('storage/' . $submission->file_jawaban) }}" target="_blank" class="btn btn-sm btn-outline mb-4">Lihat File yang Kamu Kumpulkan</a>
            @else
                <!-- Jika Belum Dinilai / Form Submit -->
                @if($submission)
                    <div class="alert alert-info bg-blue-100 text-blue-800 mb-4 p-3 rounded-lg text-sm">
                        <i class="fas fa-info-circle"></i> Kamu sudah mengumpulkan tugas. Unggah ulang untuk mengganti file lama.
                    </div>
                @endif
                
                <form action="{{ route('student.tugas.submit', [$kelas->id, $tugas->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text font-bold">File Jawaban</span></label>
                        <input type="file" name="file_jawaban" class="file-input file-input-bordered file-input-primary w-full" required accept=".pdf,.doc,.docx,.jpg,.png" />
                        @if($submission)
                            <label class="label"><span class="label-text-alt text-success"><i class="fas fa-check"></i> File lama telah tersimpan.</span></label>
                        @endif
                    </div>
                    <div class="form-control mb-6">
                        <label class="label"><span class="label-text font-bold">Pesan untuk Guru (Opsional)</span></label>
                        <textarea name="catatan_siswa" class="textarea textarea-bordered h-24" placeholder="Tuliskan pesan jika ada kesulitan...">{{ $submission->catatan_siswa ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full text-lg"><i class="fas fa-paper-plane"></i> Kumpulkan Jawaban</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection