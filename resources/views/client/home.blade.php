@extends('layouts.client')

@section('title', 'SMA Task Master — Unggul & Berkarakter')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center px-6 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-school-primary/5 -z-10 rounded-bl-[100px]"></div>
    <div class="absolute -top-20 -left-20 w-60 h-60 bg-school-accent/10 rounded-full blur-[100px] -z-10"></div>
    
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-school-primary/10 rounded-full border border-school-primary/20">
                <span class="w-2 h-2 bg-school-primary rounded-full animate-pulse"></span>
                <span class="text-xs font-bold text-school-primary uppercase tracking-widest">Pendaftaran PPDB 2024 Dibuka</span>
            </div>
            
            <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1]">
                Wujudkan Masa Depan <span class="text-school-primary">Cemerlang</span> di SMA Task Master
            </h1>
            
            <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                Sekolah dengan kurikulum modern, fasilitas lengkap, dan lingkungan belajar yang mendukung setiap siswa untuk tumbuh menjadi pemimpin masa depan.
            </p>
            
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="/ppdb" class="px-8 py-4 bg-school-primary text-white font-bold rounded-2xl hover:scale-105 transition-all shadow-lg flex items-center gap-2">
                    Daftar Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="/virtual-tour" class="px-8 py-4 bg-white text-slate-900 border border-slate-200 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center gap-2">
                    Virtual Tour 360° <i class="fa-solid fa-vr-cardboard"></i>
                </a>
            </div>
        </div>
        
        <div class="relative">
            <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
                <img src="{{ asset('images/hero_students.png') }}" alt="Students" class="w-full h-full object-cover">
            </div>
            <!-- Floating Stats -->
            <div class="absolute -bottom-10 -left-10 glass p-6 rounded-2xl shadow-xl border border-white/20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white text-xl">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-500">Akreditasi</div>
                        <div class="text-xl font-black text-slate-900 uppercase tracking-tighter">Grade A+</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter -->
<section class="py-20 bg-slate-50 relative z-10 -mt-10 mx-6 rounded-[40px] border border-slate-200/50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center p-8 card-premium rounded-3xl">
                <div class="text-4xl font-black text-school-primary mb-2">1,200+</div>
                <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Siswa Aktif</div>
            </div>
            <div class="text-center p-8 card-premium rounded-3xl">
                <div class="text-4xl font-black text-school-primary mb-2">85+</div>
                <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Guru Profesional</div>
            </div>
            <div class="text-center p-8 card-premium rounded-3xl">
                <div class="text-4xl font-black text-school-primary mb-2">25+</div>
                <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Ekstrakurikuler</div>
            </div>
            <div class="text-center p-8 card-premium rounded-3xl">
                <div class="text-4xl font-black text-school-primary mb-2">15</div>
                <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">Tahun Berdiri</div>
            </div>
        </div>
    </div>
</section>


<!-- Program Unggulan -->
<section class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-20">
            <span class="text-school-primary font-black uppercase tracking-[0.3em] text-[10px] mb-4 block">Our Excellence</span>
            <h2 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 tracking-tighter italic">Program Unggulan</h2>
            <p class="text-slate-500 leading-relaxed italic">Memberikan pengalaman belajar terbaik dengan fasilitas modern dan metode pembelajaran yang inovatif.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-8 card-premium rounded-[40px]">
                <div class="w-16 h-16 bg-blue-100 rounded-3xl flex items-center justify-center text-blue-600 text-3xl mb-8 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/10">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 tracking-tight uppercase">Digital Literacy</h3>
                <p class="text-sm text-slate-500 leading-relaxed italic">Penguasaan teknologi digital dan coding dasar untuk menghadapi era industri 4.0.</p>
            </div>
            
            <div class="p-8 card-premium rounded-[40px]">
                <div class="w-16 h-16 bg-purple-100 rounded-3xl flex items-center justify-center text-purple-600 text-3xl mb-8 group-hover:scale-110 transition-transform shadow-lg shadow-purple-500/10">
                    <i class="fa-solid fa-language"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 tracking-tight uppercase">English Immersion</h3>
                <p class="text-sm text-slate-500 leading-relaxed italic">Lingkungan belajar aktif menggunakan Bahasa Inggris sebagai bahasa pengantar harian.</p>
            </div>
            
            <div class="p-8 card-premium rounded-[40px]">
                <div class="w-16 h-16 bg-amber-100 rounded-3xl flex items-center justify-center text-amber-600 text-3xl mb-8 group-hover:scale-110 transition-transform shadow-lg shadow-amber-500/10">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 tracking-tight uppercase">Creative Arts</h3>
                <p class="text-sm text-slate-500 leading-relaxed italic">Pengembangan bakat seni dan desain melalui studio modern dan mentor profesional.</p>
            </div>
            
            <div class="p-8 card-premium rounded-[40px]">
                <div class="w-16 h-16 bg-emerald-100 rounded-3xl flex items-center justify-center text-emerald-600 text-3xl mb-8 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-500/10">
                    <i class="fa-solid fa-medal"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 tracking-tight uppercase">Leadership Program</h3>
                <p class="text-sm text-slate-500 leading-relaxed italic">Pelatihan kepemimpinan dan manajemen organisasi untuk membangun karakter tangguh.</p>
            </div>
        </div>
    </div>
