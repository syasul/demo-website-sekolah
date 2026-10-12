@extends('layouts.admin')

@section('title', 'Integrasi RDM Kemenag (Simulasi)')
@section('page_title', 'Simulasi Integrasi RDM Kemenag')

@section('content')
<!-- Disclaimer Banner (Clear Demo Mode Warning) -->
<div class="mb-6 p-5 sm:p-6 bg-gradient-to-r from-emerald-900 to-slate-900 rounded-3xl text-white shadow-xl relative overflow-hidden">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </div>
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 rounded bg-emerald-500 text-slate-900 text-[10px] font-black uppercase tracking-wider">
                    Mode Simulasi / Demo
                </span>
                <span class="text-xs text-slate-400 font-bold">Aplikasi Raport Digital Madrasah (RDM)</span>
            </div>
            <h2 class="text-lg font-black text-white uppercase tracking-tight">Konektor Sinkronisasi Nilai Raport ke RDM Kemenag</h2>
            <p class="text-xs text-slate-300 font-medium leading-relaxed mt-1">
                Fitur ini mensimulasikan proses transfer data nilai akhir dan predikat capaian kompetensi santri dari SIAS ke pangkalan data RDM Kemenag. Integrasi nyata secara langsung bergantung pada kelayakan dan ketersediaan akses endpoint API resmi Kemenag.
            </p>
        </div>
    </div>
</div>

<!-- Class & Semester Selection Bar -->
<div class="p-5 bg-white rounded-3xl border border-slate-100 shadow-xs mb-6">
    <form method="GET" action="{{ route('admin.rdm.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Pilih Rombel Kelas</label>
            <select name="kelas_id" onchange="this.form.submit()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ $selectedKelasId == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_lengkap }} ({{ $k->unit?->gender === 'putra' ? 'Putra' : 'Putri' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Pilih Semester</label>
            <select name="semester" onchange="this.form.submit()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                <option value="ganjil" {{ $semester === 'ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                <option value="genap" {{ $semester === 'genap' ? 'selected' : '' }}>Semester Genap</option>
            </select>
        </div>
        <div class="flex justify-end" x-data="{ syncing: false }">
            <form method="POST" action="{{ route('admin.rdm.sync') }}" @submit="syncing = true">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
                <input type="hidden" name="semester" value="{{ $semester }}">
                <button type="submit" :disabled="syncing" class="w-full sm:w-auto py-2.5 px-6 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 disabled:opacity-50">
                    <i class="fa-solid" :class="syncing ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                    <span x-text="syncing ? 'Mengirim ke Server RDM...' : 'Kirim Data ke RDM'"></span>
                </button>
            </form>
        </div>
    </form>
</div>

<!-- Preview Table Format RDM -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden mb-8">
    <div class="p-5 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="font-black text-slate-900 text-sm uppercase">Pratinjau Data Nilai (Format Standar RDM Kemenag)</h3>
            <span class="text-xs text-slate-400 font-medium">Kelas: {{ $selectedKelas?->nama_lengkap }} • Semester {{ ucfirst($semester) }}</span>
        </div>
        <span class="px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold font-mono">
            {{ $nilais->count() }} Data Siap Kirim
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4 font-mono">NISN</th>
                    <th class="py-3.5 px-4">Nama Siswa / Santri</th>
                    <th class="py-3.5 px-4">Mata Pelajaran</th>
                    <th class="py-3.5 px-4 text-center">KKM</th>
                    <th class="py-3.5 px-4 text-center">Pengetahuan (P)</th>
                    <th class="py-3.5 px-4 text-center">Keterampilan (K)</th>
                    <th class="py-3.5 px-4 text-center">Nilai Akhir</th>
                    <th class="py-3.5 px-4 text-center">Predikat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($nilais as $n)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-slate-700">
                            {{ $n->siswa?->siswa?->nisn ?: '008' . $n->siswa_id . '912' }}
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-900">
                            {{ $n->siswa?->name }}
                        </td>
                        <td class="py-3 px-4 text-slate-700 font-medium">
                            {{ $n->mapel?->nama_mapel }}
                        </td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-slate-500">
                            {{ $n->mapel?->kkm ?: 75 }}
                        </td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-slate-900">
                            {{ $n->nilai_pengetahuan ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-slate-900">
                            {{ $n->nilai_keterampilan ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-center font-mono font-black text-indigo-700">
                            {{ $n->nilai_akhir ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-center font-bold">
                            <span class="px-2 py-0.5 rounded text-[10px] font-black {{ ($n->nilai_akhir ?? 0) >= 80 ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $n->predikat }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400 italic">
                            Belum ada entri nilai raport yang terisi pada kelas dan semester ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Synchronization Logs -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
        <h3 class="font-black text-slate-900 text-sm uppercase">Log Histori Pengiriman ke RDM (Simulasi)</h3>
    </div>

    <div class="space-y-3">
        @forelse($logs as $log)
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start justify-between gap-3 text-xs">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $log->status === 'sukses' ? 'bg-emerald-100 text-emerald-700' : ($log->status === 'sebagian' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                            {{ strtoupper($log->status) }}
                        </span>
                        <span class="font-bold text-slate-800">{{ $log->kelas?->nama_lengkap }}</span>
                        <span class="text-slate-400 font-mono text-[11px]">({{ $log->jumlah_data }} butir nilai)</span>
                    </div>
                    <p class="text-slate-600">{{ $log->pesan }}</p>
                </div>
                <span class="text-[10px] text-slate-400 font-mono whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($log->waktu)->translatedFormat('d M Y H:i') }}
                </span>
            </div>
        @empty
            <div class="text-slate-400 italic text-xs py-4 text-center">Belum ada catatan log sinkronisasi.</div>
        @endforelse
    </div>
</div>
@endsection
