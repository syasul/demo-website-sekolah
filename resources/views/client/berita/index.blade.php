@extends('layouts.client')

@section('title', 'Berita & Pengumuman — MA At-Taraqqie')

@section('content')
<!-- Header Berita -->
<section class="py-14 sm:py-20 lg:py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-school-primary/10 rounded-full border border-school-primary/20 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-primary">
            Kanal Informasi
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 mb-4 sm:mb-6 italic uppercase tracking-tighter">Berita <span class="text-school-primary">&</span> Info</h1>
        <p class="text-sm sm:text-base text-slate-500 max-w-2xl leading-relaxed">Pusat informasi terkini, liputan kegiatan, dan pengumuman resmi MA At-Taraqqie.</p>
    </div>
</section>

<!-- Filter & Search -->
<div class="sticky top-[68px] sm:top-20 lg:top-24 z-30 glass border-y border-white/10 py-3 sm:py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-3 sm:gap-6">
        <div class="flex gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-1 md:pb-0">
            <button class="px-4 sm:px-6 py-2 bg-slate-900 text-white rounded-full text-xs font-bold whitespace-nowrap shadow-sm">Semua</button>
            <button class="px-4 sm:px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold whitespace-nowrap hover:bg-slate-50 shadow-sm">Berita</button>
            <button class="px-4 sm:px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold whitespace-nowrap hover:bg-slate-50 shadow-sm">Pengumuman</button>
            <button class="px-4 sm:px-6 py-2 bg-white text-slate-600 border border-slate-200 rounded-full text-xs font-bold whitespace-nowrap hover:bg-slate-50 shadow-sm">Prestasi</button>
        </div>
        
        <div class="relative w-full md:w-80">
            <input type="text" placeholder="Cari berita..." class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all shadow-sm">
            <div class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs sm:text-sm">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main News Content -->
<section class="py-12 sm:py-16 lg:py-20 max-w-7xl mx-auto px-4 sm:px-6">
    <!-- Featured News -->
    <div class="mb-12 sm:mb-16 lg:mb-20">
        <div class="group relative rounded-3xl sm:rounded-[40px] lg:rounded-[50px] overflow-hidden shadow-2xl h-[360px] sm:h-[440px] lg:h-[500px] border-4 border-white">
            <img src="{{ asset('images/hero_students.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Headline News">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 sm:bottom-10 sm:left-10 sm:right-10 lg:bottom-12 lg:left-12 lg:right-12 text-white max-w-3xl">
                <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-school-primary text-white text-[10px] sm:text-xs font-black rounded-full mb-3 sm:mb-5 inline-block uppercase tracking-widest shadow-md">Headline</span>
                <h2 class="text-xl sm:text-3xl md:text-4xl lg:text-5xl font-black mb-3 sm:mb-5 leading-snug sm:leading-tight uppercase tracking-tighter italic">Persiapan Menuju Olimpiade Sains Nasional (OSN) 2024</h2>
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-xs sm:text-sm font-bold text-slate-300">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-calendar-day text-school-accent"></i> 14 Juni 2024</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-user-pen text-school-accent"></i> Admin Sekolah</span>
                </div>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10">
        @php
        $local_news_images = [
            'hero_students.png',
            'student_medal.png',
            'student_sports.png',
            'facility_library.png',
            'facility_laboratory.png',
            'activity_robotics.png'
        ];
        @endphp
        @for($i = 1; $i <= 6; $i++)
        <article class="group">
            <div class="aspect-[4/3] rounded-3xl sm:rounded-[36px] overflow-hidden mb-5 sm:mb-6 relative shadow-sm border border-slate-100 transition-all group-hover:shadow-xl group-hover:-translate-y-1">
                <img src="{{ asset('images/' . $local_news_images[($i - 1) % count($local_news_images)]) }}" class="w-full h-full object-cover" alt="News Image">
                <div class="absolute top-4 right-4 sm:top-5 sm:right-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 bg-white/90 backdrop-blur rounded-2xl flex items-center justify-center text-slate-900 shadow-md">
                        <i class="fa-solid fa-newspaper text-xs sm:text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="px-2 sm:px-3">
                <div class="flex items-center gap-2 text-[10px] font-black text-school-primary uppercase tracking-widest mb-2.5">
                    <span>Berita</span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span class="text-slate-400 italic">12 Menit Lalu</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-2.5 group-hover:text-school-primary transition-colors leading-snug tracking-tight uppercase">Wisuda Angkatan XV: Melangkah Pasti Menuju Masa Depan</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2 italic mb-4">Momen haru sekaligus membanggakan bagi 450 siswa kelas XII yang telah menyelesaikan masa baktinya di sekolah...</p>
                <a href="/berita" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-900 group-hover:text-school-primary group-hover:gap-3 transition-all">
                    <span>Detail Berita</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </article>
        @endfor
    </div>
    
    <!-- Pagination -->
    <div class="mt-12 sm:mt-16 lg:mt-20 flex justify-center gap-2">
        <button class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl bg-slate-900 text-white font-bold text-xs sm:text-sm transition-all hover:scale-105">1</button>
        <button class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-900 font-bold text-xs sm:text-sm transition-all hover:bg-slate-50">2</button>
        <button class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-900 font-bold text-xs sm:text-sm transition-all hover:bg-slate-50">3</button>
        <button class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-900 font-bold text-xs sm:text-sm transition-all hover:bg-slate-50">
            <i class="fa-solid fa-chevron-right text-xs"></i>
        </button>
    </div>
</section>
@endsection

