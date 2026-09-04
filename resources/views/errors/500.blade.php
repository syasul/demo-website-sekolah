<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Kendala Server | MA At-Taraqqie</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-white font-sans antialiased min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="flex items-center justify-center gap-3 mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="w-12 h-12 object-contain">
            <span class="text-xl font-black uppercase tracking-tight">MA At-Taraqqie</span>
        </div>

        <div class="w-24 h-24 rounded-3xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center text-4xl mx-auto shadow-inner">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <div>
            <span class="text-xs font-mono font-bold tracking-widest uppercase text-rose-400 bg-rose-500/10 px-3 py-1 rounded-full border border-rose-500/20">
                Error 500 Server Error
            </span>
            <h1 class="text-2xl sm:text-3xl font-black mt-3 tracking-tight">Terjadi Kendala Sistem</h1>
            <p class="text-sm text-slate-400 mt-2 leading-relaxed">
                Mohon maaf, sistem sedang mengalami kendala teknis sementara. Silakan segarkan laman atau coba kembali beberapa saat lagi.
            </p>
        </div>

        <div class="flex items-center justify-center gap-3 pt-2">
            <button onclick="window.location.reload()" class="px-6 py-3 rounded-2xl bg-white text-slate-900 hover:bg-slate-100 font-bold text-xs uppercase tracking-wider transition-all shadow-lg">
                Muat Ulang Halaman
            </button>
            <a href="/" class="px-6 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white border border-white/10 font-bold text-xs uppercase tracking-wider transition-all">
                Halaman Utama
            </a>
        </div>
    </div>
</body>
</html>
