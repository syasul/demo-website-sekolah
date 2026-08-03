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
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="glass rounded-2xl px-6 py-3 flex justify-between items-center shadow-lg border border-white/20">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-school-primary rounded-xl flex items-center justify-center text-white text-xl font-bold">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white uppercase">SMA Task Master</span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-sm font-bold text-slate-600 hover:text-school-primary transition-colors">Beranda</a>
                    <a href="/profil" class="text-sm font-bold text-slate-600 hover:text-school-primary transition-colors">Profil</a>
                    <a href="/akademik" class="text-sm font-bold text-slate-600 hover:text-school-primary transition-colors">Akademik</a>
                    <a href="/kesiswaan" class="text-sm font-bold text-slate-600 hover:text-school-primary transition-colors">Kesiswaan</a>
                    <a href="/berita" class="text-sm font-bold text-slate-600 hover:text-school-primary transition-colors">Berita</a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/ppdb" class="hidden sm:flex px-6 py-2.5 bg-school-primary text-white text-sm font-bold rounded-xl hover:scale-105 transition-all shadow-md">
                        Daftar PPDB
                    </a>
                    <button class="md:hidden text-slate-900 dark:text-white text-2xl">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 py-20 text-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-2xl font-black tracking-tight text-white uppercase">SMA Task Master</span>
                </div>
                <p class="text-slate-400 text-sm max-w-md leading-relaxed mb-8">
                    Mencetak generasi unggul, berkarakter, dan siap menghadapi tantangan dunia masa depan dengan integritas serta kompetensi tinggi.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-lg font-bold mb-6">Navigasi</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="/profil" class="hover:text-white transition-colors">Profil Sekolah</a></li>
                    <li><a href="/akademik" class="hover:text-white transition-colors">Akademik</a></li>
                    <li><a href="/berita" class="hover:text-white transition-colors">Berita Terkini</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-6">Kontak</h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-school-primary"></i>
                        <span>Jl. Pendidikan No. 123, Kota Malang, Jawa Timur</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fa-solid fa-phone text-school-primary"></i>
                        <span>(0341) 123456</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fa-solid fa-envelope text-school-primary"></i>
                        <span>info@smataskmaster.sch.id</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-12 mt-12 border-t border-white/5 text-center text-xs text-slate-500 italic">
            &copy; {{ date('Y') }} SMA Task Master. All rights reserved.
        </div>
    </footer>

    <script>
        window.onscroll = function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('py-2');
                navbar.querySelector('.glass').classList.add('shadow-xl');
            } else {
                navbar.classList.remove('py-2');
                navbar.querySelector('.glass').classList.remove('shadow-xl');
            }
        };
    </script>
    @yield('scripts')
</body>
</html>
