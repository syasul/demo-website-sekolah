@extends('layouts.orang_tua')

@section('title', 'Keuangan & SPP Santri')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Administrasi SPP</h1>
            <p class="text-xs text-slate-500 mt-0.5">Catatan tagihan dan riwayat pembayaran {{ $selectedAnak->name }}</p>
        </div>
        <a href="{{ route('orang-tua.dashboard') }}" class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <!-- Ringkasan Keuangan SPP -->
    <div class="bg-gradient-to-br from-amber-700 via-amber-800 to-slate-900 rounded-3xl p-6 text-white shadow-xl">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-center pb-5 border-b border-white/10">
            <div class="bg-white/10 p-3 rounded-2xl backdrop-blur-xs">
                <div class="text-[10px] font-bold text-amber-200 uppercase tracking-wider">Total Tagihan</div>
                <div class="text-xl sm:text-2xl font-black mt-1">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
            </div>
            <div class="bg-emerald-500/20 p-3 rounded-2xl border border-emerald-400/30">
                <div class="text-[10px] font-bold text-emerald-300 uppercase tracking-wider">Sudah Terbayar</div>
                <div class="text-xl sm:text-2xl font-black text-emerald-300 mt-1">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
            </div>
            <div class="bg-rose-500/20 p-3 rounded-2xl border border-rose-400/30">
                <div class="text-[10px] font-bold text-rose-300 uppercase tracking-wider">Sisa Tunggakan</div>
                <div class="text-xl sm:text-2xl font-black text-rose-300 mt-1">Rp {{ number_format($sisaTunggakan, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="mt-4 flex items-start gap-3 bg-white/5 p-3.5 rounded-2xl border border-white/5 text-xs text-amber-100 leading-relaxed">
            <i class="fa-solid fa-circle-info text-amber-300 text-sm mt-0.5"></i>
            <div>
                <span class="font-bold text-white">Catatan Administrasi:</span>
                Pembayaran SPP dapat dilakukan langsung ke loket keuangan madrasah atau melalui transfer rekening resmi. <i>(Fitur pembayaran online payment gateway dapat dikembangkan pada tahap lanjutan).</i>
            </div>
        </div>
    </div>

    <!-- Daftar Tagihan & Pembayaran -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-black text-slate-900">Daftar Tagihan & Riwayat Pembayaran</h2>
            <span class="text-xs font-bold text-slate-400">Total: {{ $tagihans->total() }} Periode</span>
        </div>

        @if ($tagihans->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach ($tagihans as $tagihan)
                    @php
                        $isLunas = $tagihan->status === 'lunas';
                    @endphp
                    <div class="p-4 sm:p-5 hover:bg-slate-50/70 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-sm font-bold flex-shrink-0 {{ $isLunas ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    <i class="fa-solid {{ $isLunas ? 'fa-check-double' : 'fa-hourglass-start' }}"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">
                                        SPP {{ $tagihan->periode }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        Jatuh tempo: {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->translatedFormat('d F Y') }}
                                    </div>
                                    <div class="text-sm font-black text-slate-800 mt-1">
                                        Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider border {{ $isLunas ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-rose-100 text-rose-800 border-rose-200' }}">
                                    {{ $isLunas ? 'LUNAS' : 'BELUM LUNAS' }}
                                </span>
                            </div>
                        </div>

                        <!-- Riwayat Pembayaran pada Tagihan ini -->
                        @if ($tagihan->pembayarans->isNotEmpty())
                            <div class="mt-3.5 pt-3 border-t border-slate-100 bg-slate-50/80 p-3 rounded-2xl text-xs space-y-1.5">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Histori Transaksi Pembayaran:</div>
                                @foreach ($tagihan->pembayarans as $bayar)
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>
                                            <i class="fa-solid fa-receipt text-emerald-600 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($bayar->tanggal)->translatedFormat('d M Y') }} • Metode: {{ ucfirst($bayar->metode ?? 'Tunai') }}
                                        </span>
                                        <span class="font-bold text-slate-800">
                                            Rp {{ number_format($bayar->nominal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($tagihans->hasPages())
                <div class="p-5 border-t border-slate-100">
                    {{ $tagihans->links() }}
                </div>
            @endif
        @else
            <div class="p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">Belum Ada Tagihan SPP</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                    Data tagihan SPP ananda belum diterbitkan oleh bagian tata usaha.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
