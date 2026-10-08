@extends('layouts.app')
@section('title', 'Unggah Materi')
@section('header_title', 'Unggah Materi - ' . $kelas->nama_kelas)

@section('content')
<div class="card bg-base-100 shadow-sm max-w-2xl mx-auto">
    <div class="card-body">
        <h2 class="card-title text-xl mb-4"><i class="fas fa-file-upload text-primary"></i> Form Unggah Materi</h2>
        
        <!-- Penting: enctype multipart/form-data diperlukan untuk upload file -->
        <form action="{{ route('teacher.materi.store', $kelas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Mata Pelajaran</span></label>
                <select name="mata_pelajaran_id" class="select select-bordered" required>
                    <option value="" disabled selected>Pilih Mata Pelajaran...</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                    @endforeach
                </select>
                @error('mata_pelajaran_id') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Judul Materi</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Bab 1 - Bilangan Bulat" class="input input-bordered" required />
                @error('judul') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Deskripsi / Instruksi Tambahan (Opsional)</span></label>
                <textarea name="deskripsi" class="textarea textarea-bordered h-24" placeholder="Tuliskan ringkasan atau instruksi bagi siswa untuk materi ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">File Lampiran</span></label>
                <input type="file" name="file_materi" class="file-input file-input-bordered file-input-primary w-full" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png" />
                <label class="label"><span class="label-text-alt text-gray-500">Maks. 10 MB (Format: PDF, Word, PPT, JPG, PNG). Kosongkan jika materi hanya berupa teks/deskripsi.</span></label>
                @error('file_materi') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('teacher.kelas.show', $kelas->id) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Unggah Materi</button>
            </div>
        </form>
    </div>
</div>
@endsection