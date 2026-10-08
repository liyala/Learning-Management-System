@extends('layouts.app')
@section('title', 'Detail Kelas')
@section('header_title', 'Ruang Kelas: ' . $kelas->nama_kelas)

@section('content')
<div class="mb-4">
    <a href="{{ route('teacher.kelas.index') }}" class="btn btn-ghost btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelas</a>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm mb-4"><span>{{ session('success') }}</span></div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
    <!-- Kolom Kiri: Info & Jadwal (Lebar 1/4) -->
    <div class="xl:col-span-1 space-y-6">
        <div class="card bg-base-100 shadow-sm border-t-4 border-primary">
            <div class="card-body p-5">
                <h2 class="font-bold text-lg mb-3">Informasi Kelas</h2>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between border-b pb-1">
                        <span class="text-gray-500">T.A.</span>
                        <span class="font-semibold">{{ $kelas->tahunAjaran->nama }}</span>
                    </li>
                    <li class="flex justify-between pb-1">
                        <span class="text-gray-500">Total Siswa</span>
                        <span class="font-semibold badge badge-primary badge-sm">{{ $kelas->siswa->count() }} Siswa</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <h2 class="font-bold text-md mb-3"><i class="fas fa-clock text-warning"></i> Jadwal Anda</h2>
                @if($jadwalSaya->count() > 0)
                    <ul class="space-y-2">
                        @foreach($jadwalSaya as $jadwal)
                            <li class="bg-base-200 p-2 rounded-lg text-sm">
                                <div class="font-bold text-primary">{{ $jadwal->mataPelajaran->nama }}</div>
                                <div class="text-xs text-gray-500"><i class="fas fa-calendar-day"></i> {{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-gray-500 text-center italic">Tidak ada jadwal mapel khusus.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Tabs Navigasi (Lebar 3/4) -->
    <div class="xl:col-span-3">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                
                <!-- DaisyUI Tabs -->
                <div role="tablist" class="tabs tabs-lifted tabs-lg mb-6">
                   <!-- Tab 0: Pengumuman -->
                    <input type="radio" name="kelas_tabs" role="tab" class="tab font-semibold" aria-label="Pengumuman" {{ session('active_tab') == 'pengumuman' || !session('active_tab') ? 'checked' : '' }} />
                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                        
                        <!-- Form Buat Pengumuman -->
                        <div class="bg-base-200 p-4 rounded-lg mb-6">
                            <form action="{{ route('teacher.pengumuman.store', $kelas->id) }}" method="POST">
                                @csrf
                                <div class="form-control">
                                    <textarea name="isi" class="textarea textarea-bordered w-full" placeholder="Tuliskan pengumuman atau informasi penting untuk kelas ini..." required rows="3"></textarea>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i> Posting Pengumuman</button>
                                </div>
                            </form>
                        </div>

                        <!-- Daftar Pengumuman -->
                        <div class="space-y-4">
                            @forelse($kelas->pengumuman as $pengumuman)
                                <div class="border border-gray-200 p-4 rounded-lg bg-white relative">
                                    <div class="flex items-start gap-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-primary text-neutral-content rounded-full w-10">
                                                <span><i class="fas fa-user-tie"></i></span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm">{{ $pengumuman->pembuat->nama }}</h4>
                                            <p class="text-xs text-gray-500 mb-2">{{ $pengumuman->created_at->diffForHumans() }} ({{ $pengumuman->created_at->format('d M Y, H:i') }})</p>
                                            <p class="text-sm text-gray-800 whitespace-pre-line">{{ $pengumuman->isi }}</p>
                                        </div>
                                    </div>
                                    @if($pengumuman->user_id == Auth::id())
                                        <form action="{{ route('teacher.pengumuman.destroy', [$kelas->id, $pengumuman->id]) }}" method="POST" class="absolute top-4 right-4" onsubmit="return confirm('Hapus pengumuman ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-error hover:text-red-700 tooltip" data-tip="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center text-gray-400 py-4"><i class="fas fa-bullhorn text-3xl mb-2"></i><br>Belum ada pengumuman di kelas ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab 1: Materi -->
                    <input type="radio" name="kelas_tabs" role="tab" class="tab font-semibold" aria-label="Materi Pembelajaran" checked {{ session('active_tab') == 'materi' ? 'checked' : '' }} />
                    {{-- {{ session('active_tab') != 'tugas' ? 'checked' : '' }} --}}
                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Materi yang Dibagikan</h3>
                            <a href="{{ route('teacher.materi.create', $kelas->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> Unggah Materi</a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($kelas->materi()->latest()->get() as $materi)
                                <div class="flex justify-between items-center border border-gray-200 p-4 rounded-lg hover:bg-base-200 transition">
                                    <div class="flex gap-4 items-start">
                                        <div class="text-3xl text-error mt-1"><i class="fas fa-file-pdf"></i></div>
                                        <div>
                                            <h4 class="font-bold text-md">{{ $materi->judul }}</h4>
                                            <p class="text-sm text-gray-500">{{ $materi->mataPelajaran->nama }} • Diunggah {{ $materi->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        @if($materi->file_path)
                                            <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white tooltip" data-tip="Lihat/Unduh File"><i class="fas fa-download"></i></a>
                                        @endif
                                        @if($materi->guru_id == Auth::id())
                                            <form action="{{ route('teacher.materi.destroy', [$kelas->id, $materi->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error text-white tooltip" data-tip="Hapus Materi"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500">Belum ada materi yang dibagikan di kelas ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab 2: Tugas (Akan dibuat di tahap selanjutnya) -->
<!-- Tab 2: Tugas -->
                    <input type="radio" name="kelas_tabs" role="tab" class="tab font-semibold" aria-label="Tugas & Penilaian" {{ session('active_tab') == 'tugas' ? 'checked' : '' }} />
                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Daftar Tugas</h3>
                            <a href="{{ route('teacher.tugas.create', $kelas->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Tugas</a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($kelas->tugas()->latest()->get() as $tugas)
                                <div class="border border-gray-200 p-4 rounded-lg hover:shadow-md transition bg-white">
                                    <div class="flex flex-col md:flex-row justify-between gap-4">
                                        <div class="flex gap-4 items-start w-full">
                                            <div class="text-3xl text-warning mt-1"><i class="fas fa-tasks"></i></div>
                                            <div class="w-full">
                                                <div class="flex justify-between items-center mb-1">
                                                    <h4 class="font-bold text-lg text-primary">{{ $tugas->judul }}</h4>
                                                    @if(\Carbon\Carbon::now()->gt($tugas->deadline))
                                                        <span class="badge badge-error badge-sm text-white">Ditutup</span>
                                                    @else
                                                        <span class="badge badge-success badge-sm text-white">Aktif</span>
                                                    @endif
                                                </div>
                                                <p class="text-sm font-semibold text-gray-600">{{ $tugas->mataPelajaran->nama }}</p>
                                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $tugas->deskripsi }}</p>
                                                
                                                <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-500">
                                                    <div><i class="fas fa-calendar-times text-error"></i> Deadline: <span class="font-semibold">{{ $tugas->deadline->format('d M Y, H:i') }}</span></div>
                                                    <div><i class="fas fa-users text-info"></i> Pengumpulan: 0 / {{ $kelas->siswa->count() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex md:flex-col gap-2 justify-end min-w-fit border-t md:border-t-0 md:border-l border-gray-100 pt-3 md:pt-0 md:pl-4 mt-3 md:mt-0">
                                            @if($tugas->file_pendukung)
                                                <a href="{{ asset('storage/' . $tugas->file_pendukung) }}" target="_blank" class="btn btn-sm btn-outline btn-info tooltip" data-tip="Unduh Lampiran"><i class="fas fa-paperclip"></i> Lampiran</a>
                                            @endif
                                            <!-- Tombol Lihat Submission (Akan diaktifkan nanti) -->
                                            <button ><a href="{{ route('teacher.tugas.submissions', [$kelas->id, $tugas->id]) }}" class="btn btn-sm btn-primary tooltip" data-tip="Lihat Pengumpulan"><i class="fas fa-eye"></i> Nilai</a></button>
                                            
                                            @if($tugas->guru_id == Auth::id())
                                                <form action="{{ route('teacher.tugas.destroy', [$kelas->id, $tugas->id]) }}" method="POST" onsubmit="return confirm('Hapus tugas ini beserta seluruh pengumpulan siswanya?');" class="mt-auto">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline btn-error w-full"><i class="fas fa-trash"></i> Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-check-circle text-4xl text-gray-300 mb-3"></i>
                                    <p>Belum ada tugas yang diberikan di kelas ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- TAB KUIS -->
                    <input type="radio" name="kelas_tabs" role="tab" class="tab font-semibold" aria-label="Kuis & Ujian" {{ session('active_tab') == 'kuis' ? 'checked' : '' }} />
                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">Daftar Kuis / Ujian</h3>
                            <a href="{{ route('teacher.kuis.create', $kelas->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Kuis</a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($kelas->kuis()->latest()->get() as $kuis)
                                <div class="border border-gray-200 p-4 rounded-lg bg-white flex justify-between items-center hover:shadow-md transition">
                                    <div class="flex gap-4">
                                        <div class="text-3xl text-primary mt-1"><i class="fas fa-laptop-code"></i></div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-bold text-lg">{{ $kuis->judul }}</h4>
                                                <span class="badge {{ $kuis->status == 'published' ? 'badge-success text-white' : 'badge-ghost' }} badge-sm">{{ strtoupper($kuis->status) }}</span>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-600">{{ $kuis->mataPelajaran->nama }} • Durasi: {{ $kuis->durasi_menit }} Menit</p>
                                            <p class="text-xs text-gray-500 mt-1">Jadwal: {{ $kuis->waktu_mulai->format('d M Y, H:i') }} s.d {{ $kuis->waktu_selesai->format('d M Y, H:i') }}</p>
                                            <p class="text-xs text-info mt-1"><i class="fas fa-list-ol"></i> Total Soal: {{ $kuis->soal->count() }} Butir</p>
                                        </div>
                                    </div>
<!-- Bagian Tombol Aksi Kuis -->
                                    <div class="flex gap-2 items-center min-w-fit mt-4 md:mt-0">
                                        <a href="{{ route('teacher.kuis.show', [$kelas->id, $kuis->id]) }}" class="btn btn-sm btn-primary tooltip" data-tip="Kelola Soal"><i class="fas fa-list-ol"></i> Soal</a>
                                        
                                        @if($kuis->guru_id == Auth::id())
                                            <a href="{{ route('teacher.kuis.edit', [$kelas->id, $kuis->id]) }}" class="btn btn-sm btn-info text-white tooltip" data-tip="Edit Info"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('teacher.kuis.destroy', [$kelas->id, $kuis->id]) }}" method="POST" onsubmit="return confirm('AWAS: Yakin ingin menghapus kuis ini? SEMUA BUTIR SOAL DAN NILAI SISWA TERKAIT AKAN IKUT TERHAPUS PERMANEN!');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error text-white tooltip" data-tip="Hapus Kuis"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500">Belum ada Kuis/Ujian di kelas ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab 3: Daftar Siswa -->
                    <input type="radio" name="kelas_tabs" role="tab" class="tab font-semibold" aria-label="Anggota Kelas" />
                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIS / Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelas->siswa->sortBy('nama') as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="font-semibold">{{ $siswa->nama }}</td>
                                            <td>{{ $siswa->username }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center py-6 text-gray-500">Belum ada siswa.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection