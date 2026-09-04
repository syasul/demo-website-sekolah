@extends('siswa.layouts.app')

@section('title', 'Raport Digital Saya')
@section('page_title', 'Raport Hasil Belajar Siswa')

@section('content')
<div class="space-y-8">
    <!-- Header / Filter Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Buku Raport Digital</h2>
                <p class="text-xs text-slate-500">Laporan Capaian Kompetensi Peserta Didik Semester {{ $semester }} Tahun Pelajaran {{ $tahunAjaran }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('siswa.raport.index') }}" class="flex items-center gap-2">
                <select name="semester" class="text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50 py-2">
                    <option value="Ganjil" {{ $semester === 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                    <option value="Genap" {{ $semester === 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                </select>

                <select name="tahun_ajaran" class="text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50 py-2">
                    @foreach ($daftarTahun as $th)
                        <option value="{{ $th }}" {{ $tahunAjaran === $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-3 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-colors">
                    Filter
                </button>
            </form>

            <a href="{{ route('siswa.raport.pdf', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-900/20 transition-all hover:scale-105">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span>Unduh PDF Resmi</span>
            </a>
            <a href="{{ route('siswa.raport.pdf', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'mode' => 'preview']) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                <i class="fa-solid fa-print"></i>
                <span>Pratinjau Cetak</span>
            </a>
        </div>
    </div>

    <!-- Student & Academic Identity Box -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-sm">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Peserta Didik</span>
                <p class="font-extrabold text-slate-900 text-base">{{ $siswa->name }}</p>
                <p class="text-xs text-slate-500">{{ $siswa->email }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">NISN / Identitas</span>
                <p class="font-bold text-slate-800 font-mono text-base">{{ $siswa->nisn }}</p>
                <p class="text-xs text-slate-500">Madrasah Aliyah At-Taraqqie</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelas & Semester</span>
                <p class="font-bold text-slate-800 text-base">{{ $siswa->kelas ? 'Kelas ' . $siswa->kelas->nama_lengkap : '-' }}</p>
                <p class="text-xs text-emerald-600 font-semibold">Semester {{ $semester }} ({{ $tahunAjaran }})</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Wali Kelas</span>
                <p class="font-bold text-slate-800 text-base">{{ $siswa->kelas && $siswa->kelas->waliKelas ? $siswa->kelas->waliKelas->name : 'Belum Ditugaskan' }}</p>
                <p class="text-xs text-slate-500">NIP: 19820315 200801 1 005</p>
            </div>
        </div>
    </div>

    <!-- Raport Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">A. Nilai Hasil Belajar Akademik</h3>
                <p class="text-xs text-slate-500">Daftar capaian nilai pengetahuan, keterampilan, dan sikap per mata pelajaran</p>
            </div>
            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                {{ $nilais->count() }} Mata Pelajaran
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                        <th class="py-4 px-4 text-center w-12">No</th>
                        <th class="py-4 px-5">Mata Pelajaran</th>
                        <th class="py-4 px-4 text-center">KKM</th>
                        <th class="py-4 px-4 text-center">Pengetahuan</th>
                        <th class="py-4 px-4 text-center">Keterampilan</th>
                        <th class="py-4 px-4 text-center">Sikap</th>
                        <th class="py-4 px-4 text-center">Nilai Akhir</th>
                        <th class="py-4 px-4 text-center">Predikat</th>
                        <th class="py-4 px-5">Catatan Kompetensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($nilais as $index => $item)
                        @php
                            $kkm = $item->mapel ? $item->mapel->kkm : 75;
                            $isTuntas = ($item->nilai_pengetahuan >= $kkm) && ($item->status_remidi !== 'perlu');
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-4 text-center font-medium text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $item->mapel ? $item->mapel->nama_mapel : 'Mata Pelajaran' }}</div>
                                <div class="text-xs text-slate-400">Kode: {{ $item->mapel ? $item->mapel->kode_mapel : '-' }} &bull; Guru: {{ $item->guru ? $item->guru->name : '-' }}</div>
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
                                <span class="px-2 py-0.5 rounded-md font-bold text-xs bg-slate-100 text-slate-700">
                                    {{ $item->nilai_sikap ?? 'B' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-black {{ $isTuntas ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $item->nilai_akhir !== null ? number_format($item->nilai_akhir, 1) : '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="font-semibold text-xs text-slate-700">
                                    {{ $item->predikat }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-600 max-w-xs leading-relaxed">
                                {{ $item->catatan ?: ($isTuntas ? 'Tuntas mencapai indikator kompetensi dasar dengan predikat baik.' : 'Perlu ditingkatkan penguasaan materi inti.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-file-circle-question text-4xl mb-3 text-slate-300 block"></i>
                                Raport belum tersedia untuk periode semester {{ $semester }} {{ $tahunAjaran }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($nilais->isNotEmpty())
                    <tfoot>
                        <tr class="bg-slate-50 font-bold text-slate-800 border-t-2 border-slate-200">
                            <td colspan="3" class="py-4 px-5 text-right uppercase text-xs tracking-wider">Rata-Rata Capaian Nilai:</td>
                            <td class="py-4 px-4 text-center text-slate-900 font-extrabold">{{ $rataRataPengetahuan }}</td>
                            <td class="py-4 px-4 text-center text-slate-900 font-extrabold">{{ $rataRataKeterampilan }}</td>
                            <td class="py-4 px-4 text-center">-</td>
                            <td class="py-4 px-4 text-center text-emerald-700 font-black">{{ $rataRataAkhir }}</td>
                            <td colspan="2" class="py-4 px-5 text-slate-500 text-xs font-normal">
                                Dari total {{ $nilais->count() }} mata pelajaran
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Rincian Komponen Harian (Tugas, UH, UTS, UAS, Remidi) Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">B. Transparansi Nilai Harian & Ujian</h3>
                <p class="text-xs text-slate-500">Rincian nilai tugas harian, ulangan bab (UH), UTS, UAS, serta program remidi</p>
            </div>
            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                Transparansi Akademik
            </span>
        </div>

        @if ($komponens->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($komponens as $mapelId => $items)
                    @php
                        $mapelFirst = $items->first()->mapel;
                    @endphp
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/70">
                        <div class="flex items-center justify-between mb-3 border-b border-slate-200/80 pb-3">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $mapelFirst ? $mapelFirst->nama_mapel : 'Mata Pelajaran' }}</h4>
                                <p class="text-[11px] text-slate-500">KKM: {{ $mapelFirst->kkm ?? 75 }}</p>
                            </div>
                            <span class="text-xs font-bold text-slate-500 bg-white px-2 py-0.5 rounded-md border border-slate-200">
                                {{ $items->count() }} Penilaian
                            </span>
                        </div>

                        <div class="space-y-2">
                            @foreach ($items as $komp)
                                <div class="flex items-center justify-between text-xs py-1.5 px-2.5 rounded-xl bg-white border border-slate-100">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider
                                            {{ $komp->jenis === 'tugas' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $komp->jenis === 'uh' ? 'bg-amber-100 text-amber-700' : '' }}
                                            {{ $komp->jenis === 'uts' ? 'bg-purple-100 text-purple-700' : '' }}
                                            {{ $komp->jenis === 'uas' ? 'bg-rose-100 text-rose-700' : '' }}
                                            {{ $komp->jenis === 'remidi' ? 'bg-teal-100 text-teal-700' : '' }}">
                                            {{ $komp->jenis }}
                                        </span>
                                        <span class="font-medium text-slate-800 truncate">{{ $komp->judul }}</span>
                                    </div>
                                    <span class="font-bold {{ $komp->nilai < ($mapelFirst->kkm ?? 75) ? 'text-rose-600' : 'text-slate-900' }}">
                                        {{ number_format($komp->nilai, 1) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-8 text-center text-slate-400 text-sm">
                <i class="fa-solid fa-circle-nodes text-3xl mb-2 text-slate-300 block"></i>
                Belum ada rincian tugas atau ulangan harian yang tercatat pada semester ini.
            </div>
        @endif
    </div>

    <!-- Catatan Wali Kelas & Ekstrakurikuler -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Catatan Wali Kelas Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6">
            <h3 class="text-sm font-extrabold text-slate-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-comment-dots text-emerald-600"></i>
                <span>Catatan & Motivasi Wali Kelas</span>
            </h3>
            <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 text-xs text-slate-700 leading-relaxed min-h-[100px]">
                "Alhamdulillah, tingkatkan terus kedisiplinan dan semangat belajar. Pertahankan prestasi dan perluas keterlibatan dalam kegiatan positif madrasah."
            </div>
            <div class="mt-4 text-right">
                <p class="text-xs font-bold text-slate-800">{{ $siswa->kelas && $siswa->kelas->waliKelas ? $siswa->kelas->waliKelas->name : 'Wali Kelas' }}</p>
                <p class="text-[10px] text-slate-400">Wali Kelas {{ $siswa->kelas ? $siswa->kelas->nama_lengkap : '' }}</p>
            </div>
        </div>

        <!-- Kehadiran & Keputusan Kenaikan / Kelulusan -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6">
            <h3 class="text-sm font-extrabold text-slate-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                <span>Ketidakhadiran & Status Semester</span>
            </h3>
            <div class="grid grid-cols-3 gap-3 mb-4 text-center">
                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs text-slate-400 block font-semibold">Sakit</span>
                    <span class="text-lg font-black text-slate-800">0</span>
                    <span class="text-[10px] text-slate-400">hari</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs text-slate-400 block font-semibold">Izin</span>
                    <span class="text-lg font-black text-slate-800">1</span>
                    <span class="text-[10px] text-slate-400">hari</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs text-slate-400 block font-semibold">Tanpa Ket.</span>
                    <span class="text-lg font-black text-slate-800">0</span>
                    <span class="text-[10px] text-slate-400">hari</span>
                </div>
            </div>

            <div class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-900 border border-emerald-200 text-xs flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <div>
                    <span class="font-bold block">Status: Memenuhi Syarat Kelulusan / Kenaikan Kelas</span>
                    <span class="text-[11px] text-emerald-700">Peserta didik berhak melanjutkan ke jenjang berikutnya.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
