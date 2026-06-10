@extends('layouts.client')

@section('title', 'Fasilitas — SMA Task Master')

@section('content')
<!-- Header Fasilitas -->
<section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-school-primary/10 -z-0"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <h1 class="text-4xl md:text-6xl font-black mb-6">Fasilitas Sekolah</h1>
        <p class="text-slate-400 max-w-2xl leading-relaxed">Lingkungan belajar kondusif dengan dukungan sarana dan prasarana modern untuk menunjang aktivitas akademik maupun non-akademik.</p>
    </div>
</section>

<!-- Fasilitas Grid -->
<section class="py-32 max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
        <!-- Fasilitas Item -->
        <div class="space-y-8 group">
            <div class="aspect-[16/10] rounded-[50px] overflow-hidden shadow-2xl relative">
                <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=1000" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute top-8 right-8 transition-transform group-hover:rotate-12">
                    <div class="w-16 h-16 bg-white/90 backdrop-blur rounded-3xl flex items-center justify-center text-slate-900 text-2xl shadow-xl">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h3 class="text-3xl font-black text-slate-900 mb-4 uppercase tracking-tighter italic">Perpustakaan Digital</h3>
                <p class="text-slate-600 leading-relaxed mb-6 italic">Koleksi ribuan buku fisik dan akses ke jutaan jurnal digital internasional dalam ruang yang tenang dan nyaman.</p>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">AC</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">WIFI 1GBPS</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">COZY SPACE</span>
                </div>
            </div>
        </div>

        <div class="space-y-8 group md:mt-24">
            <div class="aspect-[16/10] rounded-[50px] overflow-hidden shadow-2xl relative">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=1000" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute top-8 right-8 transition-transform group-hover:rotate-12">
                    <div class="w-16 h-16 bg-white/90 backdrop-blur rounded-3xl flex items-center justify-center text-slate-900 text-2xl shadow-xl">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h3 class="text-3xl font-black text-slate-900 mb-4 uppercase tracking-tighter italic">Laboratorium Terpadu</h3>
                <p class="text-slate-600 leading-relaxed mb-6 italic">Fasilitas riset modern untuk Biologi, Fisika, Kimia, dan Komputer dengan peralatan standar industri.</p>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">CVD LAB</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">ROBOTIC TOOLS</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">SMART BOARD</span>
                </div>
            </div>
        </div>

        <div class="space-y-8 group">
            <div class="aspect-[16/10] rounded-[50px] overflow-hidden shadow-2xl relative">
                <img src="https://images.unsplash.com/photo-1541534444538-232578508eb5?q=80&w=1000" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute top-8 right-8 transition-transform group-hover:rotate-12">
                    <div class="w-16 h-16 bg-white/90 backdrop-blur rounded-3xl flex items-center justify-center text-slate-900 text-2xl shadow-xl">
                        <i class="fa-solid fa-volleyball"></i>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h3 class="text-3xl font-black text-slate-900 mb-4 uppercase tracking-tighter italic">Sport Center</h3>
                <p class="text-slate-600 leading-relaxed mb-6 italic">Gedung olahraga indoor untuk basket, bulutangkis, dan futsal, serta lapangan outdoor yang luas.</p>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">INDOOR ARENA</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">CHANGING ROOM</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">SCORE BOARD</span>
                </div>
            </div>
        </div>

        <div class="space-y-8 group md:mt-24">
            <div class="aspect-[16/10] rounded-[50px] overflow-hidden shadow-2xl relative">
                <img src="https://images.unsplash.com/photo-1560439514-4e9645039924?q=80&w=1000" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute top-8 right-8 transition-transform group-hover:rotate-12">
                    <div class="w-16 h-16 bg-white/90 backdrop-blur rounded-3xl flex items-center justify-center text-slate-900 text-2xl shadow-xl">
                        <i class="fa-solid fa-microphone-lines"></i>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h3 class="text-3xl font-black text-slate-900 mb-4 uppercase tracking-tighter italic">Aula Utama</h3>
                <p class="text-slate-600 leading-relaxed mb-6 italic">Ruang serbaguna berkapasitas 1.000 orang dengan sistem tata suara dan cahaya panggung yang mumpuni.</p>
                <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">FULL AC</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">HD PROJECTOR</span>
                    <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-500 uppercase">VIP ROOM</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Virtual Tour CTA -->
<section class="py-32 bg-slate-50">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="mb-12">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6 italic uppercase tracking-tighter">Lihat Fasilitas <br> Secara Virtual</h2>
            <p class="text-slate-500">Gunakan fitur virtual tour kami untuk menjelah seluruh area sekolah tanpa perlu datang ke lokasi.</p>
        </div>
        <a href="/virtual-tour" class="inline-flex items-center gap-4 px-12 py-5 bg-school-primary text-white rounded-3xl font-black uppercase tracking-widest hover:scale-105 transition-all shadow-xl">
            Mulai Virtual Tour <i class="fa-solid fa-vr-cardboard text-xl"></i>
        </a>
    </div>
</section>
@endsection
