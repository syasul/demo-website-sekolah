<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — MA At-Taraqqie</title>
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
    <!-- Admin Mobile Drawer Overlay -->
    <div id="admin-sidebar-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar & Mobile Off-canvas Drawer -->
        <aside id="admin-sidebar" class="w-72 bg-slate-900 text-white fixed h-full z-50 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0 flex flex-col justify-between">
            <div class="p-6 sm:p-8 overflow-y-auto">
                <div class="flex items-center justify-between mb-8 sm:mb-12">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo MA At-Taraqqie" class="w-10 h-10 object-contain">
                        <span class="text-xl font-black tracking-tight uppercase">At-Taraqqie</span>
                    </a>
                    <button id="admin-sidebar-close" aria-label="Tutup Menu" class="lg:hidden w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <nav class="space-y-1.5 sm:space-y-2">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Utama</div>
                    <a href="/admin/dashboard" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/dashboard*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Eksistensi</div>
                    <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/berita*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-newspaper w-5 text-center"></i>
                        <span>Manajemen Berita</span>
                    </a>
                    <a href="#" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fa-solid fa-images w-5 text-center"></i>
                        <span>Galeri Kegiatan</span>
                    </a>

                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Akademik & Siswa</div>
                    <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/ppdb*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-user-plus w-5 text-center"></i>
                        <span>Pendaftar PPDB</span>
                    </a>
                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/siswa*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-user-graduate w-5 text-center"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="{{ route('admin.guru.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/guru*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-user-tie w-5 text-center"></i>
                        <span>Data Guru</span>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/kelas*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-school w-5 text-center"></i>
                        <span>Manajemen Kelas</span>
                    </a>
                    <a href="{{ route('admin.mata-pelajaran.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/mata-pelajaran*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-book w-5 text-center"></i>
                        <span>Mata Pelajaran</span>
                    </a>

                    <div class="pt-6 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-4">Sistem & Konfigurasi</div>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl {{ request()->is('admin/pengaturan*') ? 'bg-white/10 text-white font-bold shadow-lg border border-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all">
                        <i class="fa-solid fa-sliders w-5 text-center"></i>
                        <span>Pengaturan Sekolah</span>
                    </a>
                </nav>
            </div>
            
            <div class="p-6 border-t border-white/5">
                <div class="p-3.5 bg-white/5 rounded-2xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-school-accent flex items-center justify-center text-slate-900 font-black italic shrink-0">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold truncate text-white">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-[10px] text-slate-500 uppercase truncate font-black">{{ Auth::user()->role ?? 'Admin' }}</p>
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
                    <button id="admin-sidebar-btn" aria-label="Buka Menu" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-900 text-lg hover:bg-slate-200 transition-colors shrink-0">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <h2 class="text-base sm:text-xl font-extrabold tracking-tight text-slate-900 uppercase truncate">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-3 sm:gap-6 shrink-0">
                    <button class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-all">
                        <i class="fa-solid fa-bell text-sm sm:text-base"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>
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
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Admin Sidebar Drawer Toggle
        const adminSidebarBtn = document.getElementById('admin-sidebar-btn');
        const adminSidebarClose = document.getElementById('admin-sidebar-close');
        const adminSidebarOverlay = document.getElementById('admin-sidebar-overlay');
        const adminSidebar = document.getElementById('admin-sidebar');

        function openAdminSidebar() {
            if (adminSidebar && adminSidebarOverlay) {
                adminSidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
                adminSidebarOverlay.classList.add('opacity-100', 'pointer-events-auto');
                adminSidebar.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeAdminSidebar() {
            if (adminSidebar && adminSidebarOverlay) {
                adminSidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
                adminSidebarOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                adminSidebar.classList.add('-translate-x-full');
                document.body.style.overflow = '';
            }
        }

        if (adminSidebarBtn) adminSidebarBtn.addEventListener('click', openAdminSidebar);
        if (adminSidebarClose) adminSidebarClose.addEventListener('click', closeAdminSidebar);
        if (adminSidebarOverlay) adminSidebarOverlay.addEventListener('click', closeAdminSidebar);

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAdminSidebar();
        });
    </script>
    @yield('scripts')
</body>
</html>

