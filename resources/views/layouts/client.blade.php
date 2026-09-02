<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Sekolah')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('head')
</head>
<body class="antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <div class="glass rounded-2xl px-4 sm:px-6 py-3 flex justify-between items-center shadow-lg border border-white/20">
                <a href="/" class="flex items-center gap-2.5 sm:gap-3 group">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-school-primary rounded-xl flex items-center justify-center text-white text-lg sm:text-xl font-bold shadow-md shadow-school-primary/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-base sm:text-xl font-extrabold tracking-tight text-slate-900 dark:text-white uppercase">SMA Task Master</span>
                </a>

                <div class="hidden lg:flex items-center gap-6 xl:gap-8">
                    <a href="/" class="text-sm font-bold {{ request()->is('/') ? 'text-school-primary' : 'text-slate-600' }} hover:text-school-primary transition-colors">Beranda</a>
                    <a href="/profil" class="text-sm font-bold {{ request()->is('profil*') ? 'text-school-primary' : 'text-slate-600' }} hover:text-school-primary transition-colors">Profil</a>
                    <a href="/akademik" class="text-sm font-bold {{ request()->is('akademik*') ? 'text-school-primary' : 'text-slate-600' }} hover:text-school-primary transition-colors">Akademik</a>
                    <a href="/fasilitas" class="text-sm font-bold {{ request()->is('fasilitas*') ? 'text-school-primary' : 'text-slate-600' }} hover:text-school-primary transition-colors">Fasilitas</a>
                    <a href="/kesiswaan" class="text-sm font-bold {{ request()->is('kesiswaan*') ? 'text-school-primary' : 'text-slate-600' }} hover:text-school-primary transition-colors">Kesiswaan</a>
                    <a href="/berita" class="text-sm font-bold {{ request()->is('berita*') ? 'text-school-primary' : 'text-slate-600' }} hover:text-school-primary transition-colors">Berita</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="/ppdb" class="hidden sm:inline-flex items-center gap-2 px-5 sm:px-6 py-2 sm:py-2.5 bg-school-primary text-white text-xs sm:text-sm font-bold rounded-xl hover:scale-105 transition-all shadow-md shadow-school-primary/20">
                        <span>Daftar PPDB</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <!-- Mobile Hamburger Button -->
                    <button id="mobile-menu-btn" aria-label="Buka Menu" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-xl hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

    <!-- Mobile Drawer Menu -->
    <div id="mobile-menu-drawer" class="fixed top-0 right-0 w-[85%] max-w-sm h-full bg-white dark:bg-slate-900 z-50 shadow-2xl translate-x-full transition-transform duration-300 ease-out flex flex-col lg:hidden border-l border-slate-200 dark:border-slate-800">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-school-primary rounded-lg flex items-center justify-center text-white text-base font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-base font-black tracking-tight text-slate-900 dark:text-white uppercase">Menu Navigasi</span>
            </div>
            <button id="mobile-menu-close" aria-label="Tutup Menu" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-2">
            <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('/') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-house w-5 text-center"></i>
                <span>Beranda</span>
            </a>
            <a href="/profil" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('profil*') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-school w-5 text-center"></i>
                <span>Profil Sekolah</span>
            </a>
            <a href="/akademik" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('akademik*') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-book-open-reader w-5 text-center"></i>
                <span>Akademik</span>
            </a>
            <a href="/fasilitas" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('fasilitas*') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-building-columns w-5 text-center"></i>
                <span>Fasilitas</span>
            </a>
            <a href="/kesiswaan" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('kesiswaan*') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-users-line w-5 text-center"></i>
                <span>Kesiswaan</span>
            </a>
            <a href="/berita" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('berita*') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-newspaper w-5 text-center"></i>
                <span>Berita & Artikel</span>
            </a>
            <a href="/virtual-tour" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->is('virtual-tour*') ? 'bg-school-primary text-white shadow-md shadow-school-primary/20' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800' }} transition-colors">
                <i class="fa-solid fa-vr-cardboard w-5 text-center"></i>
                <span>Virtual Tour 360°</span>
            </a>
        </div>

        <div class="p-6 border-t border-slate-100 dark:border-slate-800 space-y-3">
            <a href="/ppdb" class="w-full flex items-center justify-center gap-2 py-3.5 bg-school-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-school-primary/20 hover:opacity-95 transition-all">
                <span>Daftar PPDB Online</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
            <div class="flex items-center justify-center gap-4 pt-2 text-slate-400 text-base">
                <a href="#" class="hover:text-school-primary transition-colors"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-school-primary transition-colors"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-school-primary transition-colors"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <main class="pt-20 sm:pt-24 overflow-x-hidden">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 py-12 sm:py-16 lg:py-20 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
            <div class="sm:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-xl sm:text-2xl font-black tracking-tight text-white uppercase">SMA Task Master</span>
                </div>
                <p class="text-slate-400 text-sm max-w-md leading-relaxed mb-6">
                    Mencetak generasi unggul, berkarakter, dan siap menghadapi tantangan dunia masa depan dengan integritas serta kompetensi tinggi.
                </p>
                <div class="flex gap-3">
                    <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-xl border border-white/10 flex items-center justify-center hover:bg-white/10 hover:border-white/30 transition-all">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" aria-label="Facebook" class="w-10 h-10 rounded-xl border border-white/10 flex items-center justify-center hover:bg-white/10 hover:border-white/30 transition-all">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" aria-label="YouTube" class="w-10 h-10 rounded-xl border border-white/10 flex items-center justify-center hover:bg-white/10 hover:border-white/30 transition-all">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-base sm:text-lg font-bold mb-4 sm:mb-6">Navigasi</h4>
                <ul class="space-y-3 sm:space-y-4 text-sm text-slate-400">
                    <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="/profil" class="hover:text-white transition-colors">Profil Sekolah</a></li>
                    <li><a href="/akademik" class="hover:text-white transition-colors">Akademik</a></li>
                    <li><a href="/fasilitas" class="hover:text-white transition-colors">Fasilitas</a></li>
                    <li><a href="/kesiswaan" class="hover:text-white transition-colors">Kesiswaan</a></li>
                    <li><a href="/berita" class="hover:text-white transition-colors">Berita Terkini</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-base sm:text-lg font-bold mb-4 sm:mb-6">Kontak & Lokasi</h4>
                <ul class="space-y-3 sm:space-y-4 text-sm text-slate-400">
                    <li class="flex gap-3 items-start">
                        <i class="fa-solid fa-location-dot mt-1 text-school-primary shrink-0"></i>
                        <span>Jl. Pendidikan No. 123, Kota Malang, Jawa Timur</span>
                    </li>
                    <li class="flex gap-3 items-center">
                        <i class="fa-solid fa-phone text-school-primary shrink-0"></i>
                        <span>(0341) 123456</span>
                    </li>
                    <li class="flex gap-3 items-center">
                        <i class="fa-solid fa-envelope text-school-primary shrink-0"></i>
                        <span>info@smataskmaster.sch.id</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-8 sm:pt-12 mt-8 sm:mt-12 border-t border-white/5 text-center text-xs text-slate-500 italic">
            &copy; {{ date('Y') }} SMA Task Master. All rights reserved.
        </div>
    </footer>

    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (navbar) {
                if (window.scrollY > 30) {
                    navbar.classList.add('py-1');
                    navbar.querySelector('.glass')?.classList.add('shadow-xl');
                } else {
                    navbar.classList.remove('py-1');
                    navbar.querySelector('.glass')?.classList.remove('shadow-xl');
                }
            }
        });

        // Mobile Drawer Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const menuClose = document.getElementById('mobile-menu-close');
        const menuOverlay = document.getElementById('mobile-menu-overlay');
        const menuDrawer = document.getElementById('mobile-menu-drawer');

        function openDrawer() {
            if (menuOverlay && menuDrawer) {
                menuOverlay.classList.remove('opacity-0', 'pointer-events-none');
                menuOverlay.classList.add('opacity-100', 'pointer-events-auto');
                menuDrawer.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeDrawer() {
            if (menuOverlay && menuDrawer) {
                menuOverlay.classList.add('opacity-0', 'pointer-events-none');
                menuOverlay.classList.remove('opacity-100', 'pointer-events-auto');
                menuDrawer.classList.add('translate-x-full');
                document.body.style.overflow = '';
            }
        }

        if (menuBtn) menuBtn.addEventListener('click', openDrawer);
        if (menuClose) menuClose.addEventListener('click', closeDrawer);
        if (menuOverlay) menuOverlay.addEventListener('click', closeDrawer);

        // Close on ESC key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDrawer();
        });
    </script>
    @yield('scripts')
</body>
</html>

