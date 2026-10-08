@extends('layouts.app')
@section('title', 'Detail Kelas')
@section('header_title', 'Kelas: ' . $kelas->nama_kelas)

@section('content')
<div class="mb-4">
    <a href="{{ route('student.kelas.index') }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-4 md:gap-6">
    <!-- Info Kelas (Di HP muncul di atas) -->
    <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-sm border-t-4 border-info">
            <div class="card-body p-4 md:p-5">
                <h2 class="font-bold text-md md:text-lg mb-1">Informasi Kelas</h2>
                <p class="text-xs md:text-sm text-gray-600 flex items-center gap-2">
                    <i class="fas fa-user-tie text-gray-400"></i> 
                    Wali: <span class="font-semibold">{{ $kelas->guru->nama }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Area TABS -->
    <div class="lg:col-span-3">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-2 md:p-6">
                <!-- Kita gunakan tabs-bordered agar lebih rapi saat melipat di HP -->
                <div role="tablist" class="tabs tabs-bordered w-full">
                    
                    <!-- TAB PENGUMUMAN -->
                    <input type="radio" name="tabs" role="tab" class="tab font-bold text-xs md:text-sm whitespace-nowrap" aria-label="Pengumuman" checked />
                    <div role="tabpanel" class="tab-content bg-base-100 p-2 md:p-4 pt-4 md:pt-6">
                        <div class="space-y-4">
                            @forelse($kelas->pengumuman as $pengumuman)
                                <div class="border border-info p-3 md:p-4 rounded-lg bg-blue-50/30">
                                    <div class="flex items-start gap-2 md:gap-3">
                                        <div class="text-info text-xl md:text-2xl mt-1"><i class="fas fa-bullhorn"></i></div>
                                        <div class="w-full">
                                            <div class="flex flex-col md:flex-row md:items-center md:gap-2 mb-1">
                                                <h4 class="font-bold text-xs md:text-sm text-primary">{{ $pengumuman->pembuat->nama }}</h4>
                                                <span class="text-[10px] md:text-xs text-gray-500 md:before:content-['•'] md:before:mr-1">{{ $pengumuman->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs md:text-sm text-gray-800 whitespace-pre-line">{{ $pengumuman->isi }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-400 py-6 text-sm">Belum ada pengumuman dari guru.</div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- TAB MATERI -->
                    <input type="radio" name="tabs" role="tab" class="tab font-bold text-xs md:text-sm whitespace-nowrap" aria-label="Materi" />
                    <div role="tabpanel" class="tab-content bg-base-100 p-2 md:p-4 pt-4 md:pt-6">
                        <div class="space-y-4">
                            @forelse($kelas->materi as $materi)
                                <!-- flex-col di HP, flex-row di Laptop -->
                                <div class="flex flex-col md:flex-row justify-between border border-gray-200 p-3 md:p-4 rounded-lg bg-white gap-3 md:gap-4 hover:border-info transition">
                                    <div class="flex gap-3">
                                        <div class="text-2xl md:text-3xl text-info mt-1"><i class="fas fa-book-reader"></i></div>
                                        <div>
                                            <h4 class="font-bold text-sm md:text-md text-primary leading-tight mb-1">{{ $materi->judul }}</h4>
                                            <p class="text-xs md:text-sm text-gray-500 font-semibold">{{ $materi->mataPelajaran->nama }}</p>
                                            @if($materi->deskripsi)
                                                <p class="text-xs md:text-sm text-gray-600 mt-2 line-clamp-2 md:line-clamp-none">{{ $materi->deskripsi }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($materi->file_path)
                                        <div class="mt-2 md:mt-0 pt-2 md:pt-0 border-t md:border-t-0 border-gray-100 w-full md:w-auto flex items-center">
                                            <!-- Tombol full-width di HP -->
                                            <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white w-full md:w-auto"><i class="fas fa-download"></i> Download</a>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-center text-gray-400 py-6 text-sm">Belum ada materi dibagikan.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- TAB KUIS -->
<!-- TAB KUIS -->
                    <input type="radio" name="tabs" role="tab" class="tab font-bold text-xs md:text-sm whitespace-nowrap" aria-label="Kuis/Ujian" />
                    <div role="tabpanel" class="tab-content bg-base-100 p-2 md:p-4 pt-4 md:pt-6">
                        <div class="space-y-4">
                            @forelse($kelas->kuis->where('status', 'published') as $kuis)
                                <!-- Cek status pengerjaan kuis untuk siswa yang sedang login -->
                                @php
                                    $hasil = \App\Models\KuisHasil::where('kuis_id', $kuis->id)
                                                ->where('siswa_id', Auth::id())
                                                ->first();
                                @endphp
                                
                                <div class="flex flex-col md:flex-row justify-between border border-gray-200 p-3 md:p-4 rounded-lg bg-white gap-3 md:gap-4 hover:shadow-md transition">
                                    <div class="flex gap-3">
                                        <div class="text-2xl md:text-3xl text-primary mt-1"><i class="fas fa-laptop-code"></i></div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <h4 class="font-bold text-sm md:text-md text-primary leading-tight">{{ $kuis->judul }}</h4>
                                                
                                                <!-- BADGE INDIKATOR STATUS -->
                                                @if($hasil && $hasil->status == 'selesai')
                                                    <span class="badge badge-success text-white badge-sm font-bold">Skor: {{ $hasil->nilai }}</span>
                                                @elseif($hasil && $hasil->status == 'mengerjakan')
                                                    <span class="badge badge-warning text-white badge-sm">Sedang Dikerjakan</span>
                                                @else
                                                    <span class="badge badge-ghost badge-sm">Belum Dikerjakan</span>
                                                @endif
                                            </div>
                                            
                                            <p class="text-xs text-gray-600 font-semibold">{{ $kuis->mataPelajaran->nama }} • Durasi: {{ $kuis->durasi_menit }} Menit</p>
                                            <p class="text-xs text-gray-500 mt-2"><i class="fas fa-calendar"></i> Waktu: {{ $kuis->waktu_mulai->format('d M, H:i') }} s/d {{ $kuis->waktu_selesai->format('d M, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100 flex flex-col justify-center">
                                        <!-- TOMBOL DINAMIS -->
                                        <a href="{{ route('student.kuis.show', [$kelas->id, $kuis->id]) }}" 
                                           class="btn btn-sm w-full md:w-auto {{ $hasil && $hasil->status == 'selesai' ? 'btn-outline btn-success' : 'btn-primary' }}">
                                            @if($hasil && $hasil->status == 'selesai')
                                                <i class="fas fa-check"></i> Lihat Hasil
                                            @elseif($hasil && $hasil->status == 'mengerjakan')
                                                <i class="fas fa-play"></i> Lanjutkan
                                            @else
                                                Buka Kuis
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-400 py-6 text-sm">Tidak ada jadwal Kuis atau Ujian.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- TAB TUGAS -->
                    <input type="radio" name="tabs" role="tab" class="tab font-bold text-xs md:text-sm whitespace-nowrap" aria-label="Tugas" />
                    <div role="tabpanel" class="tab-content bg-base-100 p-2 md:p-4 pt-4 md:pt-6">
                        <div class="space-y-4">
                            @forelse($kelas->tugas as $tugas)
                                <div class="flex flex-col md:flex-row justify-between border border-gray-200 p-3 md:p-4 rounded-lg bg-white gap-3 md:gap-4 hover:shadow-md transition">
                                    <div class="flex gap-3">
                                        <div class="text-2xl md:text-3xl text-warning mt-1"><i class="fas fa-tasks"></i></div>
                                        <div>
                                            <h4 class="font-bold text-sm md:text-md text-primary leading-tight mb-1">{{ $tugas->judul }}</h4>
                                            <p class="text-xs text-gray-600 font-semibold">{{ $tugas->mataPelajaran->nama }}</p>
                                            <p class="text-xs text-error font-semibold mt-2 bg-red-50 p-1 rounded inline-block"><i class="fas fa-clock"></i> Deadline: {{ $tugas->deadline->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100 w-full md:w-auto flex flex-col justify-center">
                                        <a href="{{ route('student.tugas.show', [$kelas->id, $tugas->id]) }}" class="btn btn-sm btn-primary w-full md:w-auto">Buka Tugas <i class="fas fa-chevron-right hidden md:inline"></i></a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-400 py-6 text-sm">Tidak ada tugas saat ini. Hore!</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection