<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Portal Wali Santri') — MA At-Taraqqie</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased pb-24 md:pb-10 min-h-screen">

    <!-- Top Navigation Header (Mobile-First) -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 shadow-xs">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <!-- Brand / Logo -->
            <a href="{{ route('orang-tua.dashboard') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                <div>
                    <span class="text-sm font-black tracking-tight text-slate-900 block leading-tight">AT-TARAQQIE</span>
                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Portal Wali Santri</span>
                </div>
            </a>

            <!-- Right Actions: Switch Anak, Notifikasi, User -->
            <div class="flex items-center gap-2">
                @if (isset($anaks) && $anaks->count() > 1)
                    <!-- Dropdown Pilih Anak -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold hover:bg-emerald-100 transition-all">
                            <i class="fa-solid fa-child-reaching text-emerald-600"></i>
                            <span class="max-w-[110px] sm:max-w-[160px] truncate">{{ $selectedAnak?->name ?? 'Pilih Santri' }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-emerald-600"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50">
                            <div class="px-3 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400 border-b border-slate-100 mb-1">
                                Pilih Ananda Santri:
                            </div>
                            @foreach ($anaks as $anak)
                                @php
                                    $unitName = $anak->siswa?->unit?->nama ?? ($anak->siswa?->kelas?->unit?->nama ?? 'MA');
                                    $isPutra = str_contains(strtolower($unitName), 'putra');
                                @endphp
                                <form method="POST" action="{{ route('orang-tua.switch-anak', $anak->id) }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left p-2.5 rounded-xl flex items-center justify-between {{ ($selectedAnak && $selectedAnak->id === $anak->id) ? 'bg-emerald-50 text-emerald-900 font-bold' : 'hover:bg-slate-50 text-slate-700 font-medium' }} transition-colors">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold {{ $isPutra ? 'bg-sky-100 text-sky-700' : 'bg-purple-100 text-purple-700' }}">
                                                {{ strtoupper(substr($anak->name, 0, 1)) }}
                                            </div>
                                            <div class="truncate">
                                                <div class="text-xs truncate">{{ $anak->name }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $anak->siswa?->kelas?->nama_lengkap ?? 'Santri' }}</div>
                                            </div>
                                        </div>
                                        <span class="text-[9px] px-2 py-0.5 rounded-full font-bold {{ $isPutra ? 'bg-sky-100 text-sky-700' : 'bg-purple-100 text-purple-700' }}">
                                            {{ $unitName }}
                                        </span>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @elseif (isset($selectedAnak))
                    <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200">
                        <i class="fa-solid fa-child text-emerald-600"></i>
                        <span>{{ $selectedAnak->name }}</span>
                    </div>
                @endif

                <!-- Bell Notifikasi -->
                @php
                    $unreadCount = \App\Models\Notifikasi::where('user_id', auth()->id())->whereNull('dibaca_at')->count();
                @endphp
                <a href="{{ route('notifications.index') }}" class="relative w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-bell text-sm"></i>
                    @if ($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white text-[10px] font-black flex items-center justify-center animate-pulse">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Keluar" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-5">
        @yield('content')
    </main>

    <!-- Bottom Navigation Bar for Mobile (App-like UX) -->
    <nav class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-lg border-t border-slate-200 z-40 md:hidden py-1.5 px-3 shadow-lg">
        <div class="grid grid-cols-5 text-center">
            <a href="{{ route('orang-tua.dashboard') }}" class="flex flex-col items-center py-1 {{ request()->is('orang-tua/dashboard*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fa-solid fa-house text-lg mb-0.5"></i>
                <span class="text-[10px]">Beranda</span>
            </a>
            <a href="{{ route('orang-tua.absensi.index') }}" class="flex flex-col items-center py-1 {{ request()->is('orang-tua/absensi*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fa-solid fa-calendar-check text-lg mb-0.5"></i>
                <span class="text-[10px]">Absensi</span>
            </a>
            <a href="{{ route('orang-tua.raport.index') }}" class="flex flex-col items-center py-1 {{ request()->is('orang-tua/raport*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fa-solid fa-graduation-cap text-lg mb-0.5"></i>
                <span class="text-[10px]">Raport</span>
            </a>
            <a href="{{ route('orang-tua.poin.index') }}" class="flex flex-col items-center py-1 {{ request()->is('orang-tua/poin*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fa-solid fa-shield-halved text-lg mb-0.5"></i>
                <span class="text-[10px]">Karakter</span>
            </a>
            <a href="{{ route('orang-tua.tagihan.index') }}" class="flex flex-col items-center py-1 {{ request()->is('orang-tua/tagihan*') ? 'text-emerald-600 font-bold' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fa-solid fa-receipt text-lg mb-0.5"></i>
                <span class="text-[10px]">SPP</span>
            </a>
        </div>
    </nav>

    <!-- Desktop Navigation Bar (Tablet / Laptop Sub-Navbar) -->
    <div class="hidden md:block fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-slate-900/90 backdrop-blur-md px-6 py-3 rounded-full shadow-2xl border border-white/10 text-white">
        <div class="flex items-center gap-6 text-sm font-semibold">
            <a href="{{ route('orang-tua.dashboard') }}" class="hover:text-emerald-400 transition-colors {{ request()->is('orang-tua/dashboard*') ? 'text-emerald-400 font-bold' : 'text-slate-300' }}">
                <i class="fa-solid fa-house mr-1.5"></i> Beranda
            </a>
            <a href="{{ route('orang-tua.absensi.index') }}" class="hover:text-emerald-400 transition-colors {{ request()->is('orang-tua/absensi*') ? 'text-emerald-400 font-bold' : 'text-slate-300' }}">
                <i class="fa-solid fa-calendar-check mr-1.5"></i> Presensi
            </a>
            <a href="{{ route('orang-tua.raport.index') }}" class="hover:text-emerald-400 transition-colors {{ request()->is('orang-tua/raport*') ? 'text-emerald-400 font-bold' : 'text-slate-300' }}">
                <i class="fa-solid fa-graduation-cap mr-1.5"></i> Raport Digital
            </a>
            <a href="{{ route('orang-tua.poin.index') }}" class="hover:text-emerald-400 transition-colors {{ request()->is('orang-tua/poin*') ? 'text-emerald-400 font-bold' : 'text-slate-300' }}">
                <i class="fa-solid fa-shield-halved mr-1.5"></i> Kedisiplinan
            </a>
            <a href="{{ route('orang-tua.tagihan.index') }}" class="hover:text-emerald-400 transition-colors {{ request()->is('orang-tua/tagihan*') ? 'text-emerald-400 font-bold' : 'text-slate-300' }}">
                <i class="fa-solid fa-receipt mr-1.5"></i> Keuangan SPP
            </a>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
