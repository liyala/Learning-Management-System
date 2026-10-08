@extends('layouts.app')

@section('title', 'Edit User')
@section('header_title', 'Edit Data Pengguna')

@section('content')
<div class="card bg-base-100 shadow-sm max-w-2xl mx-auto">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="input input-bordered @error('nama') input-error @enderror" required />
                @error('nama') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Username</span></label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="input input-bordered @error('username') input-error @enderror" required />
                    @error('username') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Email</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered @error('email') input-error @enderror" required />
                    @error('email') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Role (Peran)</span></label>
                    <select name="role_id" class="select select-bordered @error('role_id') select-error @enderror" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Password Baru</span>
                        <span class="label-text-alt text-gray-500">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered @error('password') input-error @enderror" />
                    @error('password') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection