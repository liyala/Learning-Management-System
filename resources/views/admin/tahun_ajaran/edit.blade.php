@extends('layouts.app')
@section('title', 'Edit Tahun Ajaran')
@section('header_title', 'Edit Tahun Ajaran')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-lg mx-auto">
    <div class="card-body">
        <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-control mb-6">
                <label class="label"><span class="label-text font-semibold">Nama Tahun Ajaran</span></label>
                <input type="text" name="nama" value="{{ old('nama', $tahunAjaran->nama) }}" class="input input-bordered @error('nama') input-error @enderror" required />
                @error('nama') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection