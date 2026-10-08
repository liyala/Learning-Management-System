@extends('layouts.app')
@section('title', 'Kelola Soal Kuis')
@section('header_title', 'Manajemen Kuis: ' . $kuis->judul)

@section('content')
<div class="mb-4">
    <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Kelas</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Form Tambah Soal -->
    <div class="xl:col-span-1">
        <div class="card bg-base-100 shadow-sm border-t-4 border-primary">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4"><i class="fas fa-plus-circle"></i> Tambah Butir Soal Baru</h2>
                <form action="{{ route('teacher.kuis.soal.store', [$kelas->id, $kuis->id]) }}" method="POST">
                    @csrf
                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text font-semibold">Pertanyaan</span></label>
                        <textarea name="pertanyaan" class="textarea textarea-bordered h-24" required></textarea>
                    </div>
                    
                    <div class="space-y-2 mb-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-bold w-6">A.</span>
                            <input type="text" name="opsi_a" class="input input-bordered input-sm w-full" required>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold w-6">B.</span>
                            <input type="text" name="opsi_b" class="input input-bordered input-sm w-full" required>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold w-6">C.</span>
                            <input type="text" name="opsi_c" class="input input-bordered input-sm w-full" required>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold w-6">D.</span>
                            <input type="text" name="opsi_d" class="input input-bordered input-sm w-full" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-6">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Kunci Jawaban</span></label>
                            <select name="kunci_jawaban" class="select select-bordered select-sm" required>
                                <option value="a">Opsi A</option>
                                <option value="b">Opsi B</option>
                                <option value="c">Opsi C</option>
                                <option value="d">Opsi D</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Bobot Nilai</span></label>
                            <input type="number" name="bobot" value="1" min="1" class="input input-bordered input-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full"><i class="fas fa-save"></i> Simpan Soal</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Soal Tersimpan -->
    <div class="xl:col-span-2">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="card-title"><i class="fas fa-list"></i> Daftar Soal ({{ $kuis->soal->count() }} Butir)</h2>
                    <span class="badge {{ $kuis->status == 'published' ? 'badge-success' : 'badge-ghost' }}">{{ strtoupper($kuis->status) }}</span>
                </div>

                <div class="space-y-4">
                    @forelse($kuis->soal as $index => $soal)
                        <div class="bg-base-200 p-4 rounded-lg relative">
                            <div class="flex gap-3 mb-2">
                                <span class="font-bold text-lg">{{ $index + 1 }}.</span>
                                <p class="text-gray-800 whitespace-pre-line">{{ $soal->pertanyaan }}</p>
                            </div>
                            <div class="ml-7 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                <div class="p-2 rounded {{ $soal->kunci_jawaban == 'a' ? 'bg-success text-white font-bold' : 'bg-white' }}">A. {{ $soal->opsi_a }}</div>
                                <div class="p-2 rounded {{ $soal->kunci_jawaban == 'b' ? 'bg-success text-white font-bold' : 'bg-white' }}">B. {{ $soal->opsi_b }}</div>
                                <div class="p-2 rounded {{ $soal->kunci_jawaban == 'c' ? 'bg-success text-white font-bold' : 'bg-white' }}">C. {{ $soal->opsi_c }}</div>
                                <div class="p-2 rounded {{ $soal->kunci_jawaban == 'd' ? 'bg-success text-white font-bold' : 'bg-white' }}">D. {{ $soal->opsi_d }}</div>
                            </div>
                            
                            <form action="{{ route('teacher.kuis.soal.destroy', [$kelas->id, $kuis->id, $soal->id]) }}" method="POST" class="absolute top-4 right-4" onsubmit="return confirm('Hapus soal ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-error hover:text-red-700 tooltip" data-tip="Hapus Soal"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-8">
                            <i class="fas fa-question-circle text-4xl mb-3"></i>
                            <p>Belum ada soal untuk kuis ini. Silakan buat soal menggunakan form di samping.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection