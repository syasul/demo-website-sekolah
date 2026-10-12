@extends('layouts.orang_tua')

@section('title', 'Dashboard Wali Santri')

@section('content')
<div class="space-y-5">
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Salam & Header Santri Aktif -->
    <div class="bg-gradient-to-br from-emerald-800 via-teal-800 to-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-44 h-44 bg-emerald-400/10 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                @php
                    $gender = $selectedAnak->siswa?->jenis_kelamin ?? 'L';
                    $unitNama = $selectedAnak->siswa?->unit?->nama ?? ($selectedAnak->siswa?->kelas?->unit?->nama ?? 'MA');
                    $isPutra = str_contains(strtolower($unitNama), 'putra') || $gender === 'L';
                @endphp
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-black shadow-inner {{ $isPutra ? 'bg-sky-500/20 text-sky-300 border border-sky-400/30' : 'bg-purple-500/20 text-purple-300 border border-purple-400/30' }}">
                    {{ strtoupper(substr($selectedAnak->name, 0, 2)) }}
                </div>
                <div>
                    <div class="text-[11px] font-bold text-emerald-300 uppercase tracking-widest flex items-center gap-2">
                        <span>Santri Binaan</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span class="text-white">{{ $unitNama }}</span>
                    </div>
                    <h1 class="text-xl font-black tracking-tight text-white mt-0.5">{{ $selectedAnak->name }}</h1>
                    <p class="text-xs text-slate-300 mt-1">
                        {{ $selectedAnak->siswa?->kelas?->nama_lengkap ?? 'Kelas Aktif' }} • NIS: {{ $selectedAnak->siswa?->nis ?? '-' }} • NISN: {{ $selectedAnak->siswa?->nisn ?? '-' }}
                    </p>
                </div>
            </div>

            @if ($anaks->count() > 1)
                <div class="bg-white/10 p-3 rounded-2xl border border-white/10 backdrop-blur-sm">
                    <div class="text-[10px] text-slate-300 font-bold uppercase tracking-wider mb-2">Beralih Ananda:</div>
                    <div class="flex items-center gap-2">
                        @foreach ($anaks as $anak)
                            @if ($anak->id !== $selectedAnak->id)
                                <form method="POST" action="{{ route('orang-tua.switch-anak', $anak->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/20 hover:bg-white text-white hover:text-slate-900 text-xs font-bold transition-all flex items-center gap-1.5">
                                        <i class="fa-solid fa-arrows-rotate text-[10px]"></i>
                                        <span>{{ Str::words($anak->name, 2, '') }}</span>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Kehadiran Hari Ini -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div>
                    <h2 class="text-sm font-black text-slate-900">Kehadiran Hari Ini</h2>
                    <p class="text-[11px] text-slate-400">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
            <a href="{{ route('orang-tua.absensi.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                Lihat Rekap <i class="fa-solid fa-chevron-right text-[10px] ml-0.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
            <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                @if ($absenToday)
                    @php
                        $badgeClasses = match($absenToday->status) {
                            'hadir' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'izin'  => 'bg-amber-100 text-amber-800 border-amber-200',
                            'sakit' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'alpa'  => 'bg-rose-100 text-rose-800 border-rose-200',
                            default => 'bg-slate-100 text-slate-800 border-slate-200'
                        };
                        $iconClass = match($absenToday->status) {
                            'hadir' => 'fa-circle-check text-emerald-600',
                            'izin'  => 'fa-envelope-open-text text-amber-600',
                            'sakit' => 'fa-stethoscope text-blue-600',
                            'alpa'  => 'fa-circle-xmark text-rose-600',
                            default => 'fa-clock text-slate-600'
                        };
                    @endphp
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl">
                        <i class="fa-solid {{ $iconClass }}"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Presensi</div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-black uppercase tracking-wider border {{ $badgeClasses }} mt-0.5">
                            {{ $absenToday->status }}
                        </div>
                        @if ($absenToday->keterangan)
                            <div class="text-xs text-slate-500 mt-1 italic">"{{ $absenToday->keterangan }}"</div>
                        @endif
                    </div>
                @else
                    <div class="w-12 h-12 rounded-2xl bg-slate-200/70 text-slate-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Presensi</div>
                        <div class="text-xs font-bold text-slate-700 mt-0.5">Sedang Berlangsung / Belum Dipresensi</div>
                        <div class="text-[11px] text-slate-400">Guru kelas belum memfinalisasi sesi presensi hari ini</div>
                    </div>
                @endif
            </div>

            <div class="bg-emerald-50/60 p-4 rounded-2xl border border-emerald-100/80 flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Total Hadir Bulan Ini</div>
                    <div class="text-2xl font-black text-emerald-900 mt-0.5">{{ $totalHadirBulanIni }} Hari</div>
                    <div class="text-[11px] text-emerald-600 mt-0.5">Bulan {{ \Carbon\Carbon::today()->translatedFormat('F Y') }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats: Kedisiplinan & SPP -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Kartu Kedisiplinan & Poin Karakter -->
        <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-slate-900">Poin Kedisiplinan & Karakter</h2>
                            <p class="text-[11px] text-slate-400">Poin prestasi dapat menebus pelanggaran</p>
                        </div>
                    </div>
                    <a href="{{ route('orang-tua.poin.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700">
                        Detail <i class="fa-solid fa-chevron-right text-[10px] ml-0.5"></i>
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center mb-4">
                    <div class="bg-emerald-50 p-2.5 rounded-2xl border border-emerald-100">
                        <div class="text-[10px] font-bold text-emerald-600 uppercase">Prestasi (+)</div>
                        <div class="text-base font-black text-emerald-700 mt-0.5">+{{ $poinPlus }}</div>
                    </div>
                    <div class="bg-rose-50 p-2.5 rounded-2xl border border-rose-100">
                        <div class="text-[10px] font-bold text-rose-600 uppercase">Pelanggaran (-)</div>
                        <div class="text-base font-black text-rose-700 mt-0.5">-{{ $poinMinus }}</div>
                    </div>
                    <div class="bg-slate-900 p-2.5 rounded-2xl text-white">
                        <div class="text-[10px] font-bold text-emerald-400 uppercase">Net Karakter</div>
                        <div class="text-base font-black mt-0.5 {{ $netPoin >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $netPoin > 0 ? '+' : '' }}{{ $netPoin }}
                        </div>
                    </div>
                </div>

                @if ($recentPoins->isNotEmpty())
                    <div class="space-y-2">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Catatan Terbaru:</div>
                        @foreach ($recentPoins as $p)
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div class="truncate pr-2">
                                    <div class="font-bold text-slate-800 truncate">{{ $p->kategori?->nama ?? 'Catatan' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</div>
                                </div>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-black {{ $p->poin >= 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $p->poin > 0 ? '+' : '' }}{{ $p->poin }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 text-center text-xs text-slate-500">
                        Belum ada catatan pelanggaran atau prestasi khusus.
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('orang-tua.poin.index') }}" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-list-check"></i> Riwayat Kedisiplinan Lengkap
                </a>
            </div>
        </div>

        <!-- Kartu Tagihan SPP & Keuangan -->
        <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-slate-900">Administrasi SPP Santri</h2>
                            <p class="text-[11px] text-slate-400">Pencatatan dan riwayat pembayaran</p>
                        </div>
                    </div>
                    <a href="{{ route('orang-tua.tagihan.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700">
                        Histori <i class="fa-solid fa-chevron-right text-[10px] ml-0.5"></i>
                    </a>
                </div>

                @if ($latestTagihan)
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50/40 border border-amber-200/70 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Tagihan SPP: {{ $latestTagihan->periode }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $latestTagihan->status === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $latestTagihan->status === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
                            </span>
                        </div>
                        <div class="text-2xl font-black text-slate-900">
                            Rp {{ number_format($latestTagihan->nominal, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-500 mt-1">
                            Jatuh tempo: {{ \Carbon\Carbon::parse($latestTagihan->jatuh_tempo)->translatedFormat('d F Y') }}
                        </div>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 text-[11px] text-slate-500 leading-relaxed">
                        <i class="fa-solid fa-circle-info text-amber-600 mr-1"></i>
                        Pembayaran dapat diselesaikan langsung melalui bendahara madrasah. <i>(Fitur payment gateway daring dapat diintegrasikan pada tahap lanjutan).</i>
                    </div>
                @else
                    <div class="p-6 rounded-2xl bg-slate-50 text-center text-xs text-slate-500">
                        Tidak ada catatan tagihan SPP aktif saat ini.
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('orang-tua.tagihan.index') }}" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left"></i> Rincian Tagihan & Riwayat Bayar
                </a>
            </div>
        </div>
    </div>

    <!-- Snapshot Akademik & Raport Digital -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h2 class="text-sm font-black text-slate-900">Raport Digital & Nilai Santri</h2>
                    <p class="text-[11px] text-slate-400">Pantauan hasil belajar berkala santri</p>
                </div>
            </div>
            <a href="{{ route('orang-tua.raport.index') }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all flex items-center gap-1.5 shadow-xs">
                <i class="fa-solid fa-eye"></i> Buka Raport Lengkap
            </a>
        </div>

        @if ($recentNilais->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($recentNilais as $n)
                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 text-center">
                        <div class="text-[11px] font-bold text-slate-600 truncate mb-1">{{ $n->mapel?->nama ?? 'Mapel' }}</div>
                        <div class="text-xl font-black text-slate-900">{{ number_format($n->nilai_akhir, 0) }}</div>
                        <div class="text-[10px] font-bold text-emerald-600 mt-0.5">Predikat: {{ $n->predikat ?? 'B' }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-6 rounded-2xl bg-slate-50 text-center text-xs text-slate-500">
                Data nilai raport semester sedang dalam proses penginputan oleh dewan asatidz.
            </div>
        @endif
    </div>
</div>
@endsection
