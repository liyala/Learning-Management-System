@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header_title', 'Manajemen User')

@section('content')
<div class="flex justify-between items-center mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, email..." class="input input-bordered w-full max-w-xs" />
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error shadow-sm mb-4">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="card bg-base-100 shadow-sm overflow-x-auto">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td class="font-semibold">{{ $user->nama }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role->name === 'admin')
                            <span class="badge badge-primary badge-sm">Admin</span>
                        @elseif($user->role->name === 'guru')
                            <span class="badge badge-success badge-sm">Guru</span>
                        @else
                            <span class="badge badge-warning badge-sm">Siswa</span>
                        @endif
                    </td>
                    <td class="text-center flex justify-center gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Data pengguna tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection