<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LMS Sekolah') - Sistem Pembelajaran</title>

    <!-- Google Fonts: Nunito -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & DaisyUI via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Konfigurasi Tailwind untuk Font Nunito -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        /* Smooth scrolling & kustom scrollbar tipis */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Efek Hover Melayang Khas Aplikasi Edukasi (Child-Friendly) */
        .card {
            transition: all 0.3s ease;
            border-radius: 1.25rem;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        
        /* Matikan efek hover card di sidebar agar tidak bergeser */
        .drawer-side .card:hover { transform: none; box-shadow: none; }

        /* Tombol yang lebih membulat dan empuk */
        .btn {
            border-radius: 0.75rem;
            text-transform: none;
            font-weight: 700;
        }
        
        /* Animasi masuk halaman */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-base-200 min-h-screen text-slate-800 antialiased font-sans">

    <!-- DAISYUI DRAWER WRAPPER -->
    <div class="drawer lg:drawer-open">
        <!-- Toggle Input untuk Drawer Mobile -->
        <input id="main-drawer" type="checkbox" class="drawer-toggle" />
        
        <!-- DRAWER CONTENT (Area Konten Utama & Navbar) -->
        <div class="drawer-content flex flex-col min-h-screen">
            
            <!-- NAVBAR ATAS (Sticky) -->
            <header class="navbar bg-base-100 shadow-sm sticky top-0 z-30 px-3 md:px-6">
                <!-- Hamburger Button (Hanya tampil di HP/Tablet) -->
                <div class="flex-none lg:hidden">
                    <label for="main-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <i class="fas fa-bars text-xl"></i>
                    </label>
                </div>
                
                <!-- Judul Halaman -->
                <div class="flex-1 px-2">
                    <h1 class="text-base md:text-xl font-bold truncate">@yield('header_title', 'Dashboard')</h1>
                </div>

                <!-- User Dropdown & Info -->
                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-9 md:w-10">
                                <span class="text-sm font-bold">{{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}</span>
                            </div>
                        </div>
                            <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-base-100 rounded-box w-56 border border-gray-100">
                            <li class="menu-title px-4 py-2 border-b border-gray-100 mb-1">
                                <span class="font-bold text-gray-800">{{ Auth::user()->nama }}</span>
                                <span class="text-xs text-primary font-semibold uppercase">{{ Auth::user()->role->name }}</span>
                            </li>
                            <li>
                                <a href="{{ route('profile.index') }}" class="py-3 flex items-center gap-2">
                                    <i class="fas fa-user-circle"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="text-error flex items-center gap-2 w-full text-left py-2">
                                        <i class="fas fa-sign-out-alt"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </header>

            <!-- KONTEN UTAMA -->
            <main class="flex-1 p-3 md:p-6 lg:p-8 max-w-7xl w-full mx-auto">


                @yield('content')
            </main>

            <!-- FOOTER MINI -->
            <footer class="footer footer-center p-4 bg-base-100 text-base-content/60 text-xs border-t border-gray-100">
                <aside>
                    <p>© {{ date('Y') }} SDMM - Learning Management system </p>
                </aside>
            </footer>
        </div> 

        <!-- DRAWER SIDEBAR (Samping) -->
        <div class="drawer-side z-40">
            <!-- Overlay untuk menutup drawer saat klik luar di HP -->
            <label for="main-drawer" aria-label="close sidebar" class="drawer-overlay"></label> 
            
            <aside class="bg-base-100 min-h-screen w-72 md:w-80 p-4 border-r border-gray-100 flex flex-col justify-between">
                <div>
                    <!-- Brand / Logo LMS -->
                    <div class="flex items-center gap-3 px-2 py-4 mb-4 border-b border-gray-100">
                        <div class="w-15 h-15 rounded-xl -content flex items-center justify-center font-black text-xl shadow-xl">
                            {{-- <i class="fas fa-graduation-cap"></i> --}}
                            <img src="{{ asset('images/Logo-SDMM.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                        </div>
                        <div>
                            <h2 class="font-bold text-lg tracking-tight text-primary leading-tight">LMS SDMM</h2>
                            <p class="text-[11px] text-gray-400 font-medium tracking-wide">Online Learning System By SDMM</p>
                        </div>
                    </div>

                    <!-- MENU ITEMS BERDASARKAN ROLE -->
                    <ul class="menu menu-md p-0 space-y-1">
                        @if(Auth::user()->hasRole('admin'))
                            <li class="menu-title text-xs font-bold uppercase tracking-wider text-gray-400">Master Data</li>
                            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active font-semibold' : '' }}"><i class="fas fa-chart-pie w-5"></i> Dashboard</a></li>
                            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active font-semibold' : '' }}"><i class="fas fa-users-cog w-5"></i> Manajemen User</a></li>
                            <li><a href="{{ route('admin.tahun-ajaran.index') }}" class="{{ request()->routeIs('admin.tahun-ajaran.*') ? 'active font-semibold' : '' }}"><i class="fas fa-calendar-alt w-5"></i> Tahun Ajaran</a></li>
                            <li><a href="{{ route('admin.kelas.index') }}" class="{{ request()->routeIs('admin.kelas.*') ? 'active font-semibold' : '' }}"><i class="fas fa-school w-5"></i> Manajemen Kelas</a></li>
                            <li><a href="{{ route('admin.mata-pelajaran.index') }}" class="{{ request()->routeIs('admin.mata-pelajaran.*') ? 'active font-semibold' : '' }}"><i class="fas fa-book w-5"></i> Mata Pelajaran</a></li>
                            {{-- <li><a href="{{ route('admin.jadwal.index') }}" class="{{ request()->routeIs('admin.jadwal.*') ? 'active font-semibold' : '' }}"><i class="fas fa-calendar-week w-5"></i> Jadwal Pelajaran</a></li> --}}

                        @elseif(Auth::user()->hasRole('guru'))
                            <li class="menu-title text-xs font-bold uppercase tracking-wider text-gray-400">Menu Guru</li>
                            <li><a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active font-semibold' : '' }}"><i class="fas fa-home w-5"></i> Dashboard</a></li>
                            <li><a href="{{ route('teacher.kelas.index') }}" class="{{ request()->routeIs('teacher.kelas.*') ? 'active font-semibold' : '' }}"><i class="fas fa-chalkboard w-5"></i> Kelas Saya</a></li>
                            <li><a href="{{ route('teacher.materi.index') }}" class="{{ request()->routeIs('teacher.materi.*') ? 'active font-semibold' : '' }}"><i class="fas fa-book-open w-5"></i> Materi Pembelajaran</a></li>
                            <li><a href="{{ route('teacher.tugas.index') }}" class="{{ request()->routeIs('teacher.tugas.*') ? 'active font-semibold' : '' }}"><i class="fas fa-tasks w-5"></i> Tugas & Penilaian</a></li>

                        @elseif(Auth::user()->hasRole('siswa'))
                            <li class="menu-title text-xs font-bold uppercase tracking-wider text-gray-400">Menu Siswa</li>
                            <li><a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active font-semibold' : '' }}"><i class="fas fa-home w-5"></i> Dashboard</a></li>
                            <li><a href="{{ route('student.kelas.index') }}" class="{{ request()->routeIs('student.kelas.*') ? 'active font-semibold' : '' }}"><i class="fas fa-chalkboard-teacher w-5"></i> Kelas Saya</a></li>
                            <li><a href="{{ route('student.nilai.index') }}" class="{{ request()->routeIs('student.nilai.*') ? 'active font-semibold' : '' }}"><i class="fas fa-book w-5"></i> Nilai & Rapor</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Bagian Bawah Sidebar (Info User Singkat) -->
                <div class="pt-4 border-t border-gray-100 flex items-center gap-3 px-2">
                    <div class="avatar placeholder">
                        <div class="bg-neutral text-neutral-content rounded-full w-8">
                             <span class="text-sm font-bold"> {{ strtoupper (substr(Auth::user()->nama ?? 'U', 0, 1)) }} </span>
                            <span class="text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold truncate"> {{ Auth::user()->nama }}</p>
                        <p class="text-[10px] text-gray-400 uppercase font-semibold">{{ Auth::user()->role->name }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
<!-- TOAST NOTIFICATION MELAYANG -->
    <div class="toast toast-top toast-end z-[9999] mt-16 md:mt-0">
        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="alert alert-success text-white shadow-xl flex gap-2 animate-[slideIn_0.3s_ease-out]">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Pesan Error Custom -->
        @if(session('error'))
            <div class="alert alert-error text-white shadow-xl flex gap-2 animate-[slideIn_0.3s_ease-out]">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Pesan Error Validasi Form -->
        @if($errors->any())
            <div class="alert alert-warning shadow-xl flex flex-col items-start gap-1 animate-[slideIn_0.3s_ease-out]">
                <div class="flex gap-2 items-center">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <span class="font-bold text-sm">Ada beberapa kesalahan input:</span>
                </div>
                <ul class="list-disc list-inside text-xs mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- SCRIPT OTOMATIS HILANG -->
    <script>
        // Script ini akan berjalan otomatis saat halaman dimuat
        setTimeout(() => {
            const alerts = document.querySelectorAll('.toast .alert');
            alerts.forEach(alert => {
                alert.style.transition = "opacity 0.5s ease"; // Transisi halus
                alert.style.opacity = "0"; // Memudarkan notifikasi
                setTimeout(() => alert.remove(), 500); // Menghapus dari layar setelah pudar
            });
        }, 4000); // 4000 = 4 detik notifikasi tampil sebelum hilang
    </script>
</body>
</html>