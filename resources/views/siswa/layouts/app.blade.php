<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Siswa') — MA At-Taraqqie</title>
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
    <!-- Siswa Mobile Drawer Overlay -->
    <div id="siswa-sidebar-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar & Mobile Drawer -->
        <aside id="siswa-sidebar" class="w-72 bg-slate-900 text-white fixed h-full z-50 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0 flex flex-col justify-between">
            <div class="p-6 sm:p-8 overflow-y-auto">
                <div class="flex items-center justify-between mb-8 sm:mb-12">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo MA At-Taraqqie" class="w-10 h-10 object-contain">
                        <div>
                            <span class="text-xl font-black tracking-tight uppercase block leading-none">At-Taraqqie</span>
                            <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest">Portal Siswa</span>
                        </div>
                    </a>
                    <button id="siswa-sidebar-close" aria-label="Tutup Menu" class="lg:hidden w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <nav class="space-y-1.5 sm:space-y-2">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Akademik</div>
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('siswa/dashboard*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.raport.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('siswa/raport*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-graduation-cap w-5 text-center"></i>
                        <span>Raport Saya</span>
                    </a>

                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Akun & Profil</div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('profile*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-user-gear w-5 text-center"></i>
                        <span>Pengaturan Profil</span>
                    </a>
                    <a href="/" target="_blank" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 font-medium transition-all">
                        <i class="fa-solid fa-globe w-5 text-center"></i>
                        <span>Web Utama Sekolah</span>
                    </a>
                </nav>
            </div>
            
            <div class="p-6 border-t border-white/5">
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/5 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-500 text-white font-black italic flex items-center justify-center shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold truncate text-white">{{ Auth::user()->name ?? 'Siswa' }}</p>
                            <p class="text-[10px] text-emerald-400 font-bold uppercase truncate">
                                {{ Auth::user()->kelas ? 'Kelas ' . Auth::user()->kelas->nama_lengkap : 'Siswa Aktif' }}
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white text-xs font-bold transition-all border border-rose-500/20">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-72 min-h-screen flex flex-col">
            <!-- Top Navigation Bar -->
            <header class="h-20 bg-white border-b border-slate-200/80 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger -->
                    <button id="siswa-sidebar-toggle" aria-label="Buka Menu" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-800">@yield('page_title', 'Portal Siswa')</h1>
                        <p class="text-xs text-slate-400 hidden sm:block">Sistem Informasi Akademik & Raport Digital MA At-Taraqqie</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ Auth::user()->kelas ? 'Kelas ' . Auth::user()->kelas->nama_lengkap : 'Siswa Aktif' }}
                    </span>
                    <a href="{{ route('profile.edit') }}" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition-colors" title="Profil">
                        <i class="fa-solid fa-user text-sm"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6 sm:p-8 flex-1">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 p-4 rounded-2xl bg-sky-50 border border-sky-200 text-sky-800 text-sm flex items-center gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-info text-sky-600 text-lg"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="py-6 px-8 border-t border-slate-200/80 bg-white text-center sm:flex sm:justify-between text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} MA At-Taraqqie Malang. Seluruh hak cipta dilindungi.</p>
                <p class="mt-2 sm:mt-0">Portal Siswa & Raport Online</p>
            </footer>
        </main>
    </div>

    <!-- Mobile Drawer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('siswa-sidebar');
            const overlay = document.getElementById('siswa-sidebar-overlay');
            const openBtn = document.getElementById('siswa-sidebar-toggle');
            const closeBtn = document.getElementById('siswa-sidebar-close');

            if (openBtn && sidebar && overlay) {
                const openSidebar = () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('opacity-0', 'pointer-events-none');
                    overlay.classList.add('opacity-100');
                    document.body.classList.add('overflow-hidden');
                };

                const closeSidebar = () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                    overlay.classList.remove('opacity-100');
                    document.body.classList.remove('overflow-hidden');
                };

                openBtn.addEventListener('click', openSidebar);
                if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>
</html>
