@extends('layouts.admin')

@section('title', 'Poin Kedisiplinan & Prestasi')
@section('page_title', 'Kedisiplinan & Poin Karakter Santri')

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Catatan Prestasi</span>
        <span class="text-xl font-black text-emerald-600">{{ $stats['total_prestasi'] }}</span>
    </div>
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Catatan Pelanggaran</span>
        <span class="text-xl font-black text-rose-600">{{ $stats['total_pelanggaran'] }}</span>
    </div>
    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-xs">
        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block">Total Akumulasi Poin Plus</span>
        <span class="text-xl font-black text-emerald-700">+{{ $stats['total_poin_plus'] }}</span>
    </div>
    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 shadow-xs">
        <span class="text-[10px] font-bold text-rose-600 uppercase tracking-widest block">Total Akumulasi Poin Minus</span>
        <span class="text-xl font-black text-rose-700">-{{ $stats['total_poin_minus'] }}</span>
    </div>
</div>

<!-- Action Bar -->
<div class="p-5 bg-white rounded-3xl border border-slate-100 shadow-xs mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.kedisiplinan.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ empty($tipe) ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Semua ({{ $stats['total_prestasi'] + $stats['total_pelanggaran'] }})
        </a>
        <a href="{{ route('admin.kedisiplinan.index', ['tipe' => 'prestasi']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ $tipe === 'prestasi' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
            <i class="fa-solid fa-trophy mr-1 text-[10px]"></i> Prestasi
        </a>
        <a href="{{ route('admin.kedisiplinan.index', ['tipe' => 'pelanggaran']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold {{ $tipe === 'pelanggaran' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
            <i class="fa-solid fa-triangle-exclamation mr-1 text-[10px]"></i> Pelanggaran
        </a>
    </div>

    <div class="flex items-center gap-2.5 w-full sm:w-auto">
        <a href="{{ route('admin.kedisiplinan.student-of-the-year') }}" class="flex-1 sm:flex-none py-2 px-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-trophy text-xs"></i>
            <span>Student of the Year</span>
        </a>
        <a href="{{ route('admin.kedisiplinan.create') }}" class="flex-1 sm:flex-none py-2 px-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Catat Poin</span>
        </a>
    </div>
</div>

<!-- Table Data -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4">Tanggal</th>
                    <th class="py-3.5 px-4">Nama Santri</th>
                    <th class="py-3.5 px-4">Kelas & Unit</th>
                    <th class="py-3.5 px-4">Kategori Tindakan</th>
                    <th class="py-3.5 px-4">Poin</th>
                    <th class="py-3.5 px-4">Catatan / Detail</th>
                    <th class="py-3.5 px-4">Pencatat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($poinList as $p)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            {{ $p->siswa?->name }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-800 block">{{ $p->siswaProfile?->kelas?->nama_lengkap }}</span>
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $p->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $p->unit?->gender === 'putra' ? 'MA Putra' : 'MA Putri' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-bold {{ $p->poin > 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                            {{ $p->kategori?->nama }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-xl text-xs font-black tracking-wider {{ $p->poin > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $p->poin > 0 ? "+{$p->poin}" : $p->poin }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 italic">
                            {{ $p->catatan ?: '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 font-medium">
                            {{ $p->pencatat?->name ?: 'Admin / BK' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 italic">
                            Belum ada catatan poin kedisiplinan atau prestasi santri.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($poinList->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $poinList->links() }}
        </div>
    @endif
</div>
@endsection
