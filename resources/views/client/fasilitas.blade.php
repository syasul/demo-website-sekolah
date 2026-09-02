@extends('layouts.client')

@section('title', 'Fasilitas — MA At-Taraqqie')

@section('content')
<!-- Header Fasilitas -->
<section class="py-14 sm:py-20 lg:py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-school-primary/10 -z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full border border-white/10 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-accent">
            Sarana & Prasarana
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black mb-4 sm:mb-6">Fasilitas Sekolah</h1>
        <p class="text-sm sm:text-base text-slate-400 max-w-2xl leading-relaxed">Lingkungan belajar kondusif dengan dukungan sarana dan prasarana modern untuk menunjang aktivitas akademik maupun non-akademik.</p>
    </div>
</section>

<!-- Fasilitas Grid -->
<section class="py-16 sm:py-24 lg:py-32 max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">
        <!-- Fasilitas Item 1 -->
        <div class="space-y-6 group">
            <div class="aspect-[16/10] rounded-3xl sm:rounded-[40px] lg:rounded-[50px] overflow-hidden shadow-2xl relative border-4 border-white">
                <img src="{{ asset('images/facility_library.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Perpustakaan Digital">
                <div class="absolute top-4 right-4 sm:top-6 sm:right-6 transition-transform group-hover:rotate-12">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/90 backdrop-blur rounded-2xl sm:rounded-3xl flex items-center justify-center text-slate-900 text-xl sm:text-2xl shadow-xl">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
            </div>
            <div class="px-2 sm:px-4">
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 uppercase tracking-tighter italic">Perpustakaan Digital</h3>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-4 sm:mb-6 italic">Koleksi ribuan buku fisik dan akses ke jutaan jurnal digital internasional dalam ruang yang tenang dan nyaman.</p>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">AC</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">WIFI 1GBPS</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">COZY SPACE</span>
                </div>
            </div>
        </div>

        <!-- Fasilitas Item 2 -->
        <div class="space-y-6 group md:mt-16 lg:mt-24">
            <div class="aspect-[16/10] rounded-3xl sm:rounded-[40px] lg:rounded-[50px] overflow-hidden shadow-2xl relative border-4 border-white">
                <img src="{{ asset('images/facility_laboratory.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Laboratorium Terpadu">
                <div class="absolute top-4 right-4 sm:top-6 sm:right-6 transition-transform group-hover:rotate-12">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/90 backdrop-blur rounded-2xl sm:rounded-3xl flex items-center justify-center text-slate-900 text-xl sm:text-2xl shadow-xl">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                </div>
            </div>
            <div class="px-2 sm:px-4">
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 uppercase tracking-tighter italic">Laboratorium Terpadu</h3>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-4 sm:mb-6 italic">Fasilitas riset modern untuk Biologi, Fisika, Kimia, dan Komputer dengan peralatan standar industri.</p>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">CVD LAB</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">ROBOTIC TOOLS</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">SMART BOARD</span>
                </div>
            </div>
        </div>

        <!-- Fasilitas Item 3 -->
        <div class="space-y-6 group">
            <div class="aspect-[16/10] rounded-3xl sm:rounded-[40px] lg:rounded-[50px] overflow-hidden shadow-2xl relative border-4 border-white">
                <img src="{{ asset('images/facility_sport.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Sport Center">
                <div class="absolute top-4 right-4 sm:top-6 sm:right-6 transition-transform group-hover:rotate-12">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/90 backdrop-blur rounded-2xl sm:rounded-3xl flex items-center justify-center text-slate-900 text-xl sm:text-2xl shadow-xl">
                        <i class="fa-solid fa-volleyball"></i>
                    </div>
                </div>
            </div>
            <div class="px-2 sm:px-4">
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 uppercase tracking-tighter italic">Sport Center</h3>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-4 sm:mb-6 italic">Gedung olahraga indoor untuk basket, bulutangkis, dan futsal, serta lapangan outdoor yang luas.</p>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">INDOOR ARENA</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">CHANGING ROOM</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">SCORE BOARD</span>
                </div>
            </div>
        </div>

        <!-- Fasilitas Item 4 -->
        <div class="space-y-6 group md:mt-16 lg:mt-24">
            <div class="aspect-[16/10] rounded-3xl sm:rounded-[40px] lg:rounded-[50px] overflow-hidden shadow-2xl relative border-4 border-white">
                <img src="{{ asset('images/facility_hall.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Aula Utama">
                <div class="absolute top-4 right-4 sm:top-6 sm:right-6 transition-transform group-hover:rotate-12">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/90 backdrop-blur rounded-2xl sm:rounded-3xl flex items-center justify-center text-slate-900 text-xl sm:text-2xl shadow-xl">
                        <i class="fa-solid fa-microphone-lines"></i>
                    </div>
                </div>
            </div>
            <div class="px-2 sm:px-4">
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 uppercase tracking-tighter italic">Aula Utama</h3>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-4 sm:mb-6 italic">Ruang serbaguna berkapasitas 1.000 orang dengan sistem tata suara dan cahaya panggung yang mumpuni.</p>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">FULL AC</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">HD PROJECTOR</span>
                    <span class="px-3 sm:px-4 py-1 sm:py-1.5 bg-slate-100 rounded-full text-[10px] sm:text-xs font-black text-slate-600 uppercase">VIP ROOM</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Virtual Tour CTA -->
<section class="py-16 sm:py-24 lg:py-32 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <div class="mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-4 sm:mb-6 italic uppercase tracking-tighter">Lihat Fasilitas <br> Secara Virtual</h2>
            <p class="text-sm sm:text-base text-slate-500 max-w-xl mx-auto">Gunakan fitur virtual tour kami untuk menjelajah seluruh area sekolah tanpa perlu datang ke lokasi.</p>
        </div>
        <a href="/virtual-tour" class="inline-flex items-center gap-3 sm:gap-4 px-8 sm:px-12 py-4 sm:py-5 bg-school-primary text-white rounded-2xl sm:rounded-3xl text-xs sm:text-sm font-black uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-school-primary/20">
            <span>Mulai Virtual Tour</span>
            <i class="fa-solid fa-vr-cardboard text-base sm:text-xl"></i>
        </a>
    </div>
</section>
@endsection

