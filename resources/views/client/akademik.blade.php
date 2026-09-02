@extends('layouts.client')

@section('title', 'Akademik — MA At-Taraqqie')

@section('content')
<!-- Header Akademik -->
<section class="py-14 sm:py-20 lg:py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-school-primary/10 rounded-full border border-school-primary/20 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-primary">
            Kurikulum & Pembelajaran
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 mb-4 sm:mb-6">Akademik</h1>
        <p class="text-sm sm:text-base text-slate-500 max-w-2xl leading-relaxed">Standar keunggulan akademik yang mengintegrasikan kurikulum nasional dengan metode pembelajaran modern berskala global.</p>
    </div>
</section>

<!-- Kurikulum -->
<section class="py-16 sm:py-24 lg:py-32 max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 sm:gap-14 lg:gap-20 items-center">
        <div>
            <span class="text-school-primary font-black uppercase tracking-widest text-xs">Standard Kurikulum</span>
            <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 mt-4 sm:mt-6 mb-6 sm:mb-8">Kurikulum Merdeka Plus</h2>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 sm:mb-8">
                Kami menerapkan Kurikulum Merdeka yang diperkaya dengan muatan lokal unggulan seperti Digital Literacy, Global communication (English Only Days), dan Project Based Learning (PjBL) yang relevan dengan kebutuhan industri masa depan.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="p-5 sm:p-6 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-start gap-4">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                        <i class="fa-solid fa-flask"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-900">Fokus STEM</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Sains, Teknologi, Engineering, & Matematika.</p>
                    </div>
                </div>
                <div class="p-5 sm:p-6 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-start gap-4">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-900">Soft Skills</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Berpikir kritis, kolaborasi, dan kemandirian.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-slate-900 rounded-3xl sm:rounded-[40px] p-6 sm:p-10 lg:p-12 text-white relative shadow-xl">
            <h3 class="text-xl sm:text-2xl font-bold mb-6 sm:mb-8">Struktur Kurikulum</h3>
            <div class="space-y-5 sm:space-y-6">
                <div class="pb-5 sm:pb-6 border-b border-white/10 uppercase">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs sm:text-sm font-bold">Intrakurikuler</span>
                        <span class="text-school-accent font-black text-sm sm:text-base">70%</span>
                    </div>
                    <p class="text-[11px] sm:text-xs text-white/50 lowercase italic">Pembelajaran rutin mata pelajaran wajib pemerintah.</p>
                </div>
                <div class="pb-5 sm:pb-6 border-b border-white/10 uppercase">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs sm:text-sm font-bold">Proyek P5</span>
                        <span class="text-school-accent font-black text-sm sm:text-base">20%</span>
                    </div>
                    <p class="text-[11px] sm:text-xs text-white/50 lowercase italic">Projek Penguatan Profil Pelajar Pancasila.</p>
                </div>
                <div class="uppercase">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs sm:text-sm font-bold">Muatan Lokal</span>
                        <span class="text-school-accent font-black text-sm sm:text-base">10%</span>
                    </div>
                    <p class="text-[11px] sm:text-xs text-white/50 lowercase italic">Bahasa Asing, Coding, dan Kewirausahaan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jadwal & Kalender -->
<section class="py-16 sm:py-24 lg:py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mb-10 sm:mb-16 text-center">Informasi Belajar</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
            <!-- Jadwal -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6 sm:mb-8">
                    <div class="w-12 h-12 bg-school-primary/10 rounded-xl flex items-center justify-center text-school-primary shrink-0">
                        <i class="fa-solid fa-clock text-lg"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900">Waktu Operasional KBM</h3>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl">
                        <span class="font-bold text-xs sm:text-sm text-slate-700">Senin - Kamis</span>
                        <span class="font-black text-xs sm:text-sm text-slate-900 uppercase tracking-tight">07:00 - 15:30</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl">
                        <span class="font-bold text-xs sm:text-sm text-slate-700">Jumat</span>
                        <span class="font-black text-xs sm:text-sm text-slate-900 uppercase tracking-tight">07:00 - 11:30</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-slate-100 rounded-xl">
                        <span class="font-bold text-xs sm:text-sm text-slate-500 italic">Sabtu & Minggu</span>
                        <span class="font-black text-xs sm:text-sm text-slate-500">Libur / Eskul</span>
                    </div>
                </div>
            </div>
            
            <!-- Kalender -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 relative group overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-4 mb-6 sm:mb-8">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                            <i class="fa-solid fa-calendar-days text-lg"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900">Kalender Akademik</h3>
                    </div>
                    <p class="text-slate-500 mb-6 sm:mb-8 text-xs sm:text-sm leading-relaxed">Unduh kalender akademik terbaru tahun ajaran 2024/2025 untuk melihat jadwal libur, ujian, dan kegiatan sekolah.</p>
                </div>
                <a href="#" class="inline-flex items-center justify-center gap-3 px-6 sm:px-8 py-3.5 sm:py-4 bg-slate-900 text-white rounded-2xl font-bold text-xs sm:text-sm hover:bg-slate-800 transition-all shadow-md self-start">
                    <span>Unduh Kalender .PDF</span>
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Metode Belajar -->
<section class="py-16 sm:py-24 lg:py-32 max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
        <h2 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-4 sm:mb-6">Metode Belajar</h2>
        <p class="text-sm sm:text-base text-slate-500">Meninggalkan cara lama, kami merancang pengalaman belajar yang interaktif dan berpusat pada siswa.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        <div class="p-6 sm:p-8 rounded-3xl bg-sky-50 border border-sky-100">
            <div class="text-2xl sm:text-3xl text-sky-600 mb-4 sm:mb-6"><i class="fa-solid fa-laptop-code"></i></div>
            <h4 class="text-lg sm:text-xl font-bold text-slate-900 mb-3 tracking-tight uppercase">Hybrid Learning</h4>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">Kombinasi belajar tatap muka dengan platform digital interaktif yang bisa diakses kapan saja.</p>
        </div>
        <div class="p-6 sm:p-8 rounded-3xl bg-purple-50 border border-purple-100">
            <div class="text-2xl sm:text-3xl text-purple-600 mb-4 sm:mb-6"><i class="fa-solid fa-users-gear"></i></div>
            <h4 class="text-lg sm:text-xl font-bold text-slate-900 mb-3 tracking-tight uppercase">Collaborative Space</h4>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">Siswa didorong untuk bekerja dalam tim guna menyelesaikan studi kasus nyata dari dunia profesional.</p>
        </div>
        <div class="p-6 sm:p-8 rounded-3xl bg-amber-50 border border-amber-100">
            <div class="text-2xl sm:text-3xl text-amber-600 mb-4 sm:mb-6"><i class="fa-solid fa-route"></i></div>
            <h4 class="text-lg sm:text-xl font-bold text-slate-900 mb-3 tracking-tight uppercase">Field Research</h4>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">Belajar tidak hanya di dalam kelas, namun terjun langsung ke lapangan untuk observasi dan riset.</p>
        </div>
    </div>
</section>
@endsection

