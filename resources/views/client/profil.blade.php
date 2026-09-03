@extends('layouts.client')

@section('title', 'Profil Sekolah — MA At-Taraqqie')

@section('content')
<!-- Header Profil -->
<section class="py-14 sm:py-20 lg:py-24 bg-[#130709] text-white relative overflow-hidden border-b border-school-primary/20">
    <div class="absolute inset-0 bg-school-primary/10 -z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full border border-white/10 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-accent">
            Tentang Kami
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black mb-4 sm:mb-6">Profil Sekolah</h1>
        <p class="text-sm sm:text-base text-neutral-400 max-w-2xl leading-relaxed">Mengenal lebih dekat visi, misi, dan perjalanan MA At-Taraqqie dalam mencetak generasi pemimpin dunia yang berakhlak mulia.</p>
    </div>
</section>

<!-- Sub Navigation (Horizontal Scrollable on Mobile) -->
<div class="sticky top-[68px] sm:top-20 lg:top-24 z-30 glass border-y border-white/10 py-3 sm:py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex gap-2 sm:gap-6 overflow-x-auto no-scrollbar">
        <a href="#sejarah" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-school-primary hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors whitespace-nowrap">Sejarah</a>
        <a href="#visi-misi" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-school-primary hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors whitespace-nowrap">Visi & Misi</a>
        <a href="#struktur" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-school-primary hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors whitespace-nowrap">Struktur Organisasi</a>
        <a href="#guru" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-school-primary hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors whitespace-nowrap">Data Guru</a>
        <a href="#akreditasi" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-school-primary hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors whitespace-nowrap">Akreditasi</a>
    </div>
</div>

<!-- Sejarah -->
<section id="sejarah" class="py-16 sm:py-24 lg:py-32 max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 sm:gap-14 lg:gap-20 items-center">
        <div class="space-y-6 sm:space-y-8">
            <div class="w-12 h-1 bg-school-primary"></div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 leading-tight">Perjalanan & Dedikasi</h2>
            <div class="space-y-4 sm:space-y-6 text-slate-600 leading-relaxed text-sm sm:text-base">
                <p>
                    MA At-Taraqqie didirikan dengan semangat untuk menyediakan pendidikan berkualitas tinggi yang mengintegrasikan keilmuan modern, wawasan global, dan pembinaan akhlak mulia berlandaskan Al-Qur'an dan As-Sunnah.
                </p>
                <p>
                    Kami berkomitmen untuk terus berinovasi dan mendidik generasi muda yang berprestasi, berdaya saing global, serta memiliki integritas moral yang kokoh.
                </p>
            </div>
        </div>
        <div class="relative w-full max-w-lg mx-auto lg:max-w-none">
            <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                <img src="{{ asset('images/school_sejarah.png') }}" alt="School History" class="w-full h-full object-cover">
            </div>
            <div class="absolute bottom-3 right-3 sm:-bottom-6 sm:-right-6 p-4 sm:p-8 bg-school-accent rounded-2xl sm:rounded-3xl shadow-xl">
                <div class="text-2xl sm:text-4xl font-black text-slate-900">15+</div>
                <div class="text-[10px] sm:text-xs font-bold text-slate-800 uppercase tracking-wider">Tahun Dedikasi</div>
            </div>
        </div>
    </div>
</section>

<!-- Visi & Misi -->
<section id="visi-misi" class="py-14 sm:py-20 lg:py-32 bg-[#130709] border border-school-primary/20 text-white rounded-3xl sm:rounded-[50px] mx-3 sm:mx-6 shadow-2xl">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 grid grid-cols-1 lg:grid-cols-2 gap-10 sm:gap-14 lg:gap-20">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black mb-6 sm:mb-8 flex items-center gap-3 sm:gap-4">
                <span class="w-10 h-10 bg-school-primary rounded-xl flex items-center justify-center text-lg shrink-0"><i class="fa-solid fa-eye text-school-accent"></i></span>
                <span>Visi Sekolah</span>
            </h2>
            <p class="text-xl sm:text-2xl md:text-3xl font-bold leading-snug text-neutral-100">
                "Menjadi pusat pendidikan unggul yang melahirkan pemimpin berwawasan global, berkarakter mulia, dan kompetitif secara internasional."
            </p>
        </div>
        <div>
            <h2 class="text-2xl sm:text-3xl font-black mb-6 sm:mb-8 flex items-center gap-3 sm:gap-4">
                <span class="w-10 h-10 bg-school-accent rounded-xl flex items-center justify-center text-lg text-slate-900 shrink-0"><i class="fa-solid fa-bullseye"></i></span>
                <span>Misi Sekolah</span>
            </h2>
            <ul class="space-y-4 sm:space-y-6">
                <li class="flex gap-3 sm:gap-4 items-start">
                    <div class="text-school-accent text-lg sm:text-xl shrink-0 mt-0.5"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-sm sm:text-base text-neutral-300">Menyelenggarakan pembelajaran berbasis teknologi yang inovatif dan adaptif.</p>
                </li>
                <li class="flex gap-3 sm:gap-4 items-start">
                    <div class="text-school-accent text-lg sm:text-xl shrink-0 mt-0.5"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-sm sm:text-base text-neutral-300">Membina karakter siswa melalui program religius dan etika kepemimpinan.</p>
                </li>
                <li class="flex gap-3 sm:gap-4 items-start">
                    <div class="text-school-accent text-lg sm:text-xl shrink-0 mt-0.5"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-sm sm:text-base text-neutral-300">Mengembangkan bakat siswa dalam bidang non-akademik secara maksimal.</p>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Struktur Organisasi -->
