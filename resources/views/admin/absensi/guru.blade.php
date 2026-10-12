@extends('layouts.admin')

@section('title', 'Absensi & Jurnal Guru')
@section('page_title', 'Presensi & Verifikasi Jurnal Guru')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Pengajar</span>
        <span class="text-xl font-black text-slate-900">{{ $summary['total_guru'] }} Guru</span>
    </div>
    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-xs">
        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block">Sudah Absen Masuk</span>
        <span class="text-xl font-black text-emerald-700">{{ $summary['sudah_absen'] }} Guru</span>
    </div>
    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 shadow-xs">
        <span class="text-[10px] font-bold text-rose-600 uppercase tracking-widest block">Belum Presensi</span>
        <span class="text-xl font-black text-rose-700">{{ $summary['belum_absen'] }} Guru</span>
    </div>
    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 shadow-xs">
        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest block">Jurnal Terisi Hari Ini</span>
        <span class="text-xl font-black text-blue-700">{{ $summary['jurnal_terisi'] }} Guru</span>
    </div>
</div>

<!-- Filter Tanggal -->
<div class="p-5 bg-white rounded-3xl border border-slate-100 shadow-xs mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div>
        <h3 class="font-black text-slate-900 text-sm uppercase">Daftar Kepatuhan Presensi & Jurnal Guru</h3>
        <p class="text-xs text-slate-400 font-medium">Memastikan guru telah melakukan Absen Masuk sebelum mengisi materi jurnal mengajar.</p>
    </div>
    <form method="GET" action="{{ route('admin.absensi.guru') }}" class="flex items-center gap-2 w-full sm:w-auto">
        <input type="date" name="tanggal" value="{{ $tanggal }}" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:border-school-primary">
        <button type="submit" class="py-2 px-4 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-800 transition-all">
            Lihat
        </button>
    </form>
</div>

<!-- Table Data -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4">Nama Pendidik</th>
                    <th class="py-3.5 px-4">Penugasan Unit</th>
                    <th class="py-3.5 px-4">Status Absen Masuk</th>
                    <th class="py-3.5 px-4">Waktu Masuk</th>
                    <th class="py-3.5 px-4">Jurnal Mengajar</th>
                    <th class="py-3.5 px-4">Status Kepatuhan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($guruStats as $row)
                    @php
                        $g = $row['guru'];
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $g->name }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $g->email }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($g->units->isNotEmpty())
                                @foreach($g->units as $u)
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase inline-block mb-0.5 {{ $u->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $u->nama }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-slate-400 italic text-[11px]">Semua Unit</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($row['status_absen'] === 'hadir')
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">
                                    <i class="fa-solid fa-check text-[9px] mr-1"></i> Hadir
                                </span>
                            @elseif($row['status_absen'] === 'Belum Absen')
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase bg-rose-100 text-rose-700">
                                    Belum Absen
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase bg-amber-100 text-amber-700">
                                    {{ strtoupper($row['status_absen']) }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-700">
                            {{ $row['jam_masuk'] }}
                        </td>
                        <td class="py-3.5 px-4">
                            @if($row['jumlah_jurnal'] > 0)
                                <div class="font-bold text-blue-600 flex items-center gap-1.5">
                                    <i class="fa-solid fa-file-circle-check text-xs"></i>
                                    <span>{{ $row['jumlah_jurnal'] }} Jurnal Terisi</span>
                                </div>
                                <span class="text-[10px] text-slate-400 block line-clamp-1 italic">
                                    {{ $row['jurnals']->first()->materi }}
                                </span>
                            @else
                                <span class="text-slate-400 italic">Belum mengisi jurnal</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($row['is_complete'])
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase bg-emerald-500 text-white shadow-xs">
                                    Lengkap
                                </span>
                            @elseif($row['status_absen'] !== 'Belum Absen' && $row['jumlah_jurnal'] === 0)
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase bg-amber-100 text-amber-700">
                                    Menunggu Jurnal
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase bg-slate-100 text-slate-500">
                                    Belum Lengkap
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
