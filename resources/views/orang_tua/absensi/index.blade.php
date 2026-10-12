@extends('layouts.orang_tua')

@section('title', 'Histori Presensi Santri')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Presensi Ananda</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rekam jejak kehadiran {{ $selectedAnak->name }} di madrasah</p>
        </div>
        <a href="{{ route('orang-tua.dashboard') }}" class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <!-- Ringkasan Statistik Kehadiran -->
    <div class="bg-gradient-to-br from-emerald-800 to-teal-900 rounded-3xl p-6 text-white shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-white/10">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-300">Tingkat Kehadiran Kumulatif</div>
                <div class="text-3xl font-black mt-0.5">{{ $persenHadir }}%</div>
                <div class="text-xs text-slate-300 mt-1">Kelas: {{ $selectedAnak->siswa?->kelas?->nama_lengkap ?? 'MA At-Taraqqie' }}</div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $persenHadir >= 90 ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/30' : 'bg-amber-500/20 text-amber-300 border border-amber-400/30' }}">
                    <i class="fa-solid {{ $persenHadir >= 90 ? 'fa-circle-check' : 'fa-triangle-exclamation' }} mr-1"></i>
                    {{ $persenHadir >= 90 ? 'Disiplin Sangat Baik' : 'Perlu Perhatian' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 pt-4 text-center">
            <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-xs">
                <div class="text-[10px] text-emerald-300 font-bold uppercase">Hadir</div>
                <div class="text-lg font-black text-white mt-0.5">{{ $totalHadir }}</div>
            </div>
            <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-xs">
                <div class="text-[10px] text-amber-300 font-bold uppercase">Izin</div>
                <div class="text-lg font-black text-white mt-0.5">{{ $totalIzin }}</div>
            </div>
            <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-xs">
                <div class="text-[10px] text-blue-300 font-bold uppercase">Sakit</div>
                <div class="text-lg font-black text-white mt-0.5">{{ $totalSakit }}</div>
            </div>
            <div class="bg-white/10 p-2.5 rounded-2xl backdrop-blur-xs">
                <div class="text-[10px] text-rose-300 font-bold uppercase">Alpa</div>
                <div class="text-lg font-black text-white mt-0.5">{{ $totalAlpa }}</div>
            </div>
        </div>
    </div>

    <!-- Riwayat Kehadiran (List View Mobile-First) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-black text-slate-900">Histori Presensi Harian</h2>
            <span class="text-xs font-bold text-slate-400">Total: {{ $absensis->total() }} Catatan</span>
        </div>

        @if ($absensis->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach ($absensis as $absen)
                    @php
                        $badgeClasses = match($absen->status) {
                            'hadir' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'izin'  => 'bg-amber-100 text-amber-800 border-amber-200',
                            'sakit' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'alpa'  => 'bg-rose-100 text-rose-800 border-rose-200',
                            default => 'bg-slate-100 text-slate-800 border-slate-200'
                        };
                        $iconClass = match($absen->status) {
                            'hadir' => 'fa-check text-emerald-600',
                            'izin'  => 'fa-envelope-open-text text-amber-600',
                            'sakit' => 'fa-stethoscope text-blue-600',
                            'alpa'  => 'fa-xmark text-rose-600',
                            default => 'fa-clock text-slate-600'
                        };
                    @endphp
                    <div class="p-4 sm:p-5 hover:bg-slate-50/70 transition-colors flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 border border-slate-200/60 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5">
                                <i class="fa-solid {{ $iconClass }}"></i>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">
                                    {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d F Y') }}
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    Dicatat oleh: {{ $absen->guru?->name ?? 'Wali Kelas / Guru Piket' }}
                                </div>
                                @if ($absen->keterangan)
                                    <div class="text-xs text-slate-600 mt-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100 italic">
                                        "{{ $absen->keterangan }}"
                                    </div>
                                @endif
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider border {{ $badgeClasses }} flex-shrink-0">
                            {{ $absen->status }}
                        </span>
                    </div>
                @endforeach
            </div>

            @if ($absensis->hasPages())
                <div class="p-5 border-t border-slate-100">
                    {{ $absensis->links() }}
                </div>
            @endif
        @else
            <div class="p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-calendar-xmark"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">Belum Ada Catatan Presensi</h3>
                <p class="text-xs text-slate-400 mt-1">Data presensi harian santri akan muncul di sini setelah sesi dimulai.</p>
            </div>
        @endif
    </div>
</div>
@endsection
