<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card w-96 bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title justify-center text-2xl font-bold mb-4">LMS Sekolah Dasar</h2>
        <p class="text-center text-sm text-gray-500 mb-6">Silakan login untuk mengakses akun Anda.</p>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" class="input input-bordered w-full @error('username') input-error @enderror" required autofocus/>
                @error('username')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="password" placeholder="Masukkan password" class="input input-bordered w-full" required />
            </div>

            <div class="form-control w-full mb-6">
                <label class="cursor-pointer label justify-start gap-2">
                    <input type="checkbox" name="remember" class="checkbox checkbox-sm checkbox-primary" />
                    <span class="label-text">Ingat Saya</span>
                </label>
            </div>

            <div class="card-actions justify-end">
                <button type="submit" class="btn btn-primary w-full">Masuk</button>
            </div>
        </form>
    </div>
</div>
@endsection