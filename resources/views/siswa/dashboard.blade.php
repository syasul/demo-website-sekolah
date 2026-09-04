@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Akademik')

@section('content')
<div class="space-y-8">
    <!-- Welcome Profile Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-linear-to-r from-emerald-800 via-teal-900 to-slate-900 p-6 sm:p-10 text-white shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-2xl sm:text-3xl font-black italic shadow-inner shrink-0">
                    {{ strtoupper(substr($siswa->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/30 border border-emerald-400/40 text-[11px] font-bold uppercase tracking-wider text-emerald-300">
                            Siswa Aktif
                        </span>
                        <span class="text-xs text-slate-300">NISN: <span class="font-mono font-semibold">{{ $siswa->nisn }}</span></span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $siswa->name }}</h2>
                    <p class="text-sm text-slate-300 mt-1 flex flex-wrap items-center gap-x-4 gap-y-1">
                        <span><i class="fa-solid fa-graduation-cap mr-1 text-emerald-400"></i> {{ $siswa->kelas ? 'Kelas ' . $siswa->kelas->nama_lengkap : 'Belum Terdaftar Kelas' }}</span>
                        <span><i class="fa-solid fa-user-tie mr-1 text-emerald-400"></i> Wali Kelas: {{ $siswa->kelas && $siswa->kelas->waliKelas ? $siswa->kelas->waliKelas->name : 'Belum Ditentukan' }}</span>
                    </p>
                </div>
            </div>

            <!-- Fast Action Link to Raport -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('siswa.raport.index', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-900/30 transition-all hover:scale-105">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>Buka Raport Digital</span>
                </a>
                <a href="{{ route('siswa.raport.pdf', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm backdrop-blur-md transition-all">
                    <i class="fa-solid fa-download"></i>
                    <span>Unduh PDF</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Semester & Info Periode -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Periode Akademik Aktif</h3>
                <p class="text-xs text-slate-500">Semester {{ $semester }} &bull; Tahun Ajaran {{ $tahunAjaran }}</p>
            </div>
        </div>

        <form method="GET" action="{{ route('siswa.dashboard') }}" class="flex items-center gap-2">
            <select name="semester" class="text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50 py-2">
                <option value="Ganjil" {{ $semester === 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                <option value="Genap" {{ $semester === 'Genap' ? 'selected' : '' }}>Semester Genap</option>
            </select>
            <select name="tahun_ajaran" class="text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50 py-2">
                <option value="2024/2025" {{ $tahunAjaran === '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                <option value="2025/2026" {{ $tahunAjaran === '2025/2026' ? 'selected' : '' }}>2025/2026</option>
            </select>
            <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-xs font-bold transition-colors">
                Terapkan
            </button>
        </form>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Mapel -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-book-bookmark text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-slate-400">Mata Pelajaran</span>
            </div>
            <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalMapel }}</div>
            <p class="text-xs text-slate-500 mt-1">Mata pelajaran dinilai semester ini</p>
        </div>

        <!-- Card 2: Rata-Rata Akhir -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Rata-Rata</span>
            </div>
            <div class="text-3xl font-black text-slate-900 tracking-tight">
                {{ $rataRataAkhir ?? '0.0' }}
            </div>
            <p class="text-xs text-slate-500 mt-1">Indeks capaian nilai akhir raport</p>
        </div>

        <!-- Card 3: Mapel Tuntas -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-md">&ge; KKM</span>
            </div>
            <div class="text-3xl font-black text-teal-600 tracking-tight">{{ $mapelTuntas }} <span class="text-base font-normal text-slate-400">/ {{ $totalMapel }}</span></div>
            <p class="text-xs text-slate-500 mt-1">Mata pelajaran tuntas KKM</p>
        </div>

        <!-- Card 4: Perlu Remidi / Perbaikan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl {{ $mapelRemidi > 0 ? 'bg-amber-50 text-amber-600' : 'bg-slate-50 text-slate-400' }} flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <span class="text-xs font-semibold {{ $mapelRemidi > 0 ? 'text-amber-600 bg-amber-50' : 'text-slate-500 bg-slate-50' }} px-2 py-0.5 rounded-md">Status</span>
            </div>
            <div class="text-3xl font-black {{ $mapelRemidi > 0 ? 'text-amber-600' : 'text-slate-900' }} tracking-tight">
                {{ $mapelRemidi }}
            </div>
            <p class="text-xs text-slate-500 mt-1">Mata pelajaran perlu remedial</p>
        </div>
    </div>

    <!-- Ringkasan Nilai Raport & Aktivitas Terbaru Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Tabel Ringkasan Nilai Raport (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Ringkasan Nilai Mata Pelajaran</h3>
                    <p class="text-xs text-slate-500">Nilai hasil kalkulasi tugas, ulangan, UTS, & UAS</p>
                </div>
                <a href="{{ route('siswa.raport.index', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                    Lihat Raport Penuh &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-5">Mata Pelajaran</th>
                            <th class="py-3 px-4 text-center">KKM</th>
                            <th class="py-3 px-4 text-center">Pengetahuan</th>
                            <th class="py-3 px-4 text-center">Keterampilan</th>
                            <th class="py-3 px-4 text-center">Nilai Akhir</th>
                            <th class="py-3 px-5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($nilais as $item)
                            @php
                                $kkm = $item->mapel ? $item->mapel->kkm : 75;
                                $isTuntas = ($item->nilai_pengetahuan >= $kkm) && ($item->status_remidi !== 'perlu');
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-5">
                                    <div class="font-bold text-slate-900">{{ $item->mapel ? $item->mapel->nama_mapel : 'Mata Pelajaran' }}</div>
                                    <div class="text-xs text-slate-400">Pengampu: {{ $item->guru ? $item->guru->name : '-' }}</div>
                                </td>
                                <td class="py-4 px-4 text-center font-semibold text-slate-600">{{ $kkm }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="font-bold {{ $item->nilai_pengetahuan < $kkm ? 'text-rose-600' : 'text-slate-800' }}">
                                        {{ $item->nilai_pengetahuan !== null ? number_format($item->nilai_pengetahuan, 1) : '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center font-semibold text-slate-700">
                                    {{ $item->nilai_keterampilan !== null ? number_format($item->nilai_keterampilan, 1) : '-' }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-black {{ $isTuntas ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                        {{ $item->nilai_akhir !== null ? number_format($item->nilai_akhir, 1) : '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if ($item->status_remidi === 'perlu')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-xs font-bold">
                                            <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Perlu Remidi
                                        </span>
                                    @elseif ($item->status_remidi === 'sudah_remidi')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-sky-100 text-sky-800 text-xs font-bold">
                                            <i class="fa-solid fa-check text-[10px]"></i> Sudah Remidi
                                        </span>
                                    @elseif ($isTuntas)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-xs font-bold">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> Tuntas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-100 text-rose-800 text-xs font-bold">
                                            Belum Tuntas
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400">
                                    <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                    Belum ada data nilai yang dipublikasikan untuk semester {{ $semester }} {{ $tahunAjaran }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Panel Aktivitas Komponen Terbaru (1 Col) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-slate-900">Aktivitas Penilaian</h3>
                    <span class="text-xs text-slate-400">Terbaru</span>
                </div>

                <div class="space-y-4">
                    @forelse ($aktivitasTerbaru as $komp)
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 
                                    {{ $komp->jenis === 'tugas' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $komp->jenis === 'uh' ? 'bg-amber-100 text-amber-600' : '' }}
                                    {{ $komp->jenis === 'uts' ? 'bg-purple-100 text-purple-600' : '' }}
                                    {{ $komp->jenis === 'uas' ? 'bg-rose-100 text-rose-600' : '' }}
                                    {{ $komp->jenis === 'remidi' ? 'bg-teal-100 text-teal-600' : '' }}">
                                    @if ($komp->jenis === 'tugas')
                                        <i class="fa-solid fa-list-check"></i>
                                    @elseif ($komp->jenis === 'uh')
                                        <i class="fa-solid fa-clipboard-question"></i>
                                    @elseif ($komp->jenis === 'remidi')
                                        <i class="fa-solid fa-rotate-right"></i>
                                    @else
                                        <i class="fa-solid fa-file-signature"></i>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ $komp->judul }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ $komp->mapel ? $komp->mapel->nama_mapel : '-' }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-sm font-black {{ $komp->nilai < ($komp->mapel->kkm ?? 75) ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ number_format($komp->nilai, 1) }}
                                </span>
                                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">{{ strtoupper($komp->jenis) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">
                            <i class="fa-solid fa-inbox text-2xl text-slate-300 block mb-2"></i>
                            Belum ada entri penilaian harian pada periode ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Petunjuk Siswa Card -->
            <div class="mt-6 p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-emerald-600 mt-0.5 text-sm"></i>
                    <div>
                        <h4 class="text-xs font-bold text-emerald-900">Perhatian Nilai Raport</h4>
                        <p class="text-[11px] text-emerald-700 mt-0.5 leading-relaxed">
                            Jika terdapat mata pelajaran dengan status <strong>Perlu Remidi</strong>, segera hubungi guru pengampu mata pelajaran yang bersangkutan untuk mengikuti program perbaikan nilai.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
