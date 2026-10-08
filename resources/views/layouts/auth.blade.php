<!-- resources/views/layouts/auth.blade.php -->
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LMS SD</title>
    <!-- Tailwind & DaisyUI (Untuk production nanti bisa install via npm) -->
    <link href="[https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css](https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css)" rel="stylesheet" type="text/css" />
    <script src="[https://cdn.tailwindcss.com](https://cdn.tailwindcss.com)"></script>
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center">

    @yield('content')

</body>
</html>