@extends('guru.layouts.app')

@section('title', 'Dashboard Guru')
@section('page_title', 'Dashboard Utama')

@section('content')
<div class="space-y-8">
    <!-- Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-school-primary rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10 border border-white/10">
        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Semester {{ ucfirst($currentSemester) }} TA {{ $currentTahun }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Selamat Datang, {{ $guru->name }}!</h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-xl">
                    Portal terpadu penilaian raport dan manajemen kelas Anda. Pantau progress pengisian nilai siswa secara langsung.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.raport.index') }}" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-bold text-xs shadow-lg shadow-emerald-500/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Input Nilai Raport</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Kelas Diampu -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-chalkboard"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelas Diampu</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalKelas }} <span class="text-xs font-medium text-slate-400">Rombel</span></h3>
            </div>
        </div>

        <!-- Mapel Diajar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mata Pelajaran</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalMapel }} <span class="text-xs font-medium text-slate-400">Mapel</span></h3>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa Diajar</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalSiswaDiajar }} <span class="text-xs font-medium text-slate-400">Siswa</span></h3>
            </div>
        </div>

        <!-- Status Wali Kelas -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-id-badge"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Wali Kelas</p>
                <h3 class="text-lg font-black text-slate-800 truncate">
                    {{ $kelasWali ? 'Kelas ' . $kelasWali->nama_lengkap : 'Bukan Wali' }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Progress Penilaian Raport -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Progress Pengisian Nilai Raport</h2>
                <p class="text-xs text-slate-400">Status input nilai untuk rombel & mapel yang ditugaskan kepada Anda.</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Semester {{ ucfirst($currentSemester) }} {{ $currentTahun }}
            </span>
        </div>

        <div class="space-y-4">
            @forelse($assignments as $item)
            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition-all">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-school-primary/10 text-school-primary font-black flex items-center justify-center text-sm">
                            {{ $item['kelas']->tingkat }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-slate-900 text-sm">Kelas {{ $item['kelas']->nama_lengkap }}</h4>
                                <span class="text-slate-300">•</span>
                                <span class="font-semibold text-xs text-slate-600">{{ $item['mapel']->nama_mapel }}</span>
                            </div>
                            <p class="text-[11px] text-slate-400">
                                {{ $item['graded_count'] }} dari {{ $item['total_students'] }} siswa sudah dinilai ({{ $item['percentage'] }}%)
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                        @if($item['is_locked'])
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold">
                                <i class="fa-solid fa-lock text-[10px]"></i>
                                <span>Terkunci</span>
                            </span>
                        @endif

                        <a href="{{ route('guru.raport.create', ['kelas_id' => $item['kelas']->id, 'mapel_id' => $item['mapel']->id, 'semester' => $currentSemester, 'tahun_ajaran' => $currentTahun]) }}" 
                           class="px-4 py-2 bg-school-primary text-white rounded-xl font-bold text-xs hover:bg-school-primary/90 transition shadow-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                            <span>{{ $item['is_locked'] ? 'Lihat Nilai' : 'Input Nilai' }}</span>
                        </a>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full transition-all duration-500 {{ $item['percentage'] == 100 ? 'bg-emerald-500' : 'bg-school-primary' }}" 
                         style="width: {{ $item['percentage'] }}%"></div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-book-open text-xl"></i>
                </div>
                <p class="text-sm font-bold text-slate-600">Belum Ada Penugasan Mengajar</p>
                <p class="text-xs text-slate-400 mt-1">Silakan hubungi Administrator untuk menetapkan rombel dan mata pelajaran yang Anda ampu.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
