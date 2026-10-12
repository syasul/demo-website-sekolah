@extends('layouts.admin')

@section('title', 'Moderasi Rumah Jurnal')
@section('page_title', 'Moderasi Publikasi Rumah Jurnal')

@section('content')
<!-- Stats Bar -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Karya Terindeks</span>
        <span class="text-xl font-black text-slate-900">{{ $stats['total'] }}</span>
    </div>
    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-xs">
        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block">Terverifikasi (Approved)</span>
        <span class="text-xl font-black text-emerald-700">{{ $stats['approved'] }}</span>
    </div>
    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 shadow-xs">
        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest block">Menunggu Review</span>
        <span class="text-xl font-black text-amber-700">{{ $stats['pending'] }}</span>
    </div>
</div>

<!-- Table Data -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4">Judul Artikel / Riset</th>
                    <th class="py-3.5 px-4">Penulis & Unit</th>
                    <th class="py-3.5 px-4">Kategori</th>
                    <th class="py-3.5 px-4">Tahun</th>
                    <th class="py-3.5 px-4">Status</th>
                    <th class="py-3.5 px-4 text-right">Moderasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($jurnals as $j)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4 max-w-sm">
                            <span class="font-bold text-slate-900 block leading-snug">{{ $j->judul }}</span>
                            <p class="text-[11px] text-slate-500 line-clamp-2 mt-1">{{ $j->abstrak }}</p>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="font-bold text-slate-800 block">{{ $j->penulis }}</span>
                            <span class="text-[10px] text-slate-400">{{ $j->unit?->nama ?: 'MA Attaraqqie' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                {{ $j->kategori }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-700">
                            {{ $j->tahun }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase {{ $j->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($j->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                {{ $j->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                @if($j->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.rumah-jurnal.update-status', $j) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition-all">
                                            Approve
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.rumah-jurnal.destroy', $j) }}" onsubmit="return confirm('Hapus karya ilmiah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 italic">
                            Belum ada artikel publikasi di Rumah Jurnal.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jurnals->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $jurnals->links() }}
        </div>
    @endif
</div>
@endsection
