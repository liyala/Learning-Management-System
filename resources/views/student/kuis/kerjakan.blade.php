@extends('layouts.app')
@section('title', 'Mengerjakan Kuis')
@section('header_title', $kuis->judul)

@section('content')
<!-- Header Ujian Sticky -->
<div class="sticky top-0 z-50 bg-base-100 shadow-md p-4 rounded-lg mb-6 flex justify-between items-center border-t-4 border-error">
    <div>
        <h2 class="font-bold text-sm md:text-lg text-primary">{{ $kuis->mataPelajaran->nama }}</h2>
        <p class="text-xs text-gray-500">{{ $kuis->soal->count() }} Pertanyaan</p>
    </div>
    <div class="text-right">
        <p class="text-xs text-gray-500 font-bold uppercase mb-1">Sisa Waktu</p>
        <div id="timer" class="text-2xl md:text-3xl font-black text-error font-mono bg-red-50 px-3 py-1 rounded">
            --:--:--
        </div>
    </div>
</div>

<form id="formUjian" action="{{ route('student.kuis.submit', [$kelas->id, $kuis->id]) }}" method="POST">
    @csrf
    
    <div class="space-y-6">
        @foreach($soals as $index => $soal)
            <div class="card bg-base-100 shadow-sm border border-gray-100">
                <div class="card-body p-4 md:p-6">
                    <div class="flex gap-3 mb-4">
                        <span class="font-bold text-lg bg-base-200 h-8 w-8 flex items-center justify-center rounded">{{ $index + 1 }}</span>
                        <p class="text-md font-semibold text-gray-800 whitespace-pre-line mt-1">{{ $soal->pertanyaan }}</p>
                    </div>

<div class="space-y-3 md:ml-11 mt-4">
                        <!-- Opsi A -->
                        <label class="cursor-pointer relative block">
                            <!-- Input radio disembunyikan menggunakan sr-only (Screen Reader Only) -->
                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="a" class="peer sr-only" required />
                            <!-- Desain Kotak yang beraksi terhadap "peer-checked" -->
                            <div class="p-3 md:p-4 border-2 border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 peer-checked:border-primary peer-checked:bg-blue-100 transition-all font-semibold flex gap-3 items-center">
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-lg shadow-sm peer-checked:bg-primary peer-checked:text-white transition-colors">A</span>
                                <span class="text-gray-700 peer-checked:text-primary">{{ $soal->opsi_a }}</span>
                            </div>
                        </label>

                        <!-- Opsi B -->
                        <label class="cursor-pointer relative block">
                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="b" class="peer sr-only" />
                            <div class="p-3 md:p-4 border-2 border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 peer-checked:border-primary peer-checked:bg-blue-100 transition-all font-semibold flex gap-3 items-center">
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-lg shadow-sm peer-checked:bg-primary peer-checked:text-white transition-colors">B</span>
                                <span class="text-gray-700 peer-checked:text-primary">{{ $soal->opsi_b }}</span>
                            </div>
                        </label>

                        <!-- Opsi C -->
                        <label class="cursor-pointer relative block">
                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="c" class="peer sr-only" />
                            <div class="p-3 md:p-4 border-2 border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 peer-checked:border-primary peer-checked:bg-blue-100 transition-all font-semibold flex gap-3 items-center">
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-lg shadow-sm peer-checked:bg-primary peer-checked:text-white transition-colors">C</span>
                                <span class="text-gray-700 peer-checked:text-primary">{{ $soal->opsi_c }}</span>
                            </div>
                        </label>

                        <!-- Opsi D -->
                        <label class="cursor-pointer relative block">
                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="d" class="peer sr-only" />
                            <div class="p-3 md:p-4 border-2 border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 peer-checked:border-primary peer-checked:bg-blue-100 transition-all font-semibold flex gap-3 items-center">
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-lg shadow-sm peer-checked:bg-primary peer-checked:text-white transition-colors">D</span>
                                <span class="text-gray-700 peer-checked:text-primary">{{ $soal->opsi_d }}</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card bg-base-100 shadow-sm mt-6 sticky bottom-4 z-50 border border-primary">
        <div class="card-body p-4 flex flex-row justify-between items-center">
            <p class="text-xs md:text-sm text-gray-500 hidden md:block">Pastikan semua pertanyaan telah dijawab sebelum mengumpulkan.</p>
            <button type="button" onclick="konfirmasiSubmit()" class="btn btn-primary w-full md:w-auto text-lg"><i class="fas fa-paper-plane"></i> Kumpulkan Ujian</button>
        </div>
    </div>
</form>

<!-- SCRIPT TIMER JAVASCRIPT -->
<script>
    let sisaWaktu = {{ $sisaWaktuDetik }}; 
    const timerElement = document.getElementById('timer');
    const formUjian = document.getElementById('formUjian');

    function updateTimer() {
        if (sisaWaktu <= 0) {
            timerElement.innerHTML = "00:00:00";
            timerElement.classList.replace('text-error', 'text-white');
            timerElement.classList.replace('bg-red-50', 'bg-error');
            alert("Waktu Habis! Jawaban Anda akan otomatis dikumpulkan.");
            formUjian.submit();
            return;
        }

        let jam = Math.floor(sisaWaktu / 3600);
        let menit = Math.floor((sisaWaktu % 3600) / 60);
        let detik = Math.floor(sisaWaktu % 60); // Tambahkan Math.floor di sini

        // Format angka dengan leading zero
        jam = jam < 10 ? "0" + jam : jam;
        menit = menit < 10 ? "0" + menit : menit;
        detik = detik < 10 ? "0" + detik : detik;

        timerElement.innerHTML = (jam !== "00" ? jam + ":" : "") + menit + ":" + detik;
        sisaWaktu--;
    }

    setInterval(updateTimer, 1000);
    updateTimer();

    function konfirmasiSubmit() {
        if(confirm('Apakah Anda yakin ingin mengumpulkan jawaban sekarang? Anda tidak bisa mengulangi ujian ini.')) {
            formUjian.submit();
        }
    }
</script>
@endsection