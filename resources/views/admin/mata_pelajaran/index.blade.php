@extends('layouts.admin')

@section('title', 'Manajemen Mata Pelajaran')
@section('page_title', 'Daftar Mata Pelajaran')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-bold text-slate-800">Master Data Mata Pelajaran</h2>
    <a href="{{ route('admin.mata-pelajaran.create') }}" class="px-4 py-2 bg-school-primary text-white rounded-lg font-bold text-sm hover:bg-school-primary/90 transition shadow-lg shadow-school-primary/30">
        <i class="fa-solid fa-plus mr-2"></i>Tambah Mapel
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl font-medium">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Kode Mapel</th>
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Nama Mata Pelajaran</th>
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Tingkat</th>
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($mapels as $mapel)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                    <td class="py-4 px-6 font-medium text-slate-900">
                        <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-bold font-mono">{{ $mapel->kode_mapel }}</span>
                    </td>
                    <td class="py-4 px-6 font-bold text-slate-800">{{ $mapel->nama_mapel }}</td>
                    <td class="py-4 px-6 text-slate-500 font-medium">
                        {{ $mapel->tingkat ? 'Tingkat ' . $mapel->tingkat : 'Semua Tingkat' }}
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.mata-pelajaran.edit', $mapel) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.mata-pelajaran.destroy', $mapel) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition" title="Hapus">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 px-6 text-center text-slate-400 font-medium">Belum ada data mata pelajaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
