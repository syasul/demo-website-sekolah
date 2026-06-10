@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')
@section('page_title', 'Ringkasan Aktivitas')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="p-8 card-premium rounded-3xl relative group overflow-hidden">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-xl font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-users"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
        </div>
        <div class="text-3xl font-black text-slate-900 mb-1">{{ number_format($stats['total_students']) }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Siswa</div>
    </div>

    <div class="p-8 card-premium rounded-3xl relative group overflow-hidden">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 text-xl font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">Tetap</span>
        </div>
        <div class="text-3xl font-black text-slate-900 mb-1">{{ $stats['total_teachers'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tenaga Pendidik</div>
    </div>

    <div class="p-8 card-premium rounded-3xl relative group overflow-hidden">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 text-xl font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-2 py-1 rounded-lg">High</span>
        </div>
        <div class="text-3xl font-black text-slate-900 mb-1">{{ $stats['pending_ppdb'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendaftar Pending</div>
    </div>

    <div class="p-8 card-premium rounded-3xl relative group overflow-hidden">
        <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">Aktif</span>
        </div>
        <div class="text-3xl font-black text-slate-900 mb-1">{{ $stats['total_news'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Berita Tayang</div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Activity Log -->
    <div class="lg:col-span-2 p-8 bg-white rounded-[40px] shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-bold text-slate-900 italic uppercase">Aktivitas Terakhir</h3>
            <button class="text-[10px] font-black uppercase text-slate-400 hover:text-school-primary transition-colors">Lihat Semua Log</button>
        </div>
        
        <div class="space-y-6">
            <div class="flex items-center gap-6 p-4 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                <div class="w-10 h-10 bg-slate-900 text-white rounded-full flex items-center justify-center text-xs font-black italic shadow-lg">AM</div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-900">Admin Melakukan Update Berita <span class="text-slate-400 font-medium">"Wisuda Angkatan XV..."</span></p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">2 jam yang lalu</p>
                </div>
                <div class="w-2 h-2 bg-school-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            
            <div class="flex items-center gap-6 p-4 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-xs font-black italic shadow-sm">JW</div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-900">Pendaftar Baru PPDB: <span class="text-slate-400 font-medium">Joko Widada (SMA N 1 Malang)</span></p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">4 jam yang lalu</p>
                </div>
                <div class="w-2 h-2 bg-school-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>

            <div class="flex items-center gap-6 p-4 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-xs font-black italic shadow-sm">KS</div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-900">Kepala Sekolah Mengakses Laporan Akademik</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Kemarin</p>
                </div>
                <div class="w-2 h-2 bg-school-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-8">
        <div class="p-8 bg-slate-900 rounded-[40px] text-white shadow-xl relative overflow-hidden group">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-school-primary/20 rounded-full blur-3xl transition-transform group-hover:scale-150"></div>
            <h3 class="font-bold mb-6 italic uppercase tracking-widest text-xs text-slate-500">Aksi Cepat</h3>
            <div class="space-y-4 relative z-10">
                <a href="#" class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl hover:bg-white/10 border border-white/5 transition-all group">
                    <div class="w-10 h-10 bg-school-primary rounded-xl flex items-center justify-center text-white"><i class="fa-solid fa-plus"></i></div>
                    <span class="text-xs font-bold">Buat Berita Baru</span>
                </a>
                <a href="#" class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl hover:bg-white/10 border border-white/5 transition-all group">
                    <div class="w-10 h-10 bg-school-accent text-slate-900 rounded-xl flex items-center justify-center font-black italic"><i class="fa-solid fa-upload"></i></div>
                    <span class="text-xs font-bold">Upload Galeri</span>
                </a>
            </div>
        </div>
        
        <div class="p-8 bg-white rounded-[40px] shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-900 italic uppercase mb-6 text-xs text-slate-400">Pesan Masuk</h3>
            <div class="text-center py-12">
                <div class="text-4xl text-slate-100 mb-4 transition-transform hover:scale-110 inline-block"><i class="fa-solid fa-envelope-open-text"></i></div>
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest leading-relaxed">Belum ada pesan <br> baru hari ini</p>
            </div>
        </div>
    </div>
</div>
@endsection
