@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('header_title', 'Tambah Kelas Baru')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-2xl mx-auto">
    <div class="card-body">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Nama Kelas</span></label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: Kelas 1A" class="input input-bordered @error('nama_kelas') input-error @enderror" required />
                @error('nama_kelas') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tahun Ajaran</span></label>
                    <select name="tahun_ajaran_id" class="select select-bordered" required>
                        <option value="" disabled selected>Pilih Tahun Ajaran...</option>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->nama }} {{ $ta->status == 'active' ? '(Aktif)' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Guru / Wali Kelas</span></label>
                    <select name="guru_id" class="select select-bordered" required>
                        <option value="" disabled selected>Pilih Guru...</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">Deskripsi (Opsional)</span></label>
                <textarea name="deskripsi" class="textarea textarea-bordered h-24" placeholder="Informasi tambahan mengenai kelas ini">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection