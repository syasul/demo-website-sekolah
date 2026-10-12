<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — MA Attaraqqie</title>
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
            <div class="p-5 overflow-y-auto">
                <!-- Brand Logo -->
                <div class="flex items-center justify-between mb-5">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo MA Attaraqqie" class="w-9 h-9 object-contain">
                        <div>
                            <span class="text-base font-black tracking-tight uppercase block leading-tight text-white">Attaraqqie</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Sistem Terpadu Multi-Unit</span>
                        </div>
                    </a>
                    <button id="admin-sidebar-close" aria-label="Tutup Menu" class="lg:hidden w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- TOP CONTEXT SWITCHER (Session-Based Multi-Unit Switcher) -->
                <div class="mb-6 p-3 bg-white/5 border border-white/10 rounded-2xl">
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Konteks Aktif</span>
                        <span class="w-2 h-2 rounded-full {{ $contextBadge['dot_class'] ?? 'bg-emerald-400' }} animate-pulse"></span>
                    </div>

                    <div class="flex items-center gap-2 p-2 rounded-xl {{ $contextBadge['bg_class'] ?? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400' }} border text-xs font-bold mb-2.5">
                        <i class="fa-solid fa-building-columns text-sm shrink-0"></i>
                        <span class="truncate">{{ $contextBadge['label'] ?? 'Semua Unit (Yayasan Global)' }}</span>
                    </div>

                    @if(Auth::user()->isAdminGlobal())
                    <!-- Switcher Button (Dropdown / Quick Toggle) -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="w-full py-1.5 px-2.5 bg-white/10 hover:bg-white/20 text-slate-200 rounded-xl text-[11px] font-bold flex items-center justify-between transition-colors">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-arrows-rotate text-[10px]"></i>
                                <span>Switch Dashboard</span>
                            </span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="mt-2 p-2 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl space-y-1 text-xs">
                            <form method="POST" action="{{ route('admin.switch-unit') }}">
                                @csrf
                                <input type="hidden" name="mode" value="global">
                                <button type="submit" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-slate-700 text-emerald-400 font-bold flex items-center justify-between">
                                    <span>🌐 Semua Unit (Global)</span>
                                    @if(empty($activeUnitId) && empty($activeJenjangId))
                                        <i class="fa-solid fa-check text-xs"></i>
                                    @endif
                                </button>
                            </form>

                            <div class="border-t border-slate-700 my-1 pt-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider px-2 block mb-1">Pilih Unit:</span>
                                
                                @if(isset($allJenjangs))
                                    @foreach($allJenjangs as $jenjang)
                                        <div class="px-2 pt-1.5 pb-0.5 text-[10px] font-bold text-slate-400">{{ $jenjang->nama }}</div>
                                        @foreach($jenjang->units as $u)
                                            <form method="POST" action="{{ route('admin.switch-unit') }}">
                                                @csrf
                                                <input type="hidden" name="mode" value="unit">
                                                <input type="hidden" name="unit_id" value="{{ $u->id }}">
                                                <button type="submit" class="w-full text-left px-3 py-1.5 rounded-lg hover:bg-slate-700 {{ $u->gender === 'putra' ? 'text-blue-300' : 'text-purple-300' }} flex items-center justify-between font-medium">
                                                    <span>{{ $u->gender === 'putra' ? '🔵' : '🟣' }} {{ $u->nama }}</span>
                                                    @if(isset($activeUnitId) && $activeUnitId == $u->id)
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        @endforeach
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-[10px] text-slate-400 italic px-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-lock text-[9px]"></i>
                        <span>Akses terbatas unit {{ strtoupper(Auth::user()->admin_level) }}</span>
                    </div>
                    @endif
                </div>

                <!-- NAVIGATION MENUS -->
                <nav class="space-y-1">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Utama</div>
                    <a href="/admin/dashboard" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/dashboard*') ? 'bg-white/10 text-white font-bold shadow-sm' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Akademik & Siswa</div>
                    <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/ppdb*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-user-plus w-4 text-center"></i>
                        <span>Pendaftar PPDB</span>
                    </a>
                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/siswa*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-user-graduate w-4 text-center"></i>
                        <span>Data Siswa / Santri</span>
                    </a>
                    <a href="{{ route('admin.absensi.siswa') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/absensi-siswa*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-clipboard-user w-4 text-center"></i>
                        <span>Absensi Siswa</span>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/kelas*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-school w-4 text-center"></i>
                        <span>Manajemen Kelas</span>
                    </a>
                    <a href="{{ route('admin.mata-pelajaran.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/mata-pelajaran*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-book w-4 text-center"></i>
                        <span>Mata Pelajaran & KKM</span>
                    </a>

                    <div class="pt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Pendidik & Kinerja</div>
                    <a href="{{ route('admin.guru.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/guru*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-user-tie w-4 text-center"></i>
                        <span>Data Asatidz / Guru</span>
                    </a>
                    <a href="{{ route('admin.absensi.guru') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/absensi-guru*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-calendar-check w-4 text-center"></i>
                        <span>Absensi & Jurnal Guru</span>
                    </a>
                    <a href="{{ route('admin.evaluasi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/evaluasi-guru*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-award w-4 text-center"></i>
                        <span>Evaluasi Kinerja Guru</span>
                    </a>
                    <a href="{{ route('admin.rumah-jurnal.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/rumah-jurnal*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-book-bookmark w-4 text-center"></i>
                        <span>Rumah Jurnal</span>
                    </a>

                    <div class="pt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Karakter & Kedisiplinan</div>
                    <a href="{{ route('admin.kedisiplinan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/kedisiplinan') || request()->is('admin/kedisiplinan/tambah') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-shield-halved w-4 text-center"></i>
                        <span>Poin Kedisiplinan</span>
                    </a>
                    <a href="{{ route('admin.kedisiplinan.student-of-the-year') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/kedisiplinan/student-of-the-year*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-trophy w-4 text-center text-amber-400"></i>
                        <span>Student of the Year</span>
                    </a>

                    <div class="pt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Keuangan & Administrasi</div>
                    <a href="{{ route('admin.keuangan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/keuangan*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-wallet w-4 text-center"></i>
                        <span>Tagihan SPP Santri</span>
                    </a>

                    <div class="pt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Integrasi Kemenag</div>
                    <a href="{{ route('admin.rdm.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/rdm*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-cloud-arrow-up w-4 text-center text-emerald-400"></i>
                        <span class="flex items-center gap-2">
                            <span>RDM Kemenag</span>
                            <span class="text-[9px] bg-emerald-500/20 text-emerald-300 px-1.5 py-0.5 rounded font-black">SIMULASI</span>
                        </span>
                    </a>

                    <div class="pt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-3">Publikasi & Konfigurasi</div>
                    <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/berita*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-newspaper w-4 text-center"></i>
                        <span>Manajemen Berita</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->is('admin/pengaturan*') ? 'bg-white/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 font-medium' }} transition-all text-xs">
                        <i class="fa-solid fa-sliders w-4 text-center"></i>
                        <span>Pengaturan Sekolah</span>
                    </a>
                </nav>
            </div>
            
            <div class="p-4 border-t border-white/5">
                <div class="p-3 bg-white/5 rounded-2xl border border-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div class="w-8 h-8 rounded-full bg-school-accent flex items-center justify-center text-slate-900 font-black italic shrink-0 text-xs">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold truncate text-white">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-[9px] text-slate-400 uppercase truncate font-black">
                                {{ Auth::user()->admin_level ? 'Admin ' . strtoupper(Auth::user()->admin_level) : 'Admin Global' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-72 bg-slate-50 min-w-0">
            <!-- Header -->
            <header class="h-16 sm:h-20 bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <button id="admin-sidebar-btn" aria-label="Buka Menu" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-900 text-lg hover:bg-slate-200 transition-colors shrink-0">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                    <div class="flex items-center gap-2 sm:gap-3 truncate">
                        <h2 class="text-sm sm:text-lg font-black tracking-tight text-slate-900 uppercase truncate">@yield('page_title', 'Dashboard')</h2>
                        <!-- Context badge in Header -->
                        <span class="hidden md:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black tracking-wider uppercase {{ $contextBadge['bg_class'] ?? 'bg-emerald-50 text-emerald-700' }} border">
                            <span class="w-1.5 h-1.5 rounded-full {{ $contextBadge['dot_class'] ?? 'bg-emerald-500' }}"></span>
                            <span>{{ $contextBadge['label'] ?? 'Global' }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    <!-- Notification Bell -->
                    <a href="{{ route('notifikasi.index') }}" class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-all" title="Notifikasi In-App">
                        <i class="fa-solid fa-bell text-sm sm:text-base"></i>
                        @if(Auth::check() && Auth::user()->unreadNotifikasisCount() > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
                        @endif
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 px-3 py-2 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs hover:bg-rose-100 transition-all">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Demo Mode Banner Notice -->
            <div class="bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border-b border-amber-200/60 px-4 sm:px-8 py-2 text-[11px] font-semibold text-amber-900 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="bg-amber-500 text-white font-black text-[9px] px-1.5 py-0.5 rounded uppercase">Demo SIAS Multi-Unit</span>
                    <span>Versi Terpadu MA Attaraqqie (Multi-Jenjang, Segmentasi Putra/Putri & Layanan Wali Murid)</span>
                </div>
                <div class="hidden sm:flex items-center gap-3 text-[10px] text-amber-700">
                    <span>Ganti unit kapan saja via tombol di sidebar</span>
                </div>
            </div>

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

                @if(session('info'))
                    <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 text-sm flex items-center gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
                        <span>{{ session('info') }}</span>
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