</section>


<!-- Prestasi -->
<section class="py-32 max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
        <div class="max-w-xl">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">Prestasi Terkini</h2>
            <p class="text-slate-500 leading-relaxed">Kebanggaan kami adalah melihat siswa-siswi SMA Task Master bersinar di ranah nasional maupun internasional.</p>
        </div>
        <a href="/prestasi" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
            Lihat Lebih Banyak <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="relative h-80 rounded-3xl overflow-hidden group shadow-lg">
            <img src="{{ asset('images/student_medal.png') }}" alt="Medal" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white">
                <span class="px-2 py-1 bg-school-accent text-slate-900 text-[10px] font-black rounded mb-2 inline-block">INTERNATIONAL</span>
                <h3 class="font-bold text-lg leading-tight uppercase">Juara 1 Olimpiade Fisika Dunia 2024</h3>
            </div>
        </div>
        
        <div class="relative h-80 rounded-3xl overflow-hidden group shadow-lg">
            <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=800" alt="Group" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white">
                <span class="px-2 py-1 bg-school-primary text-white text-[10px] font-black rounded mb-2 inline-block">NATIONAL</span>
                <h3 class="font-bold text-lg leading-tight uppercase">Finalis Debat Bahasa Inggris Nasional</h3>
            </div>
        </div>
        
        <div class="relative h-80 rounded-3xl overflow-hidden group shadow-lg">
            <img src="{{ asset('images/student_sports.png') }}" alt="Art" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white">
                <span class="px-2 py-1 bg-indigo-500 text-white text-[10px] font-black rounded mb-2 inline-block">PROVINCE</span>
                <h3 class="font-bold text-lg leading-tight uppercase">Medali Emas Kejuaraan Basket Pelajar</h3>
            </div>
        </div>
    </div>
</section>

<!-- Berita & Pengumuman -->
<section class="py-32 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl md:text-5xl font-black mb-6">Berita <span class="text-school-primary">&</span> Pengumuman</h2>
            <p class="text-slate-400">Ikuti perkembangan terbaru dan info penting seputar kegiatan sekolah kami.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:bg-white/[0.08] transition-all">
                <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                    <img src="{{ asset('images/hero_students.png') }}" class="w-full h-full object-cover" alt="Event">
                </div>
                <div class="text-xs text-school-primary font-bold mb-3">12 JUNI 2024</div>
                <h3 class="text-xl font-bold mb-4">Ujian Akhir Semester Genap Dimulai Pekan Depan</h3>
                <p class="text-sm text-slate-400 leading-relaxed mb-6">Diharapkan seluruh siswa mempersiapkan diri dengan baik dan menjaga kesehatan.</p>
                <a href="/berita/1" class="text-sm font-bold flex items-center gap-2 hover:text-school-primary">Baca Selengkapnya <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:bg-white/[0.08] transition-all">
                <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                    <img src="{{ asset('images/student_sports.png') }}" class="w-full h-full object-cover" alt="Event">
                </div>
                <div class="text-xs text-school-primary font-bold mb-3">08 JUNI 2024</div>
                <h3 class="text-xl font-bold mb-4">Kegiatan Class Meeting Antar Kelas Berlangsung Meriah</h3>
                <p class="text-sm text-slate-400 leading-relaxed mb-6">Pertandingan futsal dan basket menjadi puncak acara yang paling ditunggu-tunggu.</p>
                <a href="/berita/2" class="text-sm font-bold flex items-center gap-2 hover:text-school-primary">Baca Selengkapnya <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
            </div>
            
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:bg-white/[0.08] transition-all">
                <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                    <img src="{{ asset('images/facility_hall.png') }}" class="w-full h-full object-cover" alt="Event">
                </div>
                <div class="text-xs text-school-primary font-bold mb-3">05 JUNI 2024</div>
                <h3 class="text-xl font-bold mb-4">Webinar Karier: Memilih Universitas yang Tepat</h3>
                <p class="text-sm text-slate-400 leading-relaxed mb-6">Menghadirkan narasumber dari berbagai universitas negeri ternama di Indonesia.</p>
                <a href="/berita/3" class="text-sm font-bold flex items-center gap-2 hover:text-school-primary">Baca Selengkapnya <i class="fa-solid fa-chevron-right text-[10px]"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Floating Banner CTA -->
<div class="fixed bottom-8 right-8 z-40 hidden lg:block animate-bounce hover:pause">
    <a href="/ppdb" class="bg-school-accent p-4 rounded-full shadow-2xl flex items-center gap-3 border-4 border-white">
        <div class="w-10 h-10 bg-slate-900 rounded-full flex items-center justify-center text-white">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
        <div class="pr-4">
            <div class="text-[10px] font-black text-slate-900 uppercase">Daftar Sekarang</div>
            <div class="text-sm font-bold text-slate-900">PPDB 2024/2025</div>
        </div>
    </a>
</div>
@endsection
