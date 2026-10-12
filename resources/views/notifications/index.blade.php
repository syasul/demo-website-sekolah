@php
    $user = auth()->user();
    $layout = 'layouts.admin';
    if ($user->isGuru()) {
        $layout = 'guru.layouts.app';
    } elseif ($user->isOrangTua()) {
        $layout = 'layouts.orang_tua';
    }
@endphp

@extends($layout)

@section('title', 'Notifikasi Sistem')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Pusat Notifikasi</h1>
            <p class="text-sm text-slate-500 mt-1">Pemberitahuan resmi absensi, kedisiplinan, tagihan SPP, dan agenda madrasah.</p>
        </div>
        @if ($unreadCount > 0)
            <div>
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-check-double text-emerald-400"></i> Tandai Semua Dibaca
                    </button>
                </form>
            </div>
        @endif
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Daftar Notifikasi -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-bell text-emerald-600 text-base"></i>
                <h3 class="font-black text-slate-800 text-base">Pemberitahuan Masuk</h3>
            </div>
            @if ($unreadCount > 0)
                <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-700 border border-rose-200">
                    {{ $unreadCount }} Belum Dibaca
                </span>
            @else
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                    Semua Telah Dibaca
                </span>
            @endif
        </div>

        @if ($notifikasis->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach ($notifikasis as $notif)
                    @php
                        $isUnread = is_null($notif->dibaca_at);
                        $typeIcon = match($notif->tipe) {
                            'absen' => 'fa-clipboard-user text-sky-600 bg-sky-100',
                            'poin'  => 'fa-shield-halved text-rose-600 bg-rose-100',
                            'spp'   => 'fa-receipt text-amber-600 bg-amber-100',
                            default => 'fa-bell text-emerald-600 bg-emerald-100'
                        };
                    @endphp
                    <div class="p-5 sm:p-6 transition-colors {{ $isUnread ? 'bg-emerald-50/30 hover:bg-emerald-50/50' : 'hover:bg-slate-50/80' }} flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-2xl flex items-center justify-center text-lg flex-shrink-0 {{ explode(' ', $typeIcon)[2] }} {{ explode(' ', $typeIcon)[1] }}">
                                <i class="fa-solid {{ explode(' ', $typeIcon)[0] }}"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-slate-900 text-sm {{ $isUnread ? 'font-black text-emerald-950' : '' }}">
                                        {{ $notif->judul }}
                                    </h4>
                                    @if ($isUnread)
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed max-w-2xl">
                                    {{ $notif->isi }}
                                </p>
                                <div class="text-[11px] text-slate-400 mt-2 flex items-center gap-3">
                                    <span><i class="fa-regular fa-clock mr-1"></i> {{ $notif->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <span>Tipe: {{ strtoupper($notif->tipe) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if ($isUnread)
                                <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs transition-colors flex items-center gap-1.5 shadow-xs">
                                        <i class="fa-solid fa-check"></i>
                                        <span class="hidden sm:inline">Buka & Baca</span>
                                    </button>
                                </form>
                            @elseif ($notif->link)
                                <a href="{{ $notif->link }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                                    Buka Link
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($notifikasis->hasPages())
                <div class="p-6 border-t border-slate-100">
                    {{ $notifikasis->links() }}
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-bell-slash"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base">Kotak Notifikasi Kosong</h4>
                <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                    Belum ada pemberitahuan baru yang dikirimkan ke akun Anda.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
