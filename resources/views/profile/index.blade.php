@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header_title', 'Profil Pengguna')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- 1. HEADER PROFIL (Avatar & Info Singkat) -->
    <div class="card bg-base-100 shadow-md">
        <div class="card-body p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 md:gap-8">
            
            <!-- Avatar Inisial Bulat -->
            <div class="avatar placeholder">
                <div class="bg-primary text-primary-content rounded-full w-24 h-24 md:w-32 md:h-32 text-4xl md:text-5xl font-bold shadow-sm">
                    <span>{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                </div>
            </div>
            
            <!-- Teks Info -->
            <div class="text-center md:text-left flex-1">
                <h2 class="text-2xl md:text-3xl font-extrabold">{{ $user->nama }}</h2>
                <p class="text-base opacity-70 mt-1 capitalize font-medium">{{ $user->role->name }}</p>
                
                <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-3">
                    <span class="badge badge-primary badge-outline badge-md py-3 px-4 font-semibold">
                        <i class="fas fa-id-badge mr-2"></i> {{ $user->username ?? $user->email ?? 'User LMS' }}
                    </span>
                    <span class="badge badge-ghost badge-md py-3 px-4 font-medium">
                        <i class="fas fa-calendar-alt mr-2"></i> Bergabung {{ $user->created_at->translatedFormat('F Y') }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- 2. DETAIL INFORMASI (Form Read-Only) -->
    <div class="card bg-base-100 shadow-md">
        <div class="card-body p-6 md:p-8">
            <h3 class="text-xl font-bold mb-6 border-b border-base-200 pb-3">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Field Nama -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold opacity-70">Nama Lengkap</span>
                    </label>
                    <input type="text" value="{{ $user->nama }}" class="input input-bordered input-lg w-full bg-base-200/50 font-medium" readonly />
                </div>

                <!-- Field Username / NIP / NIS -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold opacity-70">Username / NIP / NIS</span>
                    </label>
                    <!-- Sesuaikan pemanggilan kolom 'username' dengan nama kolom di database Anda -->
                    <input type="text" value="{{ $user->username ?? '-' }}" class="input input-bordered input-lg w-full bg-base-200/50 font-medium" readonly />
                </div>

                <!-- Field Email -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold opacity-70">Email</span>
                    </label>
                    <input type="email" value="{{ $user->email ?? '-' }}" class="input input-bordered input-lg w-full bg-base-200/50 font-medium" readonly />
                </div>

                <!-- Field Role -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold opacity-70">Peran (Role)</span>
                    </label>
                    <input type="text" value="{{ ucfirst($user->role->name) }}" class="input input-bordered input-lg w-full bg-base-200/50 font-medium capitalize" readonly />
                </div>
            </div>
{{-- {{ Auth::user()->role->name }} --}}
            <!-- Tombol Edit (Siap untuk tahap selanjutnya) -->
            <div class="mt-8 flex justify-end gap-3">
                <button class="btn btn-primary md:btn-lg shadow-sm" disabled title="Fitur ubah profil akan segera hadir">
                    <i class="fas fa-user-edit"></i> Edit Profil
                </button>
            </div>
            
        </div>
    </div>

</div>
@endsection