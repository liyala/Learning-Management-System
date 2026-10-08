<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LMS Sekolah') - Sistem Pembelajaran</title>

    <!-- Tailwind CSS & DaisyUI via CDN (atau Vite jika menggunakan npm run dev) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        /* Smooth scrolling & kustom scrollbar tipis */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
                <!-- Global Flash Messages -->
                @if(session('success'))
                    <div role="alert" class="alert alert-success shadow-sm mb-4 text-sm md:text-base py-3">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div role="alert" class="alert alert-error text-white shadow-sm mb-4 text-sm md:text-base py-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div role="alert" class="alert alert-warning shadow-sm mb-4 text-sm py-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <span class="font-bold">Ada beberapa kesalahan input:</span>
                            <ul class="list-disc list-inside mt-1 text-xs md:text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- FOOTER MINI -->
            <footer class="footer footer-center p-4 bg-base-100 text-base-content/60 text-xs border-t border-gray-100">
                <aside>
                    <p>© {{ date('Y') }} LMS Sekolah - Sistem Manajemen Pembelajaran Terpadu</p>
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
                        <div class="w-10 h-10 rounded-xl bg-primary text-primary-content flex items-center justify-center font-black text-xl shadow">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg tracking-tight text-primary leading-tight">LMS Sekolah</h2>
                            <p class="text-[11px] text-gray-400 font-medium tracking-wide">PORTAL PEMBELAJARAN</p>
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

</body>
</html>