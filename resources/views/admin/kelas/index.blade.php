@extends('layouts.admin')

@section('title', 'Manajemen Kelas')
@section('page_title', 'Daftar Kelas')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-bold text-slate-800">Daftar Kelas per Tingkat</h2>
    <a href="{{ route('admin.kelas.create') }}" class="px-4 py-2 bg-school-primary text-white rounded-lg font-bold text-sm hover:bg-school-primary/90 transition">
        <i class="fa-solid fa-plus mr-2"></i>Tambah Kelas Baru
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl font-medium">
    {{ session('success') }}
</div>
@endif

<div class="space-y-8">
    @forelse($groupedKelas as $tingkat => $kelases)
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100">
        <h3 class="font-bold text-lg mb-4 pb-2 border-b border-slate-100 text-slate-900">Tingkat {{ $tingkat }}</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($kelases as $kelas)
            <div class="p-4 border border-slate-200 rounded-2xl hover:border-school-primary hover:shadow-md transition-all group relative overflow-hidden bg-slate-50">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-school-primary/10 rounded-full group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10">
                    <h4 class="text-2xl font-black text-slate-800 mb-1">{{ $kelas->nama_lengkap }}</h4>
                    <p class="text-xs text-slate-500 font-medium mb-3">
                        <i class="fa-solid fa-user-tie mr-1"></i>
                        {{ $kelas->waliKelas ? $kelas->waliKelas->name : 'Wali Kelas Belum Diatur' }}
                    </p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600">
                        <i class="fa-solid fa-user-graduate text-slate-400 text-[11px]"></i>
                        <span>{{ $kelas->siswas_count ?? 0 }} Siswa</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="text-center py-12 bg-white rounded-3xl shadow-sm border border-slate-100">
        <p class="text-slate-400 font-medium">Belum ada data kelas.</p>
    </div>
    @endforelse
</div>
@endsection
