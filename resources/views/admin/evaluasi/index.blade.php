@extends('layouts.admin')

@section('title', 'Evaluasi Kinerja Guru')
@section('page_title', 'Evaluasi Kinerja Dewan Asatidz')

@section('content')
<!-- Header Bar -->
<div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-xs mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h3 class="font-black text-slate-900 text-sm uppercase">Laporan & Instrumen Penilaian Kinerja Guru (PKG)</h3>
        <p class="text-xs text-slate-500 font-medium mt-0.5">Penilaian komprehensif 4 kompetensi: Pedagogik, Profesional, Kepribadian, dan Sosial berstandar Kemenag.</p>
    </div>
    <a href="{{ route('admin.evaluasi.create') }}" class="py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 shadow-sm shrink-0">
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Nilai Guru Baru</span>
    </a>
</div>

<!-- Table Data -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4">Nama Pengajar</th>
                    <th class="py-3.5 px-4">Periode & Semester</th>
                    <th class="py-3.5 px-4 text-center">Pedagogik</th>
                    <th class="py-3.5 px-4 text-center">Profesional</th>
                    <th class="py-3.5 px-4 text-center">Kepribadian</th>
                    <th class="py-3.5 px-4 text-center">Sosial</th>
                    <th class="py-3.5 px-4 text-center">Skor Akhir</th>
                    <th class="py-3.5 px-4">Predikat</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($evaluasis as $e)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $e->guru?->name }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">Penilai: {{ $e->penilai?->name }}</span>
                        </td>
                        <td class="py-3.5 px-4 font-medium text-slate-700">
                            {{ $e->periode_tahun }} ({{ ucfirst($e->semester) }})
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-700">
                            {{ $e->skor_pedagogik }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-700">
                            {{ $e->skor_profesional }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-700">
                            {{ $e->skor_kepribadian }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-700">
                            {{ $e->skor_sosial }}
                        </td>
                        <td class="py-3.5 px-4 text-center font-black text-sm text-indigo-700">
                            {{ $e->skor_total }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase {{ $e->skor_total >= 85 ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $e->predikat }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="{{ route('admin.evaluasi.pdf', $e) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl font-bold text-xs transition-all" title="Unduh Lembar PDF">
                                <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                <span>Cetak PDF</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-slate-400 italic">
                            Belum ada rekaman evaluasi kinerja guru yang tersimpan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($evaluasis->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $evaluasis->links() }}
        </div>
    @endif
</div>
@endsection
