@extends('layouts.app')
@section('title', 'Tambah Tahun Ajaran')
@section('header_title', 'Tambah Tahun Ajaran')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-lg mx-auto">
    <div class="card-body">
        <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST">
            @csrf
            <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">Nama Tahun Ajaran</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: 2026/2027 Ganjil" class="input input-bordered @error('nama') input-error @enderror" required autofocus />
                @error('nama') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection