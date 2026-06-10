@extends('layouts.client')

@section('title', 'Profil Sekolah — SMA Task Master')

@section('content')
<!-- Header Profil -->
<section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-school-primary/10 -z-0"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <h1 class="text-4xl md:text-6xl font-black mb-6">Profil Sekolah</h1>
        <p class="text-slate-400 max-w-2xl leading-relaxed">Mengenal lebih dekat visi, misi, dan perjalanan SMA Task Master dalam mencetak generasi pemimpin dunia.</p>
    </div>
</section>

<!-- Sub Navigation -->
<div class="sticky top-24 z-30 glass border-y border-white/10 py-4 hidden md:block">
    <div class="max-w-7xl mx-auto px-6 flex gap-8">
        <a href="#sejarah" class="text-sm font-bold text-slate-500 hover:text-school-primary transition-colors">Sejarah</a>
        <a href="#visi-misi" class="text-sm font-bold text-slate-500 hover:text-school-primary transition-colors">Visi & Misi</a>
        <a href="#struktur" class="text-sm font-bold text-slate-500 hover:text-school-primary transition-colors">Struktur Organisasi</a>
        <a href="#guru" class="text-sm font-bold text-slate-500 hover:text-school-primary transition-colors">Data Guru</a>
        <a href="#akreditasi" class="text-sm font-bold text-slate-500 hover:text-school-primary transition-colors">Akreditasi</a>
    </div>
</div>

<!-- Sejarah -->
<section id="sejarah" class="py-32 max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
        <div class="space-y-8">
            <div class="w-12 h-1 bg-school-primary"></div>
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">Perjalanan Sejak Tahun 2009</h2>
            <div class="space-y-6 text-slate-600 leading-relaxed text-base">
                <p>
                    SMA Task Master didirikan pada tahun 2009 dengan semangat untuk menyediakan pendidikan berkualitas yang tidak hanya fokus pada akademik, tetapi juga pembinaan karakter. Berawal dari lahan seluas 1 hektar, kini kami telah berkembang menjadi salah satu sekolah rujukan di kota ini.
                </p>
                <p>
                    Dalam satu dekade terakhir, kami telah mencetak lebih dari 5.000 alumni yang kini tersebar di berbagai universitas ternama dan perusahaan global. Komitmen kami tetap sama: mendidik dengan hati, menginspirasi dengan prestasi.
                </p>
            </div>
        </div>
        <div class="relative">
            <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756ebafe3?q=80&w=1000" alt="School History" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-6 -right-6 p-8 bg-school-accent rounded-3xl shadow-xl">
                <div class="text-4xl font-black text-slate-900">15+</div>
                <div class="text-xs font-bold text-slate-800 uppercase">Tahun Dedikasi</div>
            </div>
        </div>
    </div>
</section>

<!-- Visi & Misi -->
<section id="visi-misi" class="py-32 bg-slate-900 text-white rounded-[60px] mx-6">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-20">
        <div>
            <h2 class="text-3xl font-black mb-8 flex items-center gap-4">
                <span class="w-10 h-10 bg-school-primary rounded-xl flex items-center justify-center text-lg"><i class="fa-solid fa-eye"></i></span>
                Visi Sekolah
            </h2>
            <p class="text-2xl md:text-3xl font-bold leading-tight">
                "Menjadi pusat pendidikan unggul yang melahirkan pemimpin berwawasan global, berkarakter mulia, dan kompetitif secara internasional."
            </p>
        </div>
        <div>
            <h2 class="text-3xl font-black mb-8 flex items-center gap-4">
                <span class="w-10 h-10 bg-school-accent rounded-xl flex items-center justify-center text-lg text-slate-900"><i class="fa-solid fa-bullseye"></i></span>
                Misi Sekolah
            </h2>
            <ul class="space-y-6">
                <li class="flex gap-4">
                    <div class="text-school-primary text-xl"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-slate-400">Menyelenggarakan pembelajaran berbasis teknologi yang inovatif dan adaptif.</p>
                </li>
                <li class="flex gap-4">
                    <div class="text-school-primary text-xl"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-slate-400">Membina karakter siswa melalui program religius dan etika kepemimpinan.</p>
                </li>
                <li class="flex gap-4">
                    <div class="text-school-primary text-xl"><i class="fa-solid fa-circle-check"></i></div>
                    <p class="text-slate-400">Mengembangkan bakat siswa dalam bidang non-akademik secara maksimal.</p>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Struktur Organisasi -->
