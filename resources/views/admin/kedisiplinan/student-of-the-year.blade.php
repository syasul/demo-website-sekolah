@extends('layouts.admin')

@section('title', 'Student of the Year Leaderboard')
@section('page_title', 'Student of the Year — MA Attaraqqie')

@section('content')
<!-- Leaderboard Banner -->
<div class="mb-8 p-6 sm:p-8 bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 rounded-3xl text-slate-900 shadow-xl relative overflow-hidden">
    <div class="absolute -right-8 -bottom-8 text-amber-300/40 text-9xl font-black">
        <i class="fa-solid fa-trophy"></i>
    </div>
    <div class="relative z-10 max-w-xl">
        <span class="px-2.5 py-1 rounded-lg bg-slate-900 text-amber-300 text-[10px] font-black uppercase tracking-widest inline-block mb-2">
            Pemeringkatan Karakter & Prestasi 2026
        </span>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight uppercase leading-tight mb-2">
            Student of the Year
        </h1>
        <p class="text-xs sm:text-sm font-medium text-slate-900/80 leading-relaxed">
            Kalkulasi otomatis berdasarkan akumulasi poin prestasi positif (60%), konsistensi nilai akademik (40%), dan keteladanan nihil pelanggaran asrama.
        </p>
    </div>
</div>

<!-- Top 3 Podium Cards -->
@if($students->count() >= 3)
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-8 items-end">
    <!-- Rank 2: Silver -->
    <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-xs text-center order-2 md:order-1 relative">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 font-black text-xl flex items-center justify-center mx-auto mb-3 shadow-inner">
            🥈
        </div>
        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Peringkat 2</span>
        <h4 class="font-black text-slate-900 text-sm mb-1 truncate">{{ $students[1]['user']->name }}</h4>
        <span class="text-xs text-slate-500 block mb-3 font-semibold">{{ $students[1]['user']->siswa?->kelas?->nama_lengkap }}</span>
        
        <div class="p-2.5 bg-slate-50 rounded-xl text-xs font-black text-slate-700 flex justify-around">
            <div>
                <span class="text-[9px] text-slate-400 uppercase block font-bold">Poin Net</span>
                <span>+{{ $students[1]['net_poin'] }}</span>
            </div>
            <div>
                <span class="text-[9px] text-slate-400 uppercase block font-bold">Skor Akhir</span>
                <span class="text-indigo-600">{{ $students[1]['skor_akhir'] }}</span>
            </div>
        </div>
    </div>

    <!-- Rank 1: Gold Champion -->
    <div class="p-6 sm:p-8 bg-gradient-to-b from-amber-50 to-white rounded-3xl border-2 border-amber-300 shadow-lg text-center order-1 md:order-2 relative -translate-y-2">
        <div class="w-16 h-16 rounded-3xl bg-amber-400 text-slate-900 font-black text-3xl flex items-center justify-center mx-auto mb-3 shadow-md">
            👑
        </div>
        <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-900 text-[10px] font-black uppercase tracking-widest inline-block mb-1">Juara 1 — Teladan</span>
        <h4 class="font-black text-slate-900 text-base mb-1 truncate">{{ $students[0]['user']->name }}</h4>
        <span class="text-xs text-slate-500 block mb-3 font-bold">{{ $students[0]['user']->siswa?->kelas?->nama_lengkap }}</span>
        
        <div class="p-3 bg-amber-100/50 rounded-2xl text-xs font-black text-slate-900 flex justify-around border border-amber-200">
            <div>
                <span class="text-[9px] text-amber-800 uppercase block font-bold">Poin Net</span>
                <span class="text-emerald-700 text-sm">+{{ $students[0]['net_poin'] }}</span>
            </div>
            <div>
                <span class="text-[9px] text-amber-800 uppercase block font-bold">Rata Akademik</span>
                <span class="text-sm">{{ $students[0]['rata_nilai'] }}</span>
            </div>
            <div>
                <span class="text-[9px] text-amber-800 uppercase block font-bold">Skor Komposit</span>
                <span class="text-amber-800 text-base font-black">{{ $students[0]['skor_akhir'] }}</span>
            </div>
        </div>
        @if($students[0]['nihil_pelanggaran'])
            <div class="mt-2.5 text-[10px] text-emerald-700 font-black flex items-center justify-center gap-1">
                <i class="fa-solid fa-circle-check"></i>
                <span>Nihil Pelanggaran (Zero Penalty)</span>
            </div>
        @endif
    </div>

    <!-- Rank 3: Bronze -->
    <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-xs text-center order-3 relative">
        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 font-black text-xl flex items-center justify-center mx-auto mb-3 shadow-inner">
            🥉
        </div>
        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Peringkat 3</span>
        <h4 class="font-black text-slate-900 text-sm mb-1 truncate">{{ $students[2]['user']->name }}</h4>
        <span class="text-xs text-slate-500 block mb-3 font-semibold">{{ $students[2]['user']->siswa?->kelas?->nama_lengkap }}</span>
        
        <div class="p-2.5 bg-slate-50 rounded-xl text-xs font-black text-slate-700 flex justify-around">
            <div>
                <span class="text-[9px] text-slate-400 uppercase block font-bold">Poin Net</span>
                <span>+{{ $students[2]['net_poin'] }}</span>
            </div>
            <div>
                <span class="text-[9px] text-slate-400 uppercase block font-bold">Skor Akhir</span>
                <span class="text-indigo-600">{{ $students[2]['skor_akhir'] }}</span>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Full Leaderboard Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-black text-slate-900 text-sm uppercase">Peringkat Lengkap Santri</h3>
        <span class="text-xs text-slate-400 font-medium">Diurutkan berdasarkan skor komposit</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4 w-12 text-center">Rank</th>
                    <th class="py-3.5 px-4">Nama Santri</th>
                    <th class="py-3.5 px-4">Rombel & Unit</th>
                    <th class="py-3.5 px-4 text-center">Poin Prestasi (+)</th>
                    <th class="py-3.5 px-4 text-center">Pelanggaran (-)</th>
                    <th class="py-3.5 px-4 text-center">Poin Net</th>
                    <th class="py-3.5 px-4 text-center">Rata Nilai</th>
                    <th class="py-3.5 px-4 text-right">Skor Komposit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($students as $idx => $row)
                    @php
                        $u = $row['user'];
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors {{ $idx === 0 ? 'bg-amber-50/30' : '' }}">
                        <td class="py-3.5 px-4 font-black text-center">
                            @if($idx === 0)
                                <span class="w-6 h-6 rounded-full bg-amber-400 text-slate-900 text-[11px] font-black inline-flex items-center justify-center">1</span>
                            @elseif($idx === 1)
                                <span class="w-6 h-6 rounded-full bg-slate-300 text-slate-800 text-[11px] font-black inline-flex items-center justify-center">2</span>
                            @elseif($idx === 2)
                                <span class="w-6 h-6 rounded-full bg-amber-700 text-white text-[11px] font-black inline-flex items-center justify-center">3</span>
                            @else
                                <span class="text-slate-400 font-bold">#{{ $idx + 1 }}</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $u->name }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">NIS: {{ $u->siswa?->nis ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-800 block">{{ $u->siswa?->kelas?->nama_lengkap }}</span>
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $u->siswa?->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $u->siswa?->unit?->gender === 'putra' ? 'MA Putra' : 'MA Putri' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold text-emerald-600">
                            +{{ $row['poin_plus'] }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold text-rose-600">
                            {{ $row['poin_minus'] > 0 ? "-{$row['poin_minus']}" : '0' }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded-lg text-xs font-black {{ $row['net_poin'] >= 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $row['net_poin'] >= 0 ? "+{$row['net_poin']}" : $row['net_poin'] }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-700">
                            {{ $row['rata_nilai'] }}
                        </td>
                        <td class="py-3.5 px-4 text-right font-black text-sm text-slate-900">
                            {{ $row['skor_akhir'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
