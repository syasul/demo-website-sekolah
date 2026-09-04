<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Guru') — MA At-Taraqqie</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased overflow-x-hidden">
    <!-- Guru Mobile Drawer Overlay -->
    <div id="guru-sidebar-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar & Mobile Off-canvas Drawer -->
        <aside id="guru-sidebar" class="w-72 bg-slate-900 text-white fixed h-full z-50 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0 flex flex-col justify-between">
            <div class="p-6 sm:p-8 overflow-y-auto">
                <div class="flex items-center justify-between mb-8 sm:mb-12">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo MA At-Taraqqie" class="w-10 h-10 object-contain">
                        <div>
                            <span class="text-xl font-black tracking-tight uppercase block leading-none">At-Taraqqie</span>
                            <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest">Portal Guru</span>
                        </div>
                    </a>
                    <button id="guru-sidebar-close" aria-label="Tutup Menu" class="lg:hidden w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <nav class="space-y-1.5 sm:space-y-2">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Utama</div>
                    <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/dashboard*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Pembelajaran</div>
                    <a href="{{ route('guru.kelas.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/kelas*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-chalkboard-user w-5 text-center"></i>
                        <span>Kelas & Siswa</span>
                    </a>

                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Penilaian Berkala</div>
                    <a href="{{ route('guru.nilai.tugas-uh') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/nilai/tugas-uh*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-list-check w-5 text-center"></i>
                        <span>Tugas & UH</span>
                    </a>
                    <a href="{{ route('guru.nilai.uts-uas') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/nilai/uts-uas*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-pen-nib w-5 text-center"></i>
                        <span>UTS & UAS</span>
                    </a>
                    <a href="{{ route('guru.nilai.remidi') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/nilai/remidi*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-rotate-right w-5 text-center"></i>
                        <span>Program Remidi</span>
                    </a>

                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Raport Semester</div>
                    <a href="{{ route('guru.raport.rekap') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/raport/rekap*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-square-poll-vertical w-5 text-center"></i>
                        <span>Rekapitulasi Raport</span>
                    </a>
                    <a href="{{ route('guru.raport.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('guru/raport') || request()->is('guru/raport/input*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-file-pen w-5 text-center"></i>
                        <span>Input Sikap & Catatan</span>
                    </a>
                </nav>
            </div>
            
            <div class="p-6 border-t border-white/5">
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-500 text-white font-black italic flex items-center justify-center shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold truncate text-white">{{ Auth::user()->name ?? 'Guru' }}</p>
                            <p class="text-[10px] text-emerald-400 font-bold uppercase truncate">
                                @if(Auth::user()->kelasWali)
                                    Wali Kelas {{ Auth::user()->kelasWali->nama_lengkap }}
                                @else
                                    Tenaga Pengajar
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-72 bg-slate-50 min-w-0">
            <!-- Header -->
            <header class="h-20 sm:h-24 bg-white/70 backdrop-blur border-b border-slate-200 sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <button id="guru-sidebar-btn" aria-label="Buka Menu" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-900 text-lg hover:bg-slate-200 transition-colors shrink-0">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h2 class="text-base sm:text-xl font-extrabold tracking-tight text-slate-900 uppercase truncate">@yield('page_title', 'Dashboard Guru')</h2>
                </div>
                <div class="flex items-center gap-3 sm:gap-6 shrink-0">
                    <button class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-all">
                        <i class="fa-solid fa-bell text-sm sm:text-base"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-emerald-500 rounded-full"></span>
                    </button>
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs hover:bg-rose-100 transition-all">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const guruSidebarBtn = document.getElementById('guru-sidebar-btn');
        const guruSidebarClose = document.getElementById('guru-sidebar-close');
        const guruSidebarOverlay = document.getElementById('guru-sidebar-overlay');
        const guruSidebar = document.getElementById('guru-sidebar');

        function openGuruSidebar() {
            if (guruSidebar && guruSidebarOverlay) {
                guruSidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
                guruSidebarOverlay.classList.add('opacity-100', 'pointer-events-auto');
                guruSidebar.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeGuruSidebar() {
            if (guruSidebar && guruSidebarOverlay) {
                guruSidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
                guruSidebarOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                guruSidebar.classList.add('-translate-x-full');
                document.body.style.overflow = '';
            }
        }

        if (guruSidebarBtn) guruSidebarBtn.addEventListener('click', openGuruSidebar);
        if (guruSidebarClose) guruSidebarClose.addEventListener('click', closeGuruSidebar);
        if (guruSidebarOverlay) guruSidebarOverlay.addEventListener('click', closeGuruSidebar);

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeGuruSidebar();
        });
    </script>
</body>
</html>
