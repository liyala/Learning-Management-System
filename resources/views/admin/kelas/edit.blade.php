@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('header_title', 'Edit Data Kelas')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-2xl mx-auto">
    <div class="card-body">
        <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Nama Kelas</span></label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" class="input input-bordered @error('nama_kelas') input-error @enderror" required />
                @error('nama_kelas') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Tahun Ajaran</span></label>
                    <select name="tahun_ajaran_id" class="select select-bordered" required>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}" {{ $kelas->tahun_ajaran_id == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama }} {{ $ta->status == 'active' ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Guru / Wali Kelas</span></label>
                    <select name="guru_id" class="select select-bordered" required>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ $kelas->guru_id == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Deskripsi (Opsional)</span></label>
                <textarea name="deskripsi" class="textarea textarea-bordered h-24">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
            </div>

            <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">Status Kelas</span></label>
                <select name="status" class="select select-bordered" required>
                    <option value="active" {{ $kelas->status == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="archived" {{ $kelas->status == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Update Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection