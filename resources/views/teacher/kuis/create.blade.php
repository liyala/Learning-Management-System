@extends('layouts.app')
@section('title', 'Buat Kuis Baru')
@section('header_title', 'Buat Kuis / Ujian Baru')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-3xl mx-auto">
    <div class="card-body">
        <h2 class="card-title text-xl mb-4"><i class="fas fa-laptop-code text-primary"></i> Pengaturan Kuis</h2>
        
        <form action="{{ route('teacher.kuis.store', $kelas->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Mata Pelajaran</span></label>
                    <select name="mata_pelajaran_id" class="select select-bordered" required>
                        <option value="" disabled selected>Pilih...</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Status Penerbitan</span></label>
                    <select name="status" class="select select-bordered" required>
                        <option value="draft">Draft (Siswa tidak bisa melihat)</option>
                        <option value="published">Published (Akan muncul di siswa)</option>
                    </select>
                </div>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Judul Kuis / Ujian</span></label>
                <input type="text" name="judul" class="input input-bordered" placeholder="Contoh: Ujian Tengah Semester IPA" required />
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Deskripsi / Peraturan (Opsional)</span></label>
                <textarea name="deskripsi" class="textarea textarea-bordered h-20" placeholder="Contoh: Kerjakan dengan jujur. Waktu akan berjalan saat Anda klik 'Mulai'."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Durasi (Menit)</span></label>
                    <input type="number" name="durasi_menit" class="input input-bordered" value="60" min="5" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Bisa Diakses Mulai</span></label>
                    <input type="datetime-local" name="waktu_mulai" class="input input-bordered" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Batas Akhir Akses</span></label>
                    <input type="datetime-local" name="waktu_selesai" class="input input-bordered" required />
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan & Lanjut Buat Soal</button>
            </div>
        </form>
    </div>
</div>
@endsection