<section id="struktur" class="py-32 max-w-7xl mx-auto px-6 text-center">
    <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-16">Struktur Organisasi</h2>
    <div class="relative inline-block">
        <!-- Mock Hierarchy -->
        <div class="flex flex-col items-center gap-12">
            <!-- Senior -->
            <div class="p-6 bg-white rounded-3xl shadow-lg border border-slate-100 max-w-xs transition-transform hover:-translate-y-2">
                <div class="w-24 h-24 rounded-full overflow-hidden mx-auto mb-4 border-4 border-school-primary/20">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-slate-900">Dr. Budi Santoso, M.Pd</h4>
                <p class="text-xs text-school-primary font-bold uppercase tracking-widest mt-1">Kepala Sekolah</p>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 w-full max-w-5xl">
                <div class="p-4 bg-white rounded-2xl shadow-md border border-slate-50">
                    <h5 class="font-bold text-sm">Siti Aminah, S.Pd</h5>
                    <p class="text-[10px] text-slate-500 uppercase font-black">Waka Kurikulum</p>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-md border border-slate-50">
                    <h5 class="font-bold text-sm">Andi Wijaya, M.Si</h5>
                    <p class="text-[10px] text-slate-500 uppercase font-black">Waka Kesiswaan</p>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-md border border-slate-50">
                    <h5 class="font-bold text-sm">Dewi Sartika, M.Pd</h5>
                    <p class="text-[10px] text-slate-500 uppercase font-black">Waka Sarana</p>
                </div>
                <div class="p-4 bg-white rounded-2xl shadow-md border border-slate-50">
                    <h5 class="font-bold text-sm">Hendra Pratama, S.T</h5>
                    <p class="text-[10px] text-slate-500 uppercase font-black">Waka Humas</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Data Guru -->
<section id="guru" class="py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900">Tenaga Pendidik</h2>
            <div class="text-sm font-bold text-slate-500">Total 85+ Guru Profesional</div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-32 h-32 rounded-3xl overflow-hidden mx-auto mb-6 transition-transform group-hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-slate-900 group-hover:text-white">Laila Rahayu, M.Pd</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80">Guru Matematika</p>
            </div>
            
            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-32 h-32 rounded-3xl overflow-hidden mx-auto mb-6 transition-transform group-hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1544717297-fa15739a5447?q=80&w=400" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-slate-900 group-hover:text-white">Ahmad Fauzi, S.Si</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80">Guru Fisika</p>
            </div>

            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-32 h-32 rounded-3xl overflow-hidden mx-auto mb-6 transition-transform group-hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-slate-900 group-hover:text-white">Rizky Ramadhan, M.A</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80">Guru Bahasa Inggris</p>
            </div>

            <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all hover:bg-school-primary text-center">
                <div class="w-32 h-32 rounded-3xl overflow-hidden mx-auto mb-6 transition-transform group-hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-slate-900 group-hover:text-white">Diana Lestari, S.Pd</h4>
                <p class="text-xs text-slate-500 font-medium group-hover:text-white/80">Guru Biologi</p>
            </div>
        </div>
    </div>
</section>

<!-- Akreditasi -->
<section id="akreditasi" class="py-32 bg-school-primary text-white overflow-hidden relative">
    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-6 text-center">
        <div class="inline-block p-4 bg-white/10 rounded-3xl border border-white/20 mb-8">
            <i class="fa-solid fa-certificate text-5xl text-school-accent"></i>
        </div>
        <h2 class="text-4xl md:text-6xl font-black mb-8 uppercase tracking-tighter italic">Terakreditasi A+ (Unggul)</h2>
        <p class="text-white/70 max-w-xl mx-auto leading-relaxed">
            Berdasarkan Keputusan Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M) Tahun 2023, SMA Task Master memperoleh nilai 98 dengan predikat Terakreditasi Unggul.
        </p>
    </div>
</section>
@endsection
