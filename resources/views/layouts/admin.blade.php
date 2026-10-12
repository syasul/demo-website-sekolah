<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal') — MA Attaraqqie</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50/70 font-sans text-slate-800 antialiased overflow-x-hidden selection:bg-emerald-100 selection:text-emerald-900">
    <!-- Admin Mobile Drawer Overlay -->
    <div id="admin-sidebar-overlay" class="fixed inset-0 bg-slate-900/30 backdrop-blur-xs z-40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar & Mobile Off-canvas Drawer (LIGHT MODE) -->
        <aside id="admin-sidebar" class="w-72 bg-white text-slate-700 fixed h-full z-50 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0 flex flex-col justify-between border-r border-slate-200/80 shadow-xs">
            <div class="p-4 sm:p-5 overflow-y-auto flex-1">
                <!-- Brand Header -->
                <div class="flex items-center justify-between mb-5 px-1">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo MA Attaraqqie" class="w-9 h-9 object-contain drop-shadow-xs">
                        <div class="min-w-0">
                            <span class="text-sm font-black tracking-tight uppercase block leading-none text-slate-900 group-hover:text-emerald-700 transition-colors">Attaraqqie</span>
                            <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest block mt-1">Sistem Terpadu</span>
                        </div>
                    </a>
                    <button id="admin-sidebar-close" aria-label="Tutup Menu" class="lg:hidden w-8 h-8 rounded-lg bg-slate-100 text-slate-500 hover:text-slate-800 hover:bg-slate-200 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- LIGHT MODE WORKSPACE / UNIT SWITCHER (Floating Popover Style) -->
                <div class="mb-5 relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" 
                            class="w-full flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 text-left transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-2 h-2 rounded-full {{ $contextBadge['dot_class'] ?? 'bg-emerald-500' }} shrink-0"></span>
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block leading-none">Unit Aktif</span>
                                <span class="text-xs font-bold text-slate-800 block truncate leading-tight mt-1">{{ $contextBadge['label'] ?? 'Semua Unit' }}</span>
                            </div>
                        </div>
                        @if(Auth::user()->isAdminGlobal())
                            <div class="w-6 h-6 rounded-lg bg-white border border-slate-200/60 group-hover:bg-slate-200/60 flex items-center justify-center text-slate-400 group-hover:text-slate-700 transition-colors shrink-0">
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </div>
                        @else
                            <i class="fa-solid fa-lock text-[10px] text-slate-400 shrink-0" title="Akses terisolasi"></i>
                        @endif
                    </button>

                    @if(Auth::user()->isAdminGlobal())
                    <!-- Light Floating Popover Menu -->
                    <div x-show="open" @click.away="open = false" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-98"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 -translate-y-1 scale-98"
                         class="absolute left-0 right-0 top-full mt-2 bg-white border border-slate-200 shadow-xl rounded-2xl p-2 z-50 space-y-1 max-h-80 overflow-y-auto">
                        
                        <!-- Global Option -->
                        <form method="POST" action="{{ route('admin.switch-unit') }}">
                            @csrf
                            <input type="hidden" name="mode" value="global">
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-xl {{ empty($activeUnitId) && empty($activeJenjangId) ? 'bg-emerald-50 text-emerald-800 font-bold border border-emerald-200' : 'text-slate-700 hover:bg-slate-50 font-medium' }} flex items-center justify-between text-xs transition-colors">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-building-columns text-[11px] text-emerald-600"></i>
                                    <span>Semua Unit (Yayasan Global)</span>
                                </span>
                                @if(empty($activeUnitId) && empty($activeJenjangId))
                                    <i class="fa-solid fa-check text-xs text-emerald-600"></i>
                                @endif
                            </button>
                        </form>

                        <!-- Jenjang & Unit Grouping -->
                        @if(isset($allJenjangs))
                            @foreach($allJenjangs as $jenjang)
                                <div class="pt-2 pb-1 px-2.5 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">{{ $jenjang->nama }} ({{ $jenjang->kode }})</span>
                                </div>
                                <div class="grid grid-cols-2 gap-1 px-1">
                                    @foreach($jenjang->units as $u)
                                        @php
                                            $isPa = $u->gender === 'putra';
                                            $isActive = isset($activeUnitId) && $activeUnitId == $u->id;
                                        @endphp
                                        <form method="POST" action="{{ route('admin.switch-unit') }}">
                                            @csrf
                                            <input type="hidden" name="mode" value="unit">
                                            <input type="hidden" name="unit_id" value="{{ $u->id }}">
                                            <button type="submit" class="w-full text-left p-2 rounded-lg text-[11px] {{ $isActive ? ($isPa ? 'bg-sky-50 text-sky-800 font-bold border border-sky-200' : 'bg-purple-50 text-purple-800 font-bold border border-purple-200') : 'text-slate-700 hover:bg-slate-50' }} flex items-center justify-between transition-colors">
                                                <span class="flex items-center gap-1.5 truncate">
                                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-mono font-bold {{ $isPa ? 'bg-sky-100 text-sky-700' : 'bg-purple-100 text-purple-700' }}">{{ $isPa ? 'PA' : 'PI' }}</span>
                                                    <span class="truncate">{{ $isPa ? 'Putra' : 'Putri' }}</span>
                                                </span>
                                                @if($isActive)
                                                    <i class="fa-solid fa-check text-[10px]"></i>
                                                @endif
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @endif
                </div>

                <!-- LIGHT NAVIGATION MENUS -->
                <nav class="space-y-4">
                    <!-- Utama -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Utama</div>
                        <div class="space-y-0.5">
                            <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/dashboard*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-chart-pie w-4 text-center {{ request()->is('admin/dashboard*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Dashboard</span>
                            </a>
                        </div>
                    </div>

                    <!-- Akademik & Siswa -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Akademik & Siswa</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/ppdb*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-user-plus w-4 text-center {{ request()->is('admin/ppdb*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Pendaftar PPDB</span>
                            </a>
                            <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/siswa*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-user-graduate w-4 text-center {{ request()->is('admin/siswa*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Data Santri</span>
                            </a>
                            <a href="{{ route('admin.absensi.siswa') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/absensi-siswa*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-clipboard-user w-4 text-center {{ request()->is('admin/absensi-siswa*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Presensi Siswa</span>
                            </a>
                            <a href="{{ route('admin.kelas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/kelas*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-chalkboard w-4 text-center {{ request()->is('admin/kelas*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Manajemen Rombel</span>
                            </a>
                            <a href="{{ route('admin.mata-pelajaran.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/mata-pelajaran*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-book-bookmark w-4 text-center {{ request()->is('admin/mata-pelajaran*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Mata Pelajaran & KKM</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pendidik & Kinerja -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Pendidik & Kinerja</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('admin.guru.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/guru*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-user-tie w-4 text-center {{ request()->is('admin/guru*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Data Asatidz / Guru</span>
                            </a>
                            <a href="{{ route('admin.absensi.guru') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/absensi-guru*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-calendar-check w-4 text-center {{ request()->is('admin/absensi-guru*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Presensi & Jurnal Guru</span>
                            </a>
                            <a href="{{ route('admin.evaluasi.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/evaluasi-guru*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-award w-4 text-center {{ request()->is('admin/evaluasi-guru*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Evaluasi Kinerja Guru</span>
                            </a>
                            <a href="{{ route('admin.rumah-jurnal.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/rumah-jurnal*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-book-open w-4 text-center {{ request()->is('admin/rumah-jurnal*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Rumah Jurnal</span>
                            </a>
                        </div>
                    </div>

                    <!-- Karakter & Kedisiplinan -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Karakter & Kedisiplinan</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('admin.kedisiplinan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/kedisiplinan') || request()->is('admin/kedisiplinan/tambah') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-shield-halved w-4 text-center {{ request()->is('admin/kedisiplinan*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Poin Kedisiplinan</span>
                            </a>
                            <a href="{{ route('admin.kedisiplinan.student-of-the-year') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/kedisiplinan/student-of-the-year*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-trophy w-4 text-center text-amber-500"></i>
                                <span>Student of the Year</span>
                            </a>
                        </div>
                    </div>

                    <!-- Keuangan & Administrasi -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Keuangan & Administrasi</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('admin.keuangan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/keuangan*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-receipt w-4 text-center {{ request()->is('admin/keuangan*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Tagihan SPP Santri</span>
                            </a>
                        </div>
                    </div>

                    <!-- Integrasi Kemenag -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Integrasi Kemenag</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('admin.rdm.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/rdm*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-cloud-arrow-up w-4 text-center {{ request()->is('admin/rdm*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span class="flex items-center justify-between flex-1">
                                    <span>RDM Kemenag</span>
                                    <span class="text-[9px] bg-slate-100 border border-slate-200 text-slate-600 px-1.5 py-0.5 rounded font-mono font-bold">Simulasi</span>
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- Konfigurasi -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-1.5">Sistem</div>
                        <div class="space-y-0.5">
                            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/berita*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-newspaper w-4 text-center {{ request()->is('admin/berita*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Portal Berita</span>
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl {{ request()->is('admin/pengaturan*') ? 'bg-emerald-50 text-emerald-900 font-bold border border-emerald-200/70 shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium' }} transition-colors text-xs">
                                <i class="fa-solid fa-sliders w-4 text-center {{ request()->is('admin/pengaturan*') ? 'text-emerald-700' : 'text-slate-400' }}"></i>
                                <span>Pengaturan Madrasah</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            
            <!-- Bottom Profile Bar (Light Mode) -->
            <div class="p-3 border-t border-slate-200/80 bg-slate-50/60">
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200/80 text-slate-700 font-bold flex items-center justify-center shrink-0 text-xs shadow-2xs">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-slate-800 truncate leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5">
                                {{ Auth::user()->admin_level ? 'Admin ' . ucfirst(Auth::user()->admin_level) : 'Admin Yayasan' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 lg:ml-72 bg-slate-50/70 min-w-0 flex flex-col min-h-screen">
            <!-- Sleek Top Navbar -->
            <header class="h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <button id="admin-sidebar-btn" aria-label="Buka Menu" class="lg:hidden w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors shrink-0">
                        <i class="fa-solid fa-bars-staggered text-sm"></i>
                    </button>
                    <div class="flex items-center gap-2.5 truncate">
                        <h1 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight truncate">@yield('page_title', 'Dashboard')</h1>
                        
                        <!-- Minimalist Context Chip in Navbar -->
                        <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                            <span class="w-1.5 h-1.5 rounded-full {{ $contextBadge['dot_class'] ?? 'bg-emerald-500' }}"></span>
                            <span>{{ $contextBadge['label'] ?? 'Semua Unit' }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                    <!-- Notification Bell -->
                    <a href="{{ route('notifikasi.index') }}" class="relative w-9 h-9 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center justify-center transition-colors" title="Notifikasi">
                        <i class="fa-regular fa-bell text-sm"></i>
                        @if(Auth::check() && Auth::user()->unreadNotifikasisCount() > 0)
                            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>
                        @endif
                    </a>

                    <!-- Clean Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-semibold text-xs transition-colors" title="Keluar">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Container -->
            <main class="p-4 sm:p-6 lg:p-8 flex-1">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3 shadow-2xs">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-3 shadow-2xs">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Minimalist Footer -->
            <footer class="px-6 py-4 border-t border-slate-200/60 text-center sm:flex sm:items-center sm:justify-between text-xs text-slate-400 bg-white/50">
                <p>&copy; {{ date('Y') }} MA At-Taraqqie. Sistem Informasi Akademik & Raport Digital.</p>
                <p class="mt-1 sm:mt-0 font-medium">Platform Terpadu Multi-Unit</p>
            </footer>
        </div>
    </div>

    <!-- Mobile Drawer Script -->
    <script>
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
</body>
</html>
