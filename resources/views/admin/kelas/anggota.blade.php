@extends('layouts.app')
@section('title', 'Anggota Kelas')
@section('header_title', 'Anggota Kelas: ' . $kelas->nama_kelas)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelas</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sisi Kiri: Informasi Kelas & Form Tambah Siswa -->
    <div class="lg:col-span-1 space-y-6">
        <div class="card bg-base-100 shadow-sm border-t-4 border-primary">
            <div class="card-body">
                <h2 class="card-title text-lg">Informasi Kelas</h2>
                <ul class="text-sm space-y-2 mt-2">
                    <li><strong>Nama Kelas:</strong> {{ $kelas->nama_kelas }}</li>
                    <li><strong>Tahun Ajaran:</strong> {{ $kelas->tahunAjaran->nama }}</li>
                    <li><strong>Wali Kelas:</strong> {{ $kelas->guru->nama }}</li>
                    <li><strong>Total Siswa:</strong> <span class="badge badge-primary">{{ $anggota->count() }}</span></li>
                </ul>
            </div>
        </div>

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-lg">Tambah Siswa</h2>
                <form action="{{ route('admin.kelas.anggota.store', $kelas->id) }}" method="POST">
                    @csrf
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Pilih Siswa</span></label>
                        <select name="siswa_id" class="select select-bordered w-full" required>
                            <option value="" disabled selected>-- Pilih Siswa --</option>
                            @forelse($siswaTersedia as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} ({{ $siswa->username }})</option>
                            @empty
                                <option value="" disabled>Semua siswa sudah masuk kelas ini</option>
                            @endforelse
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full" {{ $siswaTersedia->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-plus"></i> Tambahkan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sisi Kanan: Daftar Siswa -->
    <div class="lg:col-span-2">
        @if(session('success'))
            <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
        @endif
        @if(session('error'))
            <div class="alert alert-error shadow-sm mb-4"><span>{{ session('error') }}</span></div>
        @endif

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Daftar Siswa di Kelas</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggota as $index => $siswa)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-semibold">{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->username }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.kelas.anggota.destroy', [$kelas->id, $siswa->id]) }}" method="POST" onsubmit="return confirm('Keluarkan siswa ini dari kelas? Data nilai di kelas ini mungkin akan terpengaruh.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error text-white tooltip" data-tip="Keluarkan Siswa"><i class="fas fa-user-minus"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-500">Belum ada siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection