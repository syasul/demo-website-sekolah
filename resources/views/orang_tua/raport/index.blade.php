@extends('layouts.orang_tua')

@section('title', 'Raport Digital Santri')

@section('content')
<div class="space-y-5">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Raport Digital Ananda</h1>
            <p class="text-xs text-slate-500 mt-0.5">Laporan capaian hasil belajar santri {{ $selectedAnak->name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('orang-tua.raport.pdf', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-file-pdf"></i> Unduh Raport PDF
            </a>
        </div>
    </div>

    <!-- Filter Semester & Tahun -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('orang-tua.raport.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Tahun Ajaran</label>
                <select name="tahun_ajaran" onchange="this.form.submit()" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 text-xs font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                    @foreach ($daftarTahun as $th)
                        <option value="{{ $th }}" {{ $tahunAjaran === $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Semester</label>
                <select name="semester" onchange="this.form.submit()" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 text-xs font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                    <option value="ganjil" {{ $semester === 'ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                    <option value="genap" {{ $semester === 'genap' ? 'selected' : '' }}>Semester Genap</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-all">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Rata-Rata Nilai Raport -->
    <div class="grid grid-cols-3 gap-3">
        <div class="bg-white p-4 rounded-3xl border border-slate-200/80 text-center shadow-xs">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pengetahuan</div>
            <div class="text-xl sm:text-2xl font-black text-slate-800 mt-1">{{ $rataRataPengetahuan }}</div>
            <div class="text-[10px] text-emerald-600 font-bold mt-0.5">Rata-rata</div>
        </div>
        <div class="bg-white p-4 rounded-3xl border border-slate-200/80 text-center shadow-xs">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterampilan</div>
            <div class="text-xl sm:text-2xl font-black text-slate-800 mt-1">{{ $rataRataKeterampilan }}</div>
            <div class="text-[10px] text-sky-600 font-bold mt-0.5">Rata-rata</div>
        </div>
        <div class="bg-slate-900 p-4 rounded-3xl text-center text-white shadow-md">
            <div class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Nilai Akhir</div>
            <div class="text-xl sm:text-2xl font-black text-white mt-1">{{ $rataRataAkhir }}</div>
            <div class="text-[10px] text-emerald-400 font-bold mt-0.5">IPK Kumulatif</div>
        </div>
    </div>

    <!-- Tabel Hasil Belajar Santri -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-black text-slate-900">Daftar Capaian Mata Pelajaran</h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Tahun Ajaran {{ $tahunAjaran }} — Semester {{ ucfirst($semester) }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                {{ $nilais->count() }} Mapel
            </span>
        </div>

        @if ($nilais->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-[10px] font-black uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-4 w-10 text-center">No</th>
                            <th class="py-3 px-4">Mata Pelajaran & Guru</th>
                            <th class="py-3 px-4 text-center">Pengetahuan</th>
                            <th class="py-3 px-4 text-center">Keterampilan</th>
                            <th class="py-3 px-4 text-center">Nilai Akhir</th>
                            <th class="py-3 px-4 text-center">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach ($nilais as $idx => $nilai)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4 text-center font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $nilai->mapel?->nama ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">Pengampu: {{ $nilai->guru?->name ?? 'Dewan Guru' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-slate-700">
                                    {{ number_format($nilai->nilai_pengetahuan, 0) }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-slate-700">
                                    {{ number_format($nilai->nilai_keterampilan, 0) }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-black text-emerald-700 text-sm">
                                    {{ number_format($nilai->nilai_akhir, 0) }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded-md font-bold text-[11px] {{ in_array($nilai->predikat, ['A', 'A+']) ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $nilai->predikat ?? 'B' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">Nilai Belum Diterbitkan</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                    Data nilai raport untuk periode {{ $tahunAjaran }} (Semester {{ ucfirst($semester) }}) belum difinalisasi oleh pihak kurikulum.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
