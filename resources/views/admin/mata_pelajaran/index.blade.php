@extends('layouts.app')
@section('title', 'Mata Pelajaran')
@section('header_title', 'Master Mata Pelajaran')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah -->
    <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Tambah Baru</h2>
                <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
                    @csrf
                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text font-semibold">Kode Pelajaran</span></label>
                        <input type="text" name="kode" placeholder="Misal: MAT, IND, IPA" class="input input-bordered" required>
                    </div>
                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text font-semibold">Nama Pelajaran</span></label>
                        <input type="text" name="nama" placeholder="Misal: Matematika" class="input input-bordered" required>
                    </div>
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text font-semibold">Deskripsi</span></label>
                        <textarea name="deskripsi" class="textarea textarea-bordered h-20"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full"><i class="fas fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="lg:col-span-2">
        @if(session('success'))
            <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
        @endif
        @if($errors->any())
            <div class="alert alert-error shadow-sm mb-4">
                <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Daftar Mata Pelajaran</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mapels as $mapel)
                                <tr>
                                    <td class="font-mono">{{ $mapel->kode }}</td>
                                    <td class="font-semibold">{{ $mapel->nama }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.mata-pelajaran.destroy', $mapel->id) }}" method="POST" onsubmit="return confirm('Hapus pelajaran ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-gray-500 py-4">Belum ada data mata pelajaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $mapels->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection