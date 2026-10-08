@extends('layouts.app')
@section('title', 'Tahun Ajaran')
@section('header_title', 'Manajemen Tahun Ajaran')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Daftar Tahun Ajaran</h2>
    <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Tahun Ajaran</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif
@if(session('error'))
    <div class="alert alert-error shadow-sm mb-4"><span>{{ session('error') }}</span></div>
@endif

<div class="card bg-base-100 shadow-sm overflow-x-auto">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tahun Ajaran</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tahunAjarans as $index => $ta)
                <tr>
                    <td>{{ $tahunAjarans->firstItem() + $index }}</td>
                    <td class="font-semibold">{{ $ta->nama }}</td>
                    <td>
                        @if($ta->status === 'active')
                            <span class="badge badge-success gap-1"><i class="fas fa-check-circle"></i> Aktif</span>
                        @else
                            <span class="badge badge-ghost gap-1">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="text-center flex justify-center gap-2">
                        @if($ta->status !== 'active')
                            <form action="{{ route('admin.tahun-ajaran.set-active', $ta->id) }}" method="POST" onsubmit="return confirm('Aktifkan tahun ajaran ini? Tahun ajaran lain akan otomatis dinonaktifkan.');">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success text-white tooltip" data-tip="Set Aktif"><i class="fas fa-check"></i></button>
                            </form>
                        @endif
                        <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id) }}" method="POST" onsubmit="return confirm('Hapus tahun ajaran ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error text-white" {{ $ta->status === 'active' ? 'disabled' : '' }}><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">Belum ada data tahun ajaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $tahunAjarans->links() }}</div>
@endsection