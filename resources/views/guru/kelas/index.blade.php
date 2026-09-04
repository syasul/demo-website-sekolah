@extends('guru.layouts.app')

@section('title', 'Kelas & Siswa')
@section('page_title', 'Kelas & Siswa yang Diampu')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Rombongan Belajar</h2>
            <p class="text-xs text-slate-500 mt-1">Rombel kelas yang Anda ajar dan/atau bimbing sebagai wali kelas.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kelases as $k)
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-school-primary/10 text-school-primary font-black text-xl flex items-center justify-center">
                        {{ $k->tingkat }}
                    </div>
                    @if($guru->kelasWali && $guru->kelasWali->id === $k->id)
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                            <i class="fa-solid fa-id-badge text-[10px]"></i>
                            Wali Kelas
                        </span>
                    @endif
                </div>

                <h3 class="text-xl font-black text-slate-900 mb-1">Kelas {{ $k->nama_lengkap }}</h3>
                <p class="text-xs text-slate-500 mb-4 flex items-center gap-1.5">
                    <i class="fa-solid fa-user-tie text-slate-400"></i>
                    <span>Wali: {{ $k->waliKelas ? $k->waliKelas->name : 'Belum diatur' }}</span>
                </p>

                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 mb-6 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Jumlah Siswa:</span>
                        <span class="font-bold text-slate-800">{{ $k->siswas->count() }} Orang</span>
                    </div>
                    <div class="text-xs">
                        <span class="text-slate-500 font-medium block mb-1">Mapel yang Diajar:</span>
                        <div class="flex flex-wrap gap-1">
                            @forelse($k->guruMapels as $gm)
                                <span class="px-2 py-0.5 bg-white border border-slate-200 rounded-md text-[11px] font-bold text-slate-700">
                                    {{ $gm->mapel->nama_mapel ?? '-' }}
                                </span>
                            @empty
                                <span class="text-[11px] text-slate-400 italic">Hanya sebagai Wali Kelas</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                <a href="{{ route('guru.kelas.show', $k) }}" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-center rounded-xl font-bold text-xs transition">
                    Lihat Daftar Siswa
                </a>
                @if($k->guruMapels->count() > 0)
                    <a href="{{ route('guru.raport.create', ['kelas_id' => $k->id, 'mapel_id' => $k->guruMapels->first()->mapel_id]) }}" 
                       class="px-3.5 py-2.5 bg-school-primary hover:bg-school-primary/90 text-white rounded-xl font-bold text-xs transition shadow-sm"
                       title="Input Nilai">
                        <i class="fa-solid fa-file-pen"></i>
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 rounded-3xl border border-slate-100 text-center">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-chalkboard text-2xl"></i>
            </div>
            <h4 class="font-bold text-slate-700 text-base">Belum Ada Kelas yang Diampu</h4>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Admin belum menetapkan rombel kelas ataupun penugasan mengajar untuk akun Anda.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