<section id="struktur" class="py-16 sm:py-24 lg:py-32 max-w-7xl mx-auto px-4 sm:px-6 text-center">
    <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-10 sm:mb-16">Struktur Organisasi</h2>
    <div class="flex flex-col items-center gap-8 sm:gap-12 w-full">
        <!-- Kepala Sekolah -->
        <div class="p-6 bg-white rounded-3xl shadow-lg border border-slate-100 max-w-xs w-full transition-transform hover:-translate-y-1">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden mx-auto mb-4 border-4 border-school-primary/20">
                <img src="{{ asset('images/teacher_male.png') }}" class="w-full h-full object-cover">
            </div>
            <h4 class="font-bold text-sm sm:text-base text-slate-900">Dr. Budi Santoso, M.Pd</h4>
            <p class="text-[11px] sm:text-xs text-school-primary font-bold uppercase tracking-widest mt-1">Kepala Sekolah</p>
        </div>
        
        <!-- Wakil Kepala Sekolah -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 w-full max-w-5xl">
            <div class="p-5 bg-white rounded-2xl shadow-md border border-slate-50">
                <h5 class="font-bold text-sm text-slate-900">Siti Aminah, S.Pd</h5>
                <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider mt-1">Waka Kurikulum</p>
            </div>
            <div class="p-5 bg-white rounded-2xl shadow-md border border-slate-50">
                <h5 class="font-bold text-sm text-slate-900">Andi Wijaya, M.Si</h5>
                <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider mt-1">Waka Kesiswaan</p>
            </div>
            <div class="p-5 bg-white rounded-2xl shadow-md border border-slate-50">
                <h5 class="font-bold text-sm text-slate-900">Dewi Sartika, M.Pd</h5>
                <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider mt-1">Waka Sarana</p>
            </div>
            <div class="p-5 bg-white rounded-2xl shadow-md border border-slate-50">
                <h5 class="font-bold text-sm text-slate-900">Hendra Pratama, S.T</h5>
                <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider mt-1">Waka Humas</p>
            </div>
        </div>
    </div>
</section>

<!-- Data Guru -->
<section id="guru" class="py-16 sm:py-24 lg:py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row justify-between sm:items-end mb-10 sm:mb-16 gap-4">
            <div>
                <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900">Tenaga Pendidik</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">Pendidik berkompetensi tinggi dan berpengalaman.</p>
            </div>
            <div class="text-xs sm:text-sm font-bold text-slate-500 bg-white px-4 py-2 rounded-full border border-slate-200 self-start sm:self-auto">
                Total 85+ Guru Profesional
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl overflow-hidden mx-auto mb-5 transition-transform group-hover:scale-105">
                    <img src="{{ asset('images/teacher_female.png') }}" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-white">Laila Rahayu, M.Pd</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80 mt-1">Guru Matematika</p>
            </div>
            
            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl overflow-hidden mx-auto mb-5 transition-transform group-hover:scale-105">
                    <img src="{{ asset('images/teacher_male.png') }}" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-white">Ahmad Fauzi, S.Si</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80 mt-1">Guru Fisika</p>
            </div>

            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl overflow-hidden mx-auto mb-5 transition-transform group-hover:scale-105">
                    <img src="{{ asset('images/teacher_male.png') }}" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-white">Rizky Ramadhan, M.A</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80 mt-1">Guru Bahasa Inggris</p>
            </div>

            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl overflow-hidden mx-auto mb-5 transition-transform group-hover:scale-105">
                    <img src="{{ asset('images/teacher_female.png') }}" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-white">Diana Lestari, S.Pd</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80 mt-1">Guru Biologi</p>
            </div>
        </div>
    </div>
</section>

<!-- Akreditasi -->
<section id="akreditasi" class="py-16 sm:py-24 lg:py-32 bg-school-primary text-white overflow-hidden relative">
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
        <div class="inline-block p-3.5 sm:p-4 bg-white/10 rounded-3xl border border-white/20 mb-6">
            <i class="fa-solid fa-certificate text-4xl sm:text-5xl text-school-accent"></i>
        </div>
        <h2 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-6 uppercase tracking-tighter italic">Terakreditasi A+ (Unggul)</h2>
        <p class="text-sm sm:text-base text-white/80 max-w-xl mx-auto leading-relaxed">
            Berdasarkan Keputusan Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M) Tahun 2023, MA At-Taraqqie memperoleh nilai 98 dengan predikat Terakreditasi Unggul.
        </p>
    </div>
</section>
@endsection

