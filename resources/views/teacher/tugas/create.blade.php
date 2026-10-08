@extends('layouts.app')
@section('title', 'Buat Tugas Baru')
@section('header_title', 'Buat Tugas - ' . $kelas->nama_kelas)

@section('content')
<div class="card bg-base-100 shadow-sm max-w-3xl mx-auto">
    <div class="card-body">
        <h2 class="card-title text-xl mb-4"><i class="fas fa-edit text-primary"></i> Form Buat Tugas Baru</h2>
        
        <form action="{{ route('teacher.tugas.store', $kelas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Mata Pelajaran</span></label>
                    <select name="mata_pelajaran_id" class="select select-bordered" required>
                        <option value="" disabled selected>Pilih Mata Pelajaran...</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tenggat Waktu (Deadline)</span></label>
                    <input type="datetime-local" name="deadline" value="{{ old('deadline') }}" class="input input-bordered @error('deadline') input-error @enderror" required />
                    @error('deadline') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Judul Tugas</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Latihan Soal Bab 1" class="input input-bordered" required />
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Instruksi Tugas</span></label>
                <textarea name="deskripsi" class="textarea textarea-bordered h-32" placeholder="Tuliskan instruksi pengerjaan secara detail..." required>{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">File Pendukung (Opsional)</span></label>
                <input type="file" name="file_pendukung" class="file-input file-input-bordered file-input-warning w-full" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png" />
                <label class="label"><span class="label-text-alt text-gray-500">Maks. 10 MB. Gunakan jika ada soal berupa file.</span></label>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Terbitkan Tugas</button>
            </div>
        </form>
    </div>
</div>
@endsection