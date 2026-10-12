@extends('layouts.admin')

@section('title', 'Rekapitulasi Absensi Siswa')
@section('page_title', 'Rekapitulasi Absensi Santri')

@section('content')
<!-- Header Summary Cards -->
<div class="grid grid-cols-2 sm:grid-cols-5 gap-3 sm:gap-4 mb-6">
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Tercatat</span>
        <span class="text-xl font-black text-slate-900">{{ $summary['total'] }}</span>
    </div>
    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-xs">
        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block">Hadir</span>
        <span class="text-xl font-black text-emerald-700">{{ $summary['hadir'] }}</span>
    </div>
    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 shadow-xs">
        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest block">Izin</span>
        <span class="text-xl font-black text-blue-700">{{ $summary['izin'] }}</span>
    </div>
    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 shadow-xs">
        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest block">Sakit</span>
        <span class="text-xl font-black text-amber-700">{{ $summary['sakit'] }}</span>
    </div>
    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 shadow-xs col-span-2 sm:col-span-1">
        <span class="text-[10px] font-bold text-rose-600 uppercase tracking-widest block">Alpa</span>
        <span class="text-xl font-black text-rose-700">{{ $summary['alpa'] }}</span>
    </div>
</div>

<!-- Filters -->
<div class="p-5 bg-white rounded-3xl border border-slate-100 shadow-xs mb-6">
    <form method="GET" action="{{ route('admin.absensi.siswa') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 sm:gap-4 items-end">
        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Tanggal Presensi</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:border-school-primary">
        </div>
        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Filter Rombel / Kelas</label>
            <select name="kelas_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:border-school-primary">
                <option value="">Semua Rombel</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_lengkap }} ({{ $k->unit?->gender === 'putra' ? 'Putra' : 'Putri' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Filter Status</label>
            <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:border-school-primary">
                <option value="">Semua Status</option>
                <option value="hadir" {{ $status === 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="izin" {{ $status === 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ $status === 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="alpa" {{ $status === 'alpa' ? 'selected' : '' }}>Alpa</option>
            </select>
        </div>
        <div>
            <button type="submit" class="w-full py-2.5 px-4 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-800 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-filter text-xs"></i>
                <span>Terapkan Filter</span>
            </button>
        </div>
    </form>
</div>

<!-- Table Data -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4">Santri / Siswa</th>
                    <th class="py-3.5 px-4">Kelas & Unit</th>
                    <th class="py-3.5 px-4">Mata Pelajaran</th>
                    <th class="py-3.5 px-4">Status Kehadiran</th>
                    <th class="py-3.5 px-4">Keterangan</th>
                    <th class="py-3.5 px-4">Pencatat / Guru</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($absensis as $a)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $a->siswa?->name }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">NIS: {{ $a->siswaProfile?->nis ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-800 block">{{ $a->kelas?->nama_lengkap }}</span>
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $a->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $a->unit?->gender === 'putra' ? 'MA Putra' : 'MA Putri' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 font-medium">
                            {{ $a->mapel?->nama_mapel ?: 'Presensi Harian / Apel' }}
                        </td>
                        <td class="py-3.5 px-4">
                            @php
                                $badgeStyles = [
                                    'hadir' => 'bg-emerald-100 text-emerald-700',
                                    'izin' => 'bg-blue-100 text-blue-700',
                                    'sakit' => 'bg-amber-100 text-amber-700',
                                    'alpa' => 'bg-rose-100 text-rose-700',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $badgeStyles[$a->status] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ strtoupper($a->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 font-medium italic">
                            {{ $a->keterangan ?: '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 font-bold">
                            {{ $a->guru?->name ?: 'Wali Kelas' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 italic">
                            <i class="fa-solid fa-clipboard-user text-3xl mb-2 block text-slate-300"></i>
                            Tidak ada data absensi pada tanggal dan kriteria filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($absensis->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $absensis->links() }}
        </div>
    @endif
</div>
@endsection
