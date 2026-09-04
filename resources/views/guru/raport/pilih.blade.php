@extends('guru.layouts.app')

@section('title', 'Pilih Kelas & Mapel Raport')
@section('page_title', 'Input Nilai Raport')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pilih Rombel & Mata Pelajaran</h2>
            <p class="text-xs text-slate-500 mt-1">Pilih kelas dan mata pelajaran yang ingin Anda input atau edit nilai raportnya.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl font-medium text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($guruMapels as $gm)
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-school-primary/10 text-school-primary font-black rounded-xl text-xs">
                        Kelas {{ $gm->kelas->nama_lengkap }}
                    </span>
                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 font-mono font-bold rounded-lg text-[11px]">
                        {{ $gm->mapel->kode_mapel }}
                    </span>
                </div>

                <h3 class="text-lg font-black text-slate-800 group-hover:text-school-primary transition mb-1">
                    {{ $gm->mapel->nama_mapel }}
                </h3>
                <p class="text-xs text-slate-500 mb-4">
                    Tingkat {{ $gm->kelas->tingkat }} • {{ $gm->kelas->siswas->count() }} Siswa Terdaftar
                </p>

                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 mb-6 text-xs text-slate-600">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-slate-400">Semester Aktif:</span>
                        <span class="font-bold">Ganjil</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Tahun Ajaran:</span>
                        <span class="font-bold">2025/2026</span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                <a href="{{ route('guru.raport.create', ['kelas_id' => $gm->kelas_id, 'mapel_id' => $gm->mapel_id, 'semester' => 'ganjil', 'tahun_ajaran' => '2025/2026']) }}" 
                   class="flex-1 py-2.5 bg-school-primary hover:bg-school-primary/90 text-white text-center rounded-xl font-bold text-xs transition shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                    <span>Mulai Input Nilai</span>
                </a>
                <a href="{{ route('guru.raport.rekap', ['kelas_id' => $gm->kelas_id, 'mapel_id' => $gm->mapel_id]) }}" 
                   class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition"
                   title="Lihat Rekap">
                    <i class="fa-solid fa-chart-column"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 rounded-3xl border border-slate-100 text-center">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-file-circle-xmark text-2xl"></i>
            </div>
            <h4 class="font-bold text-slate-700 text-base">Belum Ada Penugasan Nilai</h4>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Anda belum memiliki mata pelajaran dan kelas yang diampu. Hubungi administrator sekolah.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
