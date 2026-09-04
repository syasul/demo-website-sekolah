@extends('guru.layouts.app')

@section('title', 'Detail Kelas ' . $kelas->nama_lengkap)
@section('page_title', 'Kelas ' . $kelas->nama_lengkap)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('guru.kelas.index') }}" class="text-slate-400 hover:text-slate-600 transition text-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2 class="text-xl font-bold text-slate-800">Daftar Siswa Kelas {{ $kelas->nama_lengkap }}</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Wali Kelas: <span class="font-bold text-slate-700">{{ $kelas->waliKelas ? $kelas->waliKelas->name : 'Belum ditentukan' }}</span>
                @if($isWali)
                    <span class="ml-2 px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[11px] font-bold">Anda adalah Wali Kelas</span>
                @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('guru.kelas.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition">
                Kembali
            </a>
            @if($kelas->guruMapels->where('guru_id', $guru->id)->count() > 0)
                <a href="{{ route('guru.raport.create', ['kelas_id' => $kelas->id, 'mapel_id' => $kelas->guruMapels->where('guru_id', $guru->id)->first()->mapel_id]) }}" 
                   class="px-4 py-2 bg-school-primary text-white hover:bg-school-primary/90 rounded-xl font-bold text-xs transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Input Nilai Kelas Ini</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Student Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-bold text-slate-800 text-sm">Anggota Rombongan Belajar ({{ $kelas->siswas->count() }} Siswa)</h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest w-16">No</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Nama Lengkap Siswa</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Email Akun</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($kelas->siswas as $index => $siswa)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-6 font-mono text-xs text-slate-400 font-bold">{{ $index + 1 }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs">
                                    {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-800">{{ $siswa->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-500 text-xs font-medium">{{ $siswa->email }}</td>
                        <td class="py-4 px-6 text-right">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-bold">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                Aktif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 px-6 text-center text-slate-400 text-xs font-medium">
                            Belum ada data siswa di kelas ini. Siswa dapat didaftarkan atau di-assign oleh Administrator.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
