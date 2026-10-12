@extends('guru.layouts.app')

@section('title', 'Evaluasi Kinerja Diri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Evaluasi Kinerja Guru</h1>
            <p class="text-sm text-slate-500 mt-1">Transparansi penilaian capaian kompetensi pedagogik, profesional, kepribadian, dan sosial.</p>
        </div>
        @if ($latestEvaluasi)
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.evaluasi.pdf', $latestEvaluasi->id) }}" target="_blank" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf"></i> Unduh Laporan Kinerja (PDF)
                </a>
            </div>
        @endif
    </div>

    @if ($latestEvaluasi)
        <!-- Kartu Evaluasi Terkini -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl"></div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10 pb-6 border-b border-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-3xl font-black">
                        {{ number_format($latestEvaluasi->skor_total, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xl font-black">{{ $latestEvaluasi->guru->name }}</h2>
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $latestEvaluasi->predikat === 'Sangat Baik' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30' }}">
                                {{ $latestEvaluasi->predikat }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            Periode Penilaian: <b>Tahun {{ $latestEvaluasi->periode_tahun }} ({{ ucfirst($latestEvaluasi->periode_semester) }})</b> • Penilai: {{ $latestEvaluasi->penilai?->name ?? 'Kepala Madrasah' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white/5 px-4 py-3 rounded-2xl border border-white/10">
                    <div class="text-right">
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kehadiran KBM</div>
                        <div class="text-base font-black text-emerald-400">{{ $latestEvaluasi->kehadiran_persen }}%</div>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Jurnal Terisi</div>
                        <div class="text-base font-black text-sky-400">{{ $latestEvaluasi->jurnal_terisi_persen }}%</div>
                    </div>
                </div>
            </div>

            <!-- Breakdown 4 Kompetensi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6 relative z-10">
                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-400 mb-2">
                        <span>1. Pedagogik</span>
                        <span class="text-white">{{ number_format($latestEvaluasi->skor_pedagogik, 1) }} / 100</span>
                    </div>
                    <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $latestEvaluasi->skor_pedagogik }}%"></div>
                    </div>
                </div>

                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-400 mb-2">
                        <span>2. Profesional</span>
                        <span class="text-white">{{ number_format($latestEvaluasi->skor_profesional, 1) }} / 100</span>
                    </div>
                    <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                        <div class="bg-sky-500 h-full rounded-full" style="width: {{ $latestEvaluasi->skor_profesional }}%"></div>
                    </div>
                </div>

                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-400 mb-2">
                        <span>3. Kepribadian</span>
                        <span class="text-white">{{ number_format($latestEvaluasi->skor_kepribadian, 1) }} / 100</span>
                    </div>
                    <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full rounded-full" style="width: {{ $latestEvaluasi->skor_kepribadian }}%"></div>
                    </div>
                </div>

                <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-400 mb-2">
                        <span>4. Sosial</span>
                        <span class="text-white">{{ number_format($latestEvaluasi->skor_sosial, 1) }} / 100</span>
                    </div>
                    <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $latestEvaluasi->skor_sosial }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Catatan Evaluator -->
            @if ($latestEvaluasi->catatan)
                <div class="mt-6 p-4 rounded-2xl bg-white/5 border border-white/10 text-xs text-slate-300 leading-relaxed relative z-10">
                    <span class="font-bold text-emerald-400 block mb-1">Catatan & Saran Pembinaan Kepala Madrasah:</span>
                    "{{ $latestEvaluasi->catatan }}"
                </div>
            @endif
        </div>

        <!-- Riwayat Evaluasi Berkala -->
        <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-slate-800 text-base">Arsip Riwayat Evaluasi Berkala</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Histori rekam jejak penilaian kinerja pendidik</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-black uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">Periode</th>
                            <th class="py-4 px-6 text-center">Skor Total</th>
                            <th class="py-4 px-6 text-center">Predikat</th>
                            <th class="py-4 px-6 text-center">Pedagogik</th>
                            <th class="py-4 px-6 text-center">Profesional</th>
                            <th class="py-4 px-6 text-center">Kepribadian</th>
                            <th class="py-4 px-6 text-center">Sosial</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach ($evaluasis as $ev)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-800">
                                    {{ $ev->periode_tahun }} ({{ ucfirst($ev->periode_semester) }})
                                </td>
                                <td class="py-4 px-6 text-center font-black text-emerald-600">
                                    {{ number_format($ev->skor_total, 1) }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $ev->predikat === 'Sangat Baik' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $ev->predikat }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center font-semibold text-slate-600">{{ number_format($ev->skor_pedagogik, 1) }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-slate-600">{{ number_format($ev->skor_profesional, 1) }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-slate-600">{{ number_format($ev->skor_kepribadian, 1) }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-slate-600">{{ number_format($ev->skor_sosial, 1) }}</td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('admin.evaluasi.pdf', $ev->id) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 text-xs font-bold transition-all inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-award"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-base">Belum Ada Penilaian Kinerja</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Penilaian kinerja Anda belum diterbitkan oleh Kepala Madrasah untuk periode tahun ajaran ini.
            </p>
        </div>
    @endif
</div>
@endsection
