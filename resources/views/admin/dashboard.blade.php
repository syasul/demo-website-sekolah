@extends('layouts.admin')

@section('title', 'Dashboard Utama')
@section('page_title', 'Ringkasan Sistem Terpadu')

@section('content')
<!-- Active Context Information Card -->
<div class="mb-6 p-4 sm:p-5 bg-slate-900 rounded-2xl text-white shadow-xs border border-slate-800 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700/80 text-emerald-400 flex items-center justify-center text-base shrink-0">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-medium text-slate-400">Konteks Aktif:</span>
                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $contextBadge['bg_class'] ?? 'bg-emerald-50 text-emerald-700' }}">
                    {{ $contextBadge['label'] ?? 'Semua Unit' }}
                </span>
            </div>
            <h2 class="text-sm sm:text-base font-bold text-white mt-0.5">MA Attaraqqie — Pusat Kendali Madrasah</h2>
        </div>
    </div>

    <div class="flex items-center gap-2 self-stretch md:self-auto">
        <a href="{{ route('admin.absensi.siswa') }}" class="flex-1 md:flex-none px-3.5 py-2 bg-slate-800 hover:bg-slate-700/90 rounded-xl text-xs font-semibold text-slate-200 transition-colors flex items-center justify-center gap-2 border border-slate-700/60">
            <i class="fa-solid fa-clipboard-user text-xs text-slate-400"></i>
            <span>Presensi Hari Ini</span>
        </a>
        <a href="{{ route('admin.rdm.index') }}" class="flex-1 md:flex-none px-3.5 py-2 bg-slate-800 hover:bg-slate-700/90 rounded-xl text-xs font-semibold text-slate-200 transition-colors flex items-center justify-center gap-2 border border-slate-700/60">
            <i class="fa-solid fa-cloud-arrow-up text-xs text-emerald-400"></i>
            <span>Simulasi RDM</span>
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="p-5 sm:p-6 bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs relative overflow-hidden group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-lg font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg uppercase">Aktif</span>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-0.5">{{ number_format($stats['total_students']) }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Santri / Siswa</div>
    </div>

    <div class="p-5 sm:p-6 bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs relative overflow-hidden group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-11 h-11 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 text-lg font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded-lg uppercase">Pengajar</span>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-0.5">{{ $stats['total_teachers'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dewan Asatidz / Guru</div>
    </div>

    <div class="p-5 sm:p-6 bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs relative overflow-hidden group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-11 h-11 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 text-lg font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-2 py-0.5 rounded-lg uppercase">Pending</span>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-0.5">{{ $stats['pending_ppdb'] }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendaftar PPDB Masuk</div>
    </div>

    <div class="p-5 sm:p-6 bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs relative overflow-hidden group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-11 h-11 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-lg font-black transition-transform group-hover:scale-110">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-lg uppercase">SPP</span>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-slate-900 mb-0.5">{{ $stats['spp_lunas'] }} <span class="text-xs text-slate-400 font-bold">Lunas</span></div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Terkumpul: Rp {{ number_format($stats['spp_collected'], 0, ',', '.') }}</div>
    </div>
</div>

