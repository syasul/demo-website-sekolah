@extends('layouts.admin')

@section('title', 'Mata Pelajaran & KKM')
@section('page_title', 'Mata Pelajaran')

@section('content')
<div class="space-y-6" x-data="{ 
    search: '', 
    selectedTingkat: '',
    matches(kode, nama, tingkat) {
        const q = this.search.toLowerCase();
        const matchesQuery = !q || kode.toLowerCase().includes(q) || nama.toLowerCase().includes(q);
        const matchesTingkat = !this.selectedTingkat || String(tingkat) === String(this.selectedTingkat);
        return matchesQuery && matchesTingkat;
    }
}">
    <!-- Page Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900 tracking-tight">Kurikulum & Mata Pelajaran</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola daftar mata pelajaran, penugasan per tingkat rombel, dan standar ketuntasan minimal.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.mata-pelajaran.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-xs transition-colors">
                <i class="fa-solid fa-plus text-[11px]"></i>
                <span>Tambah Mapel</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-center justify-between gap-3">
        <!-- Search Input -->
        <div class="relative w-full md:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" x-model="search" placeholder="Cari kode atau nama mapel..." 
                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
        </div>

        <!-- Filter Tingkat Pills -->
        <div class="flex items-center gap-1.5 w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
            <button type="button" @click="selectedTingkat = ''" 
                    :class="selectedTingkat === '' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-medium'"
                    class="px-3 py-1.5 rounded-lg text-xs transition-colors whitespace-nowrap">
                Semua Tingkat
            </button>
            <button type="button" @click="selectedTingkat = '10'" 
                    :class="selectedTingkat === '10' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-medium'"
                    class="px-3 py-1.5 rounded-lg text-xs transition-colors whitespace-nowrap">
                Kelas 10
            </button>
            <button type="button" @click="selectedTingkat = '11'" 
                    :class="selectedTingkat === '11' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-medium'"
                    class="px-3 py-1.5 rounded-lg text-xs transition-colors whitespace-nowrap">
                Kelas 11
            </button>
            <button type="button" @click="selectedTingkat = '12'" 
                    :class="selectedTingkat === '12' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-medium'"
                    class="px-3 py-1.5 rounded-lg text-xs transition-colors whitespace-nowrap">
                Kelas 12
            </button>
        </div>
    </div>

    <!-- Data Table Container (Sleek SaaS Styling) -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-5 w-32">Kode</th>
                        <th class="py-3.5 px-5">Nama Mata Pelajaran</th>
                        <th class="py-3.5 px-5 w-40">Alokasi Tingkat</th>
                        <th class="py-3.5 px-5 w-24 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($mapels as $mapel)
                    <tr class="hover:bg-slate-50/70 transition-colors"
                        x-show="matches('{{ $mapel->kode_mapel }}', '{{ addslashes($mapel->nama_mapel) }}', '{{ $mapel->tingkat ?? '' }}')">
                        <td class="py-3.5 px-5 font-mono font-semibold text-slate-800">
                            <span class="px-2 py-0.5 bg-slate-100 border border-slate-200/80 rounded-md text-[11px] font-bold text-slate-700">
                                {{ $mapel->kode_mapel }}
                            </span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 text-xs sm:text-sm block leading-tight">{{ $mapel->nama_mapel }}</span>
                        </td>
                        <td class="py-3.5 px-5">
                            @if($mapel->tingkat)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-100">
                                    Tingkat {{ $mapel->tingkat }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-600">
                                    Semua Tingkat
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.mata-pelajaran.edit', $mapel) }}" 
                                   class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-800 hover:bg-slate-100 flex items-center justify-center transition-colors" 
                                   title="Edit Mata Pelajaran">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                                </a>
                                <form action="{{ route('admin.mata-pelajaran.destroy', $mapel) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-7 h-7 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-colors" 
                                            title="Hapus Mata Pelajaran">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 px-6 text-center text-slate-400">
                            <i class="fa-solid fa-book-open text-2xl text-slate-300 mb-2 block"></i>
                            <p class="font-medium">Belum ada data mata pelajaran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Counter -->
        <div class="py-3 px-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
            <span>Total: {{ $mapels->count() }} Mata Pelajaran</span>
            <span>Standar Kurikulum Terpadu</span>
        </div>
    </div>
</div>
@endsection
