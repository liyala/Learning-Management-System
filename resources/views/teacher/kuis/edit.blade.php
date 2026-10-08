@extends('layouts.app')
@section('title', 'Edit Kuis')
@section('header_title', 'Edit Pengaturan Kuis')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-3xl mx-auto">
    <div class="card-body">
        <h2 class="card-title text-xl mb-4"><i class="fas fa-edit text-info"></i> Edit Pengaturan: {{ $kuis->judul }}</h2>
        
        <form action="{{ route('teacher.kuis.update', [$kelas->id, $kuis->id]) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Mata Pelajaran</span></label>
                    <select name="mata_pelajaran_id" class="select select-bordered" required>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ $kuis->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Status Penerbitan</span></label>
                    <select name="status" class="select select-bordered" required>
                        <option value="draft" {{ $kuis->status == 'draft' ? 'selected' : '' }}>Draft (Siswa tidak bisa melihat)</option>
                        <option value="published" {{ $kuis->status == 'published' ? 'selected' : '' }}>Published (Akan muncul di siswa)</option>
                    </select>
                </div>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Judul Kuis / Ujian</span></label>
                <input type="text" name="judul" value="{{ old('judul', $kuis->judul) }}" class="input input-bordered" required />
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Deskripsi / Peraturan (Opsional)</span></label>
                <textarea name="deskripsi" class="textarea textarea-bordered h-20">{{ old('deskripsi', $kuis->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Durasi (Menit)</span></label>
                    <input type="number" name="durasi_menit" class="input input-bordered" value="{{ old('durasi_menit', $kuis->durasi_menit) }}" min="5" required />
                </div>
                <!-- Perhatikan format string datetime-local (Y-m-d\TH:i) agar bisa dibaca browser -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Bisa Diakses Mulai</span></label>
                    <input type="datetime-local" name="waktu_mulai" class="input input-bordered" value="{{ old('waktu_mulai', $kuis->waktu_mulai->format('Y-m-d\TH:i')) }}" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Batas Akhir Akses</span></label>
                    <input type="datetime-local" name="waktu_selesai" class="input input-bordered" value="{{ old('waktu_selesai', $kuis->waktu_selesai->format('Y-m-d\TH:i')) }}" required />
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection