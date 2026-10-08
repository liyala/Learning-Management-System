@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')
@section('header_title', 'Jadwal Pelajaran: ' . $kelas->nama_kelas)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelas</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif
@if($errors->any())
    <div class="alert alert-error shadow-sm mb-4">
        <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah Jadwal -->
    <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-sm border-t-4 border-warning">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Tambah Jadwal Baru</h2>
                <form action="{{ route('admin.kelas.jadwal.store', $kelas->id) }}" method="POST">
                    @csrf
                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text font-semibold">Mata Pelajaran</span></label>
                        <select name="mata_pelajaran_id" class="select select-bordered" required>
                            <option value="" disabled selected>Pilih Mata Pelajaran...</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text font-semibold">Guru Pengajar</span></label>
                        <select name="guru_id" class="select select-bordered" required>
                            @foreach($gurus as $guru)
                                <!-- Default terpilih adalah wali kelasnya -->
                                <option value="{{ $guru->id }}" {{ $kelas->guru_id == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>
                        <label class="label"><span class="label-text-alt text-gray-500">Default: Wali Kelas saat ini</span></label>
                    </div>

                    <div class="form-control mb-3">
                        <label class="label"><span class="label-text font-semibold">Hari</span></label>
                        <select name="hari" class="select select-bordered" required>
                            <option value="" disabled selected>Pilih Hari...</option>
                            @foreach($urutanHari as $hari)
                                <option value="{{ $hari }}">{{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-6">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Jam Mulai</span></label>
                            <input type="time" name="jam_mulai" class="input input-bordered" required>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Jam Selesai</span></label>
                            <input type="time" name="jam_selesai" class="input input-bordered" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning w-full text-white"><i class="fas fa-plus"></i> Tambah Jadwal</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tampilan Jadwal Mingguan -->
    <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Jadwal Kelas : {{ $kelas->nama_kelas }}</h2>
                
                @foreach($urutanHari as $hari)
                    @if(isset($jadwals[$hari]) && $jadwals[$hari]->count() > 0)
                        <div class="mb-6">
                            <h3 class="font-bold text-md mb-2 bg-base-200 p-2 rounded">{{ $hari }}</h3>
                            <div class="overflow-x-auto">
                                <table class="table table-sm w-full border">
                                    <thead class="bg-base-200">
                                        <tr>
                                            <th class="w-1/4">Waktu</th>
                                            <th class="w-1/3">Mata Pelajaran</th>
                                            <th class="w-1/3">Pengajar</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jadwals[$hari] as $item)
                                            <tr>
                                                <td class="font-mono text-sm">
                                                    {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                                </td>
                                                <td class="font-semibold text-primary">{{ $item->mataPelajaran->nama }}</td>
                                                <td class="text-xs text-gray-600">{{ $item->guru->nama }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.kelas.jadwal.destroy', [$kelas->id, $item->id]) }}" method="POST" onsubmit="return confirm('Hapus jam pelajaran ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-error hover:text-red-700 tooltip" data-tip="Hapus Jam">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
                
                @if($jadwals->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <i class="fas fa-calendar-times text-4xl mb-3"></i>
                        <p>Belum ada jadwal yang diatur untuk kelas ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection