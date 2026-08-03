@extends('layouts.client')

@section('title', 'Kesiswaan — SMA Task Master')

@section('content')
<!-- Header Kesiswaan -->
<section class="py-24 bg-indigo-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <h1 class="text-4xl md:text-6xl font-black mb-6">Kesiswaan</h1>
        <p class="text-indigo-200 max-w-2xl leading-relaxed">Membangun karakter, mengasah kepemimpinan, dan mewadahi kreativitas siswa melalui berbagai organisasi dan kegiatan ekstrakurikuler.</p>
    </div>
</section>

<!-- Ekstrakurikuler -->
<section class="py-32 max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
        <div class="max-w-xl">
            <span class="text-school-primary font-black uppercase tracking-widest text-xs">Aktivitas & Bakat</span>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mt-4 leading-tight">Wadahi Potensi Tanpa Batas</h2>
        </div>
        <div class="text-sm font-bold text-slate-600">Terdapat 25+ Pilihan Unit Kegiatan</div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="group bg-white rounded-[40px] overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all">
            <div class="h-56 overflow-hidden relative bg-slate-100">
                <img src="{{ asset('images/student_sports.png') }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                <div class="absolute top-4 left-4 px-4 py-1.5 bg-white/90 backdrop-blur rounded-full text-[10px] font-black text-slate-900 uppercase">Olahraga</div>
            </div>
            <div class="p-8">
                <h4 class="text-xl font-bold mb-4">Basketball Club</h4>
                <p class="text-sm text-slate-700 leading-relaxed mb-6 italic">Melatih koordinasi, stamina, dan kerja sama tim dalam kompetisi antar pelajar.</p>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                    <i class="fa-solid fa-calendar-day"></i> Jadwal: Selasa & Kamis
                </div>
            </div>
        </div>
        
        <div class="group bg-white rounded-[40px] overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all">
            <div class="h-56 overflow-hidden relative bg-slate-100">
                <img src="{{ asset('images/activity_robotics.png') }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                <div class="absolute top-4 left-4 px-4 py-1.5 bg-white/90 backdrop-blur rounded-full text-[10px] font-black text-slate-900 uppercase">Teknologi</div>
            </div>
            <div class="p-8">
                <h4 class="text-xl font-bold mb-4">Robotics & AI Space</h4>
                <p class="text-sm text-slate-700 leading-relaxed mb-6 italic">Eksplorasi dunia otomasi dan kecerdasan buatan melalui proyek robotika kreatif.</p>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                    <i class="fa-solid fa-calendar-day"></i> Jadwal: Rabu & Sabtu
                </div>
            </div>
        </div>

        <div class="group bg-white rounded-[40px] overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all">
            <div class="h-56 overflow-hidden relative bg-slate-100">
                <img src="{{ asset('images/activity_dance.png') }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                <div class="absolute top-4 left-4 px-4 py-1.5 bg-white/90 backdrop-blur rounded-full text-[10px] font-black text-slate-900 uppercase">Seni</div>
            </div>
            <div class="p-8">
                <h4 class="text-xl font-bold mb-4">Modern Dance</h4>
                <p class="text-sm text-slate-700 leading-relaxed mb-6 italic">Wadah ekspresi diri melalui gerak tari kontemporer dan pengembangan rasa percaya diri.</p>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                    <i class="fa-solid fa-calendar-day"></i> Jadwal: Senin & Jumat
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OSIS -->
<section class="py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
        <div class="order-2 lg:order-1">
            <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl relative">
                <img src="{{ asset('images/activity_osis.png') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-school-primary/20"></div>
            </div>
        </div>
        <div class="order-1 lg:order-2 space-y-8">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 leading-tight italic uppercase tracking-tighter">OSIS Task Master</h2>
            <p class="text-slate-700 leading-relaxed">
                Organisasi Siswa Intra Sekolah (OSIS) kami bukan sekadar organisasi biasa. Di sini, para pengurus dididik menjadi eksekutif muda yang mampu mengelola event besar, menjalin kemitraan, dan menjadi jembatan aspirasi bagi seluruh siswa.
            </p>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><i class="fa-solid fa-handshake"></i></div>
                    <span class="font-bold text-sm">Hubungan Masyarakat & Kemitraan</span>
                </div>
                <div class="flex items-center gap-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600"><i class="fa-solid fa-calendar-check"></i></div>
                    <span class="font-bold text-sm">Manajemen Event & Kreativitas</span>
                </div>
                <div class="flex items-center gap-4 p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600"><i class="fa-solid fa-user-shield"></i></div>
                    <span class="font-bold text-sm">Kedisiplinan & Karakter</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tata Tertib & Beasiswa -->
<section class="py-32 max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Tatib -->
        <div class="bg-slate-900 rounded-[50px] p-12 text-white">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-2xl mb-8"><i class="fa-solid fa-gavel"></i></div>
            <h3 class="text-2xl font-bold mb-6 italic uppercase tracking-tight">Tata Tertib Siswa</h3>
            <p class="text-slate-300 text-sm leading-relaxed mb-8">
                Kedisiplinan adalah kunci kesuksesan. Kami menerapkan poin kedisiplinan yang transparan dan dapat dipantau oleh orang tua secara real-time.
            </p>
            <a href="#" class="inline-flex items-center gap-2 text-school-primary font-black uppercase text-xs tracking-widest hover:text-white transition-colors">
                Unduh Buku Saku Tatib <i class="fa-solid fa-download"></i>
            </a>
        </div>
        
        <!-- Beasiswa -->
        <div class="bg-school-accent rounded-[50px] p-12 text-slate-900">
            <div class="w-14 h-14 bg-slate-900/10 rounded-2xl flex items-center justify-center text-2xl mb-8"><i class="fa-solid fa-hand-holding-dollar"></i></div>
            <h3 class="text-2xl font-bold mb-6 italic uppercase tracking-tight text-slate-900">Program Beasiswa</h3>
            <p class="text-slate-800 text-sm leading-relaxed mb-8 font-medium">
                Kami berkomitmen untuk mendukung siswa berprestasi dan siswa yang membutuhkan bantuan finansial melalui beasiswa Prestasi & beasiswa Afirmasi.
            </p>
            <a href="/ppdb#beasiswa" class="inline-flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-full font-bold text-xs uppercase tracking-widest hover:scale-105 transition-all">
                Cek Kriteria <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection
