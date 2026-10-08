@extends('layouts.app')
@section('title', 'Manajemen Kelas')
@section('header_title', 'Manajemen Kelas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Daftar Kelas</h2>
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kelas</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif

<div class="card bg-base-100 shadow-sm overflow-x-auto">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Wali Kelas / Guru</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelases as $index => $kelas)
                <tr>
                    <td>{{ $kelases->firstItem() + $index }}</td>
                    <td class="font-semibold">{{ $kelas->nama_kelas }}</td>
                    <td>
                        {{ $kelas->tahunAjaran->nama }}
                        @if($kelas->tahunAjaran->status === 'active')
                            <span class="badge badge-success badge-xs ml-1">Aktif</span>
                        @endif
                    </td>
                    <td>{{ $kelas->guru->nama }}</td>
                    <td>
                        @if($kelas->status === 'active')
                            <span class="badge badge-primary badge-sm">Aktif</span>
                        @else
                            <span class="badge badge-ghost badge-sm">Diarsipkan</span>
                        @endif
                    </td>
                    <td class="text-center flex justify-center gap-2">
                        <!-- Tombol Anggota & Jadwal -->
                        <a href="{{ route('admin.kelas.anggota.index', $kelas->id) }}" class="btn btn-sm btn-success text-white tooltip" data-tip="Anggota Kelas"><i class="fas fa-users"></i></a>
                        <a href="{{ route('admin.kelas.jadwal.index', $kelas->id) }}" class="btn btn-sm btn-warning text-white tooltip" data-tip="Jadwal Pelajaran"><i class="fas fa-calendar-alt"></i></a>
                        
                        <!-- Tombol Edit & Hapus (Sudah ada) -->
                        <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-4">Belum ada data kelas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $kelases->links() }}</div>
@endsection