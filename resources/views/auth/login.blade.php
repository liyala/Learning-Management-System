<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - LMS SDMM</title>

    <!-- Tailwind CSS & DaisyUI via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">

    <!-- Kontainer Card Login -->
    <div class="card w-full max-w-md bg-base-100 shadow-2xl border-t-4 border-primary">
        <div class="card-body p-6 md:p-8">
            
            <!-- Header & Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-primary text-primary-content flex items-center justify-center font-black text-3xl shadow-lg mx-auto mb-4">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="text-sm text-gray-500 mt-1">Silakan masuk ke portal pembelajaran Anda.</p>
            </div>

            <!-- Pesan Error / Flash Message -->
            @if($errors->any() || session('error'))
                <div role="alert" class="alert alert-error text-white shadow-sm mb-6 text-sm py-3 rounded-lg">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('error') ?? 'Username atau Password yang Anda masukkan salah.' }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <!-- Pastikan action ini mengarah ke rute proses login Anda. Standarnya adalah route('login') -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Input Username -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-bold text-gray-700">Username</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                        <i class="fas fa-user text-gray-400"></i>
                        <input type="text" name="username" class="grow" placeholder="Masukkan Username" value="{{ old('username') }}" required autofocus autocomplete="off" />
                    </label>
                </div>

                <!-- Input Password -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-bold text-gray-700">Password</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                        <i class="fas fa-lock text-gray-400"></i>
                        <input type="password" name="password" class="grow" placeholder="Masukkan Password" required />
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div class="form-control mt-2 mb-6">
                    <button type="submit" class="btn btn-primary w-full text-lg shadow-md hover:shadow-lg transition-shadow">
                        <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                    </button>
                </div>
            </form>
            
            <!-- Footer Form -->
            <div class="text-center border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-400 font-medium tracking-wide">
                    &copy; {{ date('Y') }} Learning Management System SDMM
                </p>
            </div>

        </div>
    </div>

</body>
</html>