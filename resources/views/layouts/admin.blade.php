<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — SMA Task Master</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-slate-900 text-white fixed h-full z-40 hidden lg:block">
            <div class="p-8">
                <a href="/" class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 bg-school-primary rounded-xl flex items-center justify-center text-white text-xl">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-xl font-black tracking-tighter uppercase italic">Task Master</span>
                </a>

                <nav class="space-y-2">
                    <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-4">Utama</div>
                    <a href="/admin/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-white/10 text-white font-bold transition-all shadow-lg border border-white/5">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard
                    </a>
                    
                    <div class="pt-8 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-4">Eksistensi</div>
                    <a href="/admin/berita" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fa-solid fa-newspaper"></i> Manajemen Berita
                    </a>
                    <a href="/admin/galeri" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fa-solid fa-images"></i> Galeri Kegiatan
                    </a>

                    <div class="pt-8 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-4">Akademik</div>
                    <a href="/admin/ppdb" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fa-solid fa-user-plus"></i> Pendaftar PPDB
                    </a>
                    <a href="/admin/guru" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fa-solid fa-user-tie"></i> Data Guru
                    </a>

                    <div class="pt-8 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-4">Lainnya</div>
                    <a href="/admin/pengaturan" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <i class="fa-solid fa-gear"></i> Pengaturan
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-8 left-8 right-8">
                <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-school-accent flex items-center justify-center text-slate-900 font-black italic">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 uppercase truncate font-black">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-72 bg-slate-50">
            <!-- Header -->
            <header class="h-24 bg-white/70 backdrop-blur border-b border-slate-200 sticky top-0 z-30 px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-2xl text-slate-900"><i class="fa-solid fa-bars-staggered"></i></button>
                    <h2 class="text-xl font-extrabold tracking-tight text-slate-900 uppercase">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-6">
                    <button class="relative w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-all">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>
                    </button>
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs hover:bg-rose-100 transition-all">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
