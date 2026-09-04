@extends('layouts.admin')

@section('title', 'Manajemen Guru')
@section('page_title', 'Data Guru')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Akun Guru & Penugasan</h2>
        <p class="text-xs text-slate-500 mt-1">Kelola data tenaga pendidik, wali kelas, serta mata pelajaran yang diampu.</p>
    </div>
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <form action="{{ route('admin.guru.index') }}" method="GET" class="relative flex-1 sm:w-64">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau email..." 
                   class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
        </form>
        <a href="{{ route('admin.guru.create') }}" class="px-4 py-2 bg-school-primary text-white rounded-xl font-bold text-xs hover:bg-school-primary/90 transition shadow-lg shadow-school-primary/20 shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Guru</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl font-medium text-sm flex items-center gap-3">
    <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Profil Guru</th>
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Wali Kelas</th>
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Mata Pelajaran & Kelas Diampu</th>
                    <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse($gurus as $guru)
                <tr class="hover:bg-slate-50/60 transition">
                    <!-- Guru Profile -->
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 font-black flex items-center justify-center text-sm shrink-0 border border-indigo-100 shadow-sm">
                                {{ strtoupper(substr($guru->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 leading-snug">{{ $guru->name }}</h4>
                                <p class="text-xs text-slate-500 font-medium">{{ $guru->email }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Wali Kelas Status -->
                    <td class="py-4 px-6">
                        @if($guru->kelasWali)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-bold">
                                <i class="fa-solid fa-id-badge text-[11px]"></i>
                                Kelas {{ $guru->kelasWali->nama_lengkap }}
                            </span>
                        @else
                            <span class="text-xs text-slate-400 font-medium italic">Bukan Wali Kelas</span>
                        @endif
                    </td>

                    <!-- Mapel & Kelas Diampu -->
                    <td class="py-4 px-6">
                        @if($guru->guruMapels->count() > 0)
                            <div class="flex flex-wrap gap-1.5 max-w-md">
                                @foreach($guru->guruMapels as $gm)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-medium border border-slate-200">
                                        <span class="font-bold text-school-primary">{{ $gm->kelas->nama_lengkap ?? '-' }}</span>
                                        <span class="text-slate-400">•</span>
                                        <span>{{ $gm->mapel->nama_mapel ?? '-' }}</span>
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-xs text-slate-400 font-medium italic">Belum ada kelas/mapel ditugaskan</span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.guru.assign', $guru) }}" 
                               class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-xs font-bold hover:bg-blue-100 transition flex items-center gap-1.5"
                               title="Kelola Penugasan Kelas & Mapel">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <span>Penugasan</span>
                            </a>
                            <a href="{{ route('admin.guru.edit', $guru) }}" 
                               class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition" 
                               title="Edit Profil">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun guru ini? Semua penugasan kelas dan mapel terkait juga akan dihapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition" 
                                        title="Hapus Guru">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 px-6 text-center text-slate-400 font-medium">
                        <div class="max-w-xs mx-auto text-center">
                            <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-user-tie text-xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-600 mb-1">Belum Ada Data Guru</p>
                            <p class="text-xs text-slate-400">Silakan klik tombol "Tambah Guru" di atas untuk mendaftarkan akun baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($gurus->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $gurus->links() }}
    </div>
    @endif
</div>
@endsection
