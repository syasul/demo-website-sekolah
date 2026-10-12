@extends('layouts.admin')

@section('title', 'Keuangan & SPP Santri')
@section('page_title', 'Manajemen SPP & Administrasi Keuangan')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Tagihan</span>
        <span class="text-xl font-black text-slate-900">{{ $stats['total_tagihan'] }} Item</span>
    </div>
    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-xs">
        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block">Lunas Terbayar</span>
        <span class="text-xl font-black text-emerald-700">Rp {{ number_format($stats['nominal_terkumpul'], 0, ',', '.') }}</span>
    </div>
    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 shadow-xs">
        <span class="text-[10px] font-bold text-rose-600 uppercase tracking-widest block">Sisa Tunggakan</span>
        <span class="text-xl font-black text-rose-700">Rp {{ number_format($stats['nominal_tunggakan'], 0, ',', '.') }}</span>
    </div>
    <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100 shadow-xs">
        <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest block">Rasio Pelunasan</span>
        @php
            $totalNominal = max(1, $stats['nominal_terkumpul'] + $stats['nominal_tunggakan']);
            $pctLunas = round(($stats['nominal_terkumpul'] / $totalNominal) * 100);
        @endphp
        <span class="text-xl font-black text-indigo-700">{{ $pctLunas }}%</span>
    </div>
</div>

<!-- Notice Note on Payment Gateway -->
<div class="mb-6 p-4 rounded-2xl bg-slate-900 text-white flex items-center justify-between text-xs">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-amber-400 shrink-0">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div>
            <span class="font-bold text-amber-400 block">Sistem Pembayaran: Pencatatan, Pengingat, & Histori</span>
            <span class="text-slate-300 text-[11px]">Pembayaran online otomatis (Payment Gateway seperti Midtrans/Xendit/QRIS) dapat dikembangkan pada tahap implementasi lanjutan sesuai kesepakatan yayasan.</span>
        </div>
    </div>
</div>

<!-- Generate Massal Card & Search -->
<div class="p-5 bg-white rounded-3xl border border-slate-100 shadow-xs mb-6" x-data="{ showGenerate: false }">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-black text-slate-900 text-sm uppercase">Daftar Tagihan SPP Santri</h3>
            <p class="text-xs text-slate-400 font-medium">Monitoring status pembayaran dan kirim pengingat ke akun Orang Tua.</p>
        </div>
        <button type="button" @click="showGenerate = !showGenerate" class="py-2 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Generate Tagihan Massal</span>
        </button>
    </div>

    <!-- Collapsible Form Generate Massal -->
    <div x-show="showGenerate" x-cloak class="mt-5 pt-5 border-t border-slate-100">
        <form method="POST" action="{{ route('admin.keuangan.generate') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            @csrf
            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Pilih Rombel / Kelas</label>
                <select name="kelas_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_lengkap }} ({{ $k->unit?->gender === 'putra' ? 'Putra' : 'Putri' }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Periode Tagihan</label>
                <input type="text" name="periode" value="November 2026" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
            </div>
            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Nominal (Rp)</label>
                <input type="number" name="nominal" value="450000" step="10000" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
            </div>
            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" value="{{ date('Y-m-10', strtotime('+1 month')) }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
            </div>
            <div class="sm:col-span-4 flex justify-end">
                <button type="submit" class="py-2.5 px-5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all">
                    Proses Generate Tagihan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Table Data -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider">
                    <th class="py-3.5 px-4">Nama Santri</th>
                    <th class="py-3.5 px-4">Rombel & Unit</th>
                    <th class="py-3.5 px-4">Periode</th>
                    <th class="py-3.5 px-4">Nominal</th>
                    <th class="py-3.5 px-4">Jatuh Tempo</th>
                    <th class="py-3.5 px-4">Status</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tagihans as $t)
                    <tr class="hover:bg-slate-50/60 transition-colors" x-data="{ openBayar: false }">
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $t->siswa?->name }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">NIS: {{ $t->siswaProfile?->nis ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-800 block">{{ $t->siswaProfile?->kelas?->nama_lengkap }}</span>
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $t->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $t->unit?->gender === 'putra' ? 'MA Putra' : 'MA Putri' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-700">
                            {{ $t->periode }}
                        </td>
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                            Rp {{ number_format($t->nominal, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 font-medium whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($t->jatuh_tempo)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase {{ $t->status === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ strtoupper($t->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                @if($t->status !== 'lunas')
                                    <!-- Catat Bayar Button -->
                                    <button type="button" @click="openBayar = !openBayar" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition-all">
                                        <i class="fa-solid fa-cash-register mr-1"></i> Bayar
                                    </button>

                                    <!-- Kirim Pengingat Button -->
                                    <form method="POST" action="{{ route('admin.keuangan.ingatkan', $t) }}">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-bold transition-all" title="Kirim notifikasi ke Orang Tua">
                                            <i class="fa-solid fa-bell mr-1"></i> Ingatkan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-emerald-600 font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Lunas</span>
                                    </span>
                                @endif
                            </div>

                            <!-- Popover Catat Pembayaran -->
                            <div x-show="openBayar" @click.away="openBayar = false" x-cloak class="mt-2 p-3 bg-white border border-slate-200 rounded-xl shadow-xl text-left">
                                <form method="POST" action="{{ route('admin.keuangan.bayar', $t) }}" class="space-y-2">
                                    @csrf
                                    <div>
                                        <label class="text-[9px] font-bold text-slate-400 uppercase">Nominal</label>
                                        <input type="number" name="nominal" value="{{ $t->sisa_tagihan }}" class="w-full px-2 py-1 border rounded text-xs font-bold">
                                    </div>
                                    <div>
                                        <label class="text-[9px] font-bold text-slate-400 uppercase">Metode</label>
                                        <select name="metode" class="w-full px-2 py-1 border rounded text-xs">
                                            <option value="Tunai / Kasir TU">Tunai / Kasir TU</option>
                                            <option value="Transfer Bank BSI">Transfer Bank BSI</option>
                                            <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                                    <button type="submit" class="w-full py-1 bg-slate-900 text-white rounded text-xs font-bold">Simpan Pembayaran</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 italic">
                            Belum ada tagihan SPP santri pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tagihans->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $tagihans->links() }}
        </div>
    @endif
</div>
@endsection
