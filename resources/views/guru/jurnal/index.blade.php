@extends('guru.layouts.app')

@section('title', 'Jurnal Mengajar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Jurnal Mengajar</h1>
            <p class="text-sm text-slate-500 mt-1">Dokumentasi materi, kehadiran, dan aktivitas pembelajaran harian guru.</p>
        </div>
        <div class="flex items-center gap-3">
            @if ($isAbsenToday)
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <i class="fa-solid fa-lock-open text-emerald-500"></i> Gate Aktif (Tervalidasi Hadir)
                </span>
            @else
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                    <i class="fa-solid fa-lock text-rose-500"></i> Gate Terkunci (Belum Absen Masuk)
                </span>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- GATE ALERT JIKA BELUM ABSEN MASUK HARI INI -->
    @if (! $isAbsenToday)
        <div class="bg-gradient-to-r from-rose-500 to-amber-600 rounded-3xl p-6 text-white shadow-lg shadow-rose-900/10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-2xl flex-shrink-0">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black tracking-tight">Perhatian: Wajib Absensi Guru Sebelum Mengisi Jurnal</h3>
                    <p class="text-sm text-rose-100 mt-1 max-w-2xl leading-relaxed">
                        Sesuai SOP Kedisiplinan Terpadu MA At-Taraqqie, formulir Jurnal Mengajar dinonaktifkan sementara hingga Anda melakukan <b>Absen Masuk (Check-In)</b> hari ini. Ini memastikan validitas kehadiran riil di madrasah sebelum pelaksanaan KBM.
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white text-rose-700 hover:bg-rose-50 font-black text-sm shadow-md transition-all whitespace-nowrap">
                    <i class="fa-solid fa-fingerprint"></i> Ke Dashboard & Absen Masuk
                </a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Input Jurnal (Disabled jika belum absen) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm relative overflow-hidden {{ ! $isAbsenToday ? 'opacity-60 pointer-events-none select-none' : '' }}">
                @if (! $isAbsenToday)
                    <div class="absolute inset-0 bg-slate-100/50 backdrop-blur-[1px] z-10 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl mb-3 shadow-inner">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div class="font-black text-slate-800 text-sm">Form Terkunci</div>
                        <div class="text-xs text-slate-500 mt-1">Lakukan Absen Masuk di Dashboard terlebih dahulu</div>
                    </div>
                @endif

                <h3 class="font-black text-slate-800 text-base mb-4 flex items-center gap-2.5">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Input Jurnal KBM
                </h3>

                <form method="POST" action="{{ route('guru.jurnal.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Rombel / Kelas</label>
                        <select name="kelas_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasList as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_lengkap }} ({{ $k->unit ? $k->unit->nama : 'Umum' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Mata Pelajaran</label>
                        <select name="mapel_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($mapelList as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $today->toDateString() }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Ke</label>
                            <input type="text" name="jam_ke" placeholder="Contoh: 1 - 2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Materi Pembelajaran / KD</label>
                        <textarea name="materi" rows="3" placeholder="Uraian materi pokok atau KD yang diajarkan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Catatan KBM / Refleksi</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan dinamika kelas, kendala, atau penugasan (opsional)..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-2xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 shadow-lg shadow-emerald-900/10 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Simpan Jurnal Mengajar
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Riwayat Jurnal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-slate-800 text-base">Riwayat Jurnal Mengajar</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar jurnal KBM yang telah Anda inputkan</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                        Total: {{ $jurnals->total() }} Sesi
                    </span>
                </div>

                @if ($jurnals->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-black uppercase tracking-wider text-slate-500">
                                    <th class="py-4 px-6">Tanggal & Jam</th>
                                    <th class="py-4 px-6">Kelas & Unit</th>
                                    <th class="py-4 px-6">Mata Pelajaran</th>
                                    <th class="py-4 px-6">Materi & Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach ($jurnals as $jurnal)
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d M Y') }}</div>
                                            <div class="text-xs text-slate-400 mt-0.5">Jam ke: {{ $jurnal->jam_ke ?? '-' }}</div>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="font-bold text-slate-800">{{ $jurnal->kelas?->nama_lengkap ?? '-' }}</div>
                                            @if ($jurnal->kelas?->unit)
                                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold {{ $jurnal->kelas->unit->gender === 'putra' ? 'bg-sky-100 text-sky-700' : 'bg-purple-100 text-purple-700' }}">
                                                    {{ $jurnal->kelas->unit->nama }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="font-bold text-slate-700 text-xs px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200">
                                                {{ $jurnal->mapel?->nama ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-semibold text-slate-900 leading-snug">{{ $jurnal->materi }}</div>
                                            @if ($jurnal->catatan)
                                                <div class="text-xs text-slate-500 mt-1 italic bg-slate-50 p-2 rounded-lg border border-slate-100">
                                                    "{{ $jurnal->catatan }}"
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($jurnals->hasPages())
                        <div class="p-6 border-t border-slate-100">
                            {{ $jurnals->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-4">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <h4 class="font-bold text-slate-800 text-base">Belum Ada Riwayat Jurnal</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            Silakan lakukan Absen Masuk dan isi formulir jurnal di samping kiri setelah Anda mengajar.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
