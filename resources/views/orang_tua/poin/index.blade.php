@extends('layouts.orang_tua')

@section('title', 'Kedisiplinan & Karakter Santri')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Kedisiplinan & Karakter</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantauan perilaku, kedisiplinan, dan poin prestasi {{ $selectedAnak->name }}</p>
        </div>
        <a href="{{ route('orang-tua.dashboard') }}" class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <!-- Ringkasan Poin Karakter & Konsep Tebus Poin -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-xl">
        <div class="grid grid-cols-3 gap-3 text-center pb-5 border-b border-white/10">
            <div class="bg-emerald-500/10 p-3 rounded-2xl border border-emerald-500/20">
                <div class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Poin Prestasi</div>
                <div class="text-2xl font-black text-emerald-300 mt-1">+{{ $poinPlus }}</div>
            </div>
            <div class="bg-rose-500/10 p-3 rounded-2xl border border-rose-500/20">
                <div class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Poin Pelanggaran</div>
                <div class="text-2xl font-black text-rose-300 mt-1">-{{ $poinMinus }}</div>
            </div>
            <div class="bg-white/10 p-3 rounded-2xl border border-white/10">
                <div class="text-[10px] font-bold text-sky-300 uppercase tracking-wider">Net Karakter</div>
                <div class="text-2xl font-black mt-1 {{ $netPoin >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $netPoin > 0 ? '+' : '' }}{{ $netPoin }}
                </div>
            </div>
        </div>

        <div class="mt-4 flex items-start gap-3 bg-white/5 p-3.5 rounded-2xl border border-white/5 text-xs text-slate-300 leading-relaxed">
            <i class="fa-solid fa-scale-balanced text-emerald-400 text-sm mt-0.5"></i>
            <div>
                <span class="font-bold text-white">Sistem Tebus Poin Terpadu:</span>
                Poin pelanggaran dapat dinetralkan dan ditebus kembali melalui capaian hafalan Al-Qur'an (Tahfidz), prestasi lomba, keaktifan organisasi, dan keteladanan akhlak.
            </div>
        </div>
    </div>

    <!-- Timeline Catatan Poin Santri -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-black text-slate-900">Riwayat Catatan Karakter</h2>
            <span class="text-xs font-bold text-slate-400">Total: {{ $poins->total() }} Kejadian</span>
        </div>

        @if ($poins->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach ($poins as $poin)
                    @php
                        $isPositive = $poin->poin >= 0;
                    @endphp
                    <div class="p-4 sm:p-5 hover:bg-slate-50/70 transition-colors flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5 {{ $isPositive ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                <i class="fa-solid {{ $isPositive ? 'fa-award' : 'fa-triangle-exclamation' }}"></i>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">
                                    {{ $poin->kategori?->nama ?? 'Catatan Karakter' }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($poin->tanggal)->translatedFormat('l, d F Y') }} • Dicatat oleh: {{ $poin->pencatat?->name ?? 'Guru / BK' }}
                                </div>
                                @if ($poin->catatan)
                                    <div class="text-xs text-slate-600 mt-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                        "{{ $poin->catatan }}"
                                    </div>
                                @endif
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-black flex-shrink-0 {{ $isPositive ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                            {{ $poin->poin > 0 ? '+' : '' }}{{ $poin->poin }} Poin
                        </span>
                    </div>
                @endforeach
            </div>

            @if ($poins->hasPages())
                <div class="p-5 border-t border-slate-100">
                    {{ $poins->links() }}
                </div>
            @endif
        @else
            <div class="p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-sm">Belum Ada Catatan Poin</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                    Alhamdulillah, santri memiliki rekam jejak kedisiplinan yang bersih tanpa catatan pelanggaran.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