<!-- CROSS-UNIT SEGMENTATION COMPARISON (PUTRA vs PUTRI) -->
<div class="mb-8 p-6 sm:p-8 bg-white rounded-3xl border border-slate-100 shadow-xs">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-6">
        <div>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Analisis Segmentasi Gender</span>
            <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-tight">Perbandingan Unit Kampus Putra vs Kampus Putri</h3>
        </div>
        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-xl">MA Attaraqqie</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Metric 1: Populasi Santri -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="flex justify-between items-center text-xs font-bold mb-3">
                <span class="text-slate-600 uppercase tracking-wider text-[11px]">Distribusi Santri</span>
                <span class="text-slate-900 font-black">{{ $stats['siswa_putra'] + $stats['siswa_putri'] }} Santri</span>
            </div>
            
            <div class="h-3 w-full bg-slate-200 rounded-full overflow-hidden flex mb-3">
                @php
                    $totalSantriUnit = max(1, $stats['siswa_putra'] + $stats['siswa_putri']);
                    $pctPutra = round(($stats['siswa_putra'] / $totalSantriUnit) * 100);
                    $pctPutri = 100 - $pctPutra;
                @endphp
                <div style="width: {{ $pctPutra }}%" class="bg-blue-500 h-full" title="Putra: {{ $pctPutra }}%"></div>
                <div style="width: {{ $pctPutri }}%" class="bg-purple-500 h-full" title="Putri: {{ $pctPutri }}%"></div>
            </div>

            <div class="flex justify-between text-xs font-bold">
                <span class="text-blue-600 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span>Putra: {{ $stats['siswa_putra'] }} ({{ $pctPutra }}%)</span>
                </span>
                <span class="text-purple-600 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <span>Putri: {{ $stats['siswa_putri'] }} ({{ $pctPutri }}%)</span>
                </span>
            </div>
        </div>

        <!-- Metric 2: Presensi Kehadiran Hari Ini -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="flex justify-between items-center text-xs font-bold mb-3">
                <span class="text-slate-600 uppercase tracking-wider text-[11px]">Kehadiran Hari Ini</span>
                <span class="text-emerald-600 font-black">{{ $stats['absen_putra_today'] + $stats['absen_putri_today'] }} Hadir</span>
            </div>
            
            <div class="grid grid-cols-2 gap-3 mb-2">
                <div class="p-2.5 bg-white rounded-xl border border-blue-100 text-center">
                    <span class="text-[10px] font-bold text-blue-500 uppercase block">Putra Hadir</span>
                    <span class="text-lg font-black text-blue-700">{{ $stats['absen_putra_today'] }}</span>
                </div>
                <div class="p-2.5 bg-white rounded-xl border border-purple-100 text-center">
                    <span class="text-[10px] font-bold text-purple-500 uppercase block">Putri Hadir</span>
                    <span class="text-lg font-black text-purple-700">{{ $stats['absen_putri_today'] }}</span>
                </div>
            </div>
            <div class="text-[10px] text-slate-400 font-semibold text-center italic">Presensi real-time tercatat per kelas</div>
        </div>

        <!-- Metric 3: Keuangan SPP -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="flex justify-between items-center text-xs font-bold mb-3">
                <span class="text-slate-600 uppercase tracking-wider text-[11px]">Kelancaran SPP Santri</span>
                <span class="text-slate-900 font-black">{{ $stats['spp_lunas'] }} / {{ $stats['spp_lunas'] + $stats['spp_belum'] }} Lunas</span>
            </div>

            @php
                $totalSpp = max(1, $stats['spp_lunas'] + $stats['spp_belum']);
                $pctLunas = round(($stats['spp_lunas'] / $totalSpp) * 100);
            @endphp
            <div class="h-3 w-full bg-rose-200 rounded-full overflow-hidden flex mb-3">
                <div style="width: {{ $pctLunas }}%" class="bg-emerald-500 h-full"></div>
            </div>

            <div class="flex justify-between text-xs font-bold">
                <span class="text-emerald-600 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Lunas ({{ $pctLunas }}%)</span>
                </span>
                <span class="text-rose-600 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>Tunggakan ({{ 100 - $pctLunas }}%)</span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Split Tables: Jurnal Mengajar & Catatan Karakter Terbaru -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
    <!-- Jurnal Mengajar Terkini -->
    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-xs">
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-sm uppercase">Jurnal Mengajar Terkini</h3>
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Log Aktivitas Dewan Asatidz</span>
                </div>
            </div>
            <a href="{{ route('admin.absensi.guru') }}" class="text-[11px] font-bold text-school-primary hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            @forelse($recentJurnals as $j)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase {{ $j->kelas?->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $j->kelas?->nama_lengkap }}
                            </span>
                            <span class="text-xs font-bold text-slate-900 truncate">{{ $j->mapel?->nama_mapel }}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-medium line-clamp-1">{{ $j->materi }}</p>
                        <span class="text-[10px] text-slate-400 font-bold block mt-1">Oleh: {{ $j->guru?->name }} • {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</span>
                    </div>
                    <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded-lg font-bold shrink-0">Terverifikasi</span>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs italic">Belum ada jurnal mengajar terisi.</div>
            @endforelse
        </div>
    </div>

    <!-- Catatan Karakter & Prestasi Terkini -->
    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-xs">
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-sm uppercase">Poin Karakter & Prestasi</h3>
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Evaluasi Kedisiplinan Santri</span>
                </div>
            </div>
            <a href="{{ route('admin.kedisiplinan.index') }}" class="text-[11px] font-bold text-school-primary hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            @forelse($recentPoins as $p)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs font-bold text-slate-900 truncate">{{ $p->siswa?->name }}</span>
                            <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase {{ $p->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $p->unit?->gender === 'putra' ? 'Putra' : 'Putri' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 truncate">{{ $p->kategori?->nama }}</p>
                        <span class="text-[10px] text-slate-400 font-bold block mt-0.5">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</span>
                    </div>
                    <span class="px-2.5 py-1 rounded-xl text-xs font-black shrink-0 {{ $p->poin > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $p->poin > 0 ? "+{$p->poin}" : $p->poin }} Poin
                    </span>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs italic">Belum ada catatan poin tercatat.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- PPDB Pendaftar Terkini & Quick Links -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
    <div class="lg:col-span-2 p-6 bg-white rounded-3xl border border-slate-100 shadow-xs">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-black text-slate-900 text-sm uppercase">Pendaftar PPDB Terbaru</h3>
            <a href="{{ route('admin.ppdb.index') }}" class="text-[11px] font-bold text-school-primary hover:underline">Semua Pendaftar</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                        <th class="pb-3">No. Reg</th>
                        <th class="pb-3">Nama Lengkap</th>
                        <th class="pb-3">Unit</th>
                        <th class="pb-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentPendaftars as $pd)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 font-mono font-bold text-slate-700">{{ $pd->nomor_pendaftaran }}</td>
                            <td class="py-3 font-bold text-slate-900">{{ $pd->nama_lengkap }}</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $pd->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $pd->jenis_kelamin === 'L' ? 'MA Putra' : 'MA Putri' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $pd->status === 'diterima' ? 'bg-emerald-100 text-emerald-700' : ($pd->status === 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $pd->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400 italic">Belum ada pendaftar baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Tool Links -->
    <div class="p-6 bg-slate-900 rounded-3xl text-white shadow-xl flex flex-col justify-between">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-1">Aksi Cepat Demo</span>
            <h3 class="text-base font-black uppercase mb-4 text-white">Menu Favorit</h3>

            <div class="space-y-2.5">
                <a href="{{ route('admin.kedisiplinan.student-of-the-year') }}" class="flex items-center gap-3 p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Leaderboard Student of the Year</div>
                        <div class="text-[10px] text-slate-400">Ranking prestasi & karakter</div>
                    </div>
                </a>

                <a href="{{ route('admin.evaluasi.index') }}" class="flex items-center gap-3 p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Evaluasi & PDF Kinerja Guru</div>
                        <div class="text-[10px] text-slate-400">4 Kompetensi standar dinas</div>
                    </div>
                </a>

                <a href="{{ route('admin.keuangan.index') }}" class="flex items-center gap-3 p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Manajemen SPP & Notifikasi</div>
                        <div class="text-[10px] text-slate-400">Kirim pengingat ke ortu</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-white/10 text-[10px] text-slate-400 italic">
            *Semua data demo telah disiapkan untuk presentasi proposal INXDVI / MA Attaraqqie.
        </div>
    </div>
</div>
@endsection
