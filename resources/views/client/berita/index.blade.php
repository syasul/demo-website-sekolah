@extends('layouts.client')

@section('title', 'Berita & Pengumuman — SMA Task Master')

@section('content')
<!-- Header Berita -->
<section class="py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 italic uppercase tracking-tighter">Berita <span class="text-school-primary">&</span> Info</h1>
        <p class="text-slate-500 max-w-2xl leading-relaxed">Pusat informasi terkini, liputan kegiatan, dan pengumuman resmi SMA Task Master.</p>
    </div>
</section>

<!-- Filter & Search -->
<div class="sticky top-24 z-30 glass border-y border-white/10 py-5">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex gap-4 overflow-x-auto pb-2 md:pb-0 w-full md:w-auto">
            <button class="px-6 py-2 bg-slate-900 text-white rounded-full text-xs font-bold whitespace-nowrap">Semua</button>
            <button class="px-6 py-2 bg-white text-slate-500 border border-slate-100 rounded-full text-xs font-bold whitespace-nowrap hover:bg-slate-50">Berita</button>
            <button class="px-6 py-2 bg-white text-slate-500 border border-slate-100 rounded-full text-xs font-bold whitespace-nowrap hover:bg-slate-50">Pengumuman</button>
            <button class="px-6 py-2 bg-white text-slate-500 border border-slate-100 rounded-full text-xs font-bold whitespace-nowrap hover:bg-slate-50">Prestasi</button>
        </div>
        
        <div class="relative w-full md:w-80">
            <input type="text" placeholder="Cari berita..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-100 rounded-2xl text-sm focus:outline-none focus:border-school-primary transition-all">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main News Content -->
<section class="py-20 max-w-7xl mx-auto px-6">
    <!-- Featured News -->
    <div class="mb-20">
        <div class="group relative rounded-[50px] overflow-hidden shadow-2xl h-[500px]">
            <img src="{{ asset('images/hero_students.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            <div class="absolute bottom-12 left-12 right-12 text-white max-w-3xl">
                <span class="px-4 py-1.5 bg-school-primary text-white text-[10px] font-black rounded-full mb-6 inline-block uppercase tracking-widest">Headline</span>
                <h2 class="text-3xl md:text-5xl font-black mb-6 leading-tight uppercase tracking-tighter italic">Persiapan Menuju Olimpiade Sains Nasional (OSN) 2024</h2>
                <div class="flex items-center gap-6 text-sm font-bold text-slate-300">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-calendar-day"></i> 14 Juni 2024</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-user-edit"></i> Admin Sekolah</span>
                </div>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
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
            <div class="aspect-[4/3] rounded-[40px] overflow-hidden mb-8 relative shadow-sm border border-slate-50 transition-all group-hover:shadow-xl group-hover:-translate-y-2">
                <img src="{{ asset('images/' . $local_news_images[($i - 1) % count($local_news_images)]) }}" class="w-full h-full object-cover" alt="News Image">
                <div class="absolute top-6 right-6">
                    <div class="w-12 h-12 bg-white/90 backdrop-blur rounded-2xl flex items-center justify-center text-slate-900 text-xl font-black">
                        <i class="fa-solid fa-newspaper text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div class="flex items-center gap-3 text-[10px] font-black text-school-primary uppercase tracking-widest mb-4">
                    <span>Berita</span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span class="text-slate-400 italic">12 Menit Lalu</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-school-primary transition-colors leading-tight tracking-tight uppercase">Wisuda Angkatan XV: Melangkah Pasti Menuju Masa Depan</h3>
                <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 italic mb-6">Momen haru sekaligus membanggakan bagi 450 siswa kelas XII yang telah menyelesaikan masa baktinya di sekolah...</p>
                <a href="/berita/detail" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest group-hover:gap-4 transition-all">
                    Detail Berita <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </article>
        @endfor
    </div>
    
    <!-- Pagination -->
    <div class="mt-20 flex justify-center gap-2">
        <button class="w-12 h-12 flex items-center justify-center rounded-xl bg-slate-900 text-white font-bold transition-all hover:scale-105">1</button>
        <button class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-900 font-bold transition-all hover:bg-slate-50">2</button>
        <button class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-900 font-bold transition-all hover:bg-slate-50">3</button>
        <button class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-900 font-bold transition-all hover:bg-slate-50">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>
@endsection
