<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Pertemuan 2 - Laravel 12</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen font-sans">

    @if (Route::has('login'))
        <div class="fixed top-0 right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-600 hover:text-slate-900 border border-slate-200 px-4 py-2 rounded-xl bg-white shadow-sm transition-all">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-slate-600 hover:text-slate-900 border border-slate-200 px-4 py-2 rounded-xl bg-white shadow-sm transition-all">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-slate-600 hover:text-slate-900 border border-slate-200 px-4 py-2 rounded-xl bg-white shadow-sm transition-all">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="bg-white p-10 rounded-3xl shadow-2xl border border-slate-100 text-center max-w-md w-full mx-4 transition-all hover:scale-105">
        <div class="inline-block px-4 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold mb-6 uppercase tracking-widest">
            Laravel v12.0
        </div>

        <h1 class="text-3xl font-extrabold text-slate-800 mb-8 leading-tight">
            Tugas Praktikum <br><span class="text-blue-600">Pertemuan 2</span>
        </h1>

        <div class="space-y-6">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1 text-left">Nama Lengkap</p>
                <p class="text-lg font-semibold text-slate-700 text-left">Aldys Igidia Triatmaja</p>
            </div>
            
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1 text-left">Nomor Induk Mahasiswa</p>
                <p class="text-lg font-mono font-bold text-blue-600 text-left tracking-tighter">20230140207</p>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-100">
            <p class="text-sm text-slate-400 italic">
                "Modul Pertemuan 2 - MVC & Breeze"
            </p>
        </div>
    </div>

</body>
</html>