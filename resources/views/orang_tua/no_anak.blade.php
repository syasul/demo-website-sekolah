<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Belum Ditautkan — Portal Orang Tua</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200 text-center shadow-lg">
        <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl mx-auto mb-6">
            <i class="fa-solid fa-child-reaching"></i>
        </div>
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Belum Ada Santri Terhubung</h2>
        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
            Akun wali santri Anda belum ditautkan dengan data santri aktif di sistem madrasah. Silakan hubungi bagian Tata Usaha / Admin Madrasah untuk melakukan verifikasi NISN ananda.
        </p>
        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-center gap-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>
</body>
</html>
