@extends('guru.layouts.app')

@section('title', 'Dashboard Guru')
@section('page_title', 'Dashboard Utama')

@section('content')
<div class="space-y-6 sm:space-y-8">
    <!-- ATTENDANCE GATE / ABSEN MASUK CARD -->
    @if(! $isAbsenToday)
        <div class="p-5 sm:p-6 bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl text-white shadow-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded bg-slate-900 text-amber-300 text-[10px] font-black uppercase tracking-wider">
                            Wajib Presensi
                        </span>
                        <span class="text-xs font-bold text-amber-100">{{ $namaHari }}, {{ date('d F Y') }}</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-black uppercase">Anda Belum Melakukan Absen Masuk Hari Ini</h3>
                    <p class="text-xs text-amber-100 font-medium mt-0.5">
                        Sesuai SOP MA Attaraqqie, menu <strong>Isi Jurnal Mengajar</strong> akan terkunci secara otomatis hingga Anda mencatatkan Absen Masuk.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('guru.absen-masuk') }}" class="w-full sm:w-auto shrink-0">
                @csrf
                <button type="submit" class="w-full sm:w-auto py-3 px-6 bg-slate-900 hover:bg-slate-800 text-amber-300 font-black text-xs uppercase tracking-wider rounded-2xl transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                    <span>Absen Masuk Sekarang</span>
                </button>
            </form>
        </div>
    @else
        <div class="p-4 sm:p-5 bg-emerald-50 border border-emerald-200 rounded-3xl text-emerald-900 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-xs font-black uppercase tracking-wider block text-emerald-800">
                        Presensi Hari Ini Terverifikasi
                    </span>
                    <span class="text-xs text-emerald-700 font-medium">
                        Anda telah melakukan Absen Masuk pada pukul <strong>{{ $absenToday->jam_masuk }}</strong>. Akses Jurnal Mengajar telah terbuka.
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-2 self-stretch sm:self-auto">
                <a href="{{ route('guru.jurnal.index') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-book-open text-xs"></i>
                    <span>Isi Jurnal Mengajar</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-school-primary rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10 border border-white/10">
        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Semester {{ ucfirst($currentSemester) }} TA {{ $currentTahun }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Selamat Datang, {{ $guru->name }}!</h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-xl">
                    Portal terpadu pengajaran, presensi santri, jurnal harian, dan penilaian raport digital MA Attaraqqie.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.absensi.siswa.index') }}" class="px-4 py-3 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-bold text-xs transition flex items-center gap-2 border border-white/10">
                    <i class="fa-solid fa-clipboard-user"></i>
                    <span>Presensi Santri</span>
                </a>
                <a href="{{ route('guru.raport.index') }}" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-bold text-xs shadow-lg shadow-emerald-500/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Input Raport</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-chalkboard"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelas Diampu</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalKelas }} <span class="text-xs font-medium text-slate-400">Rombel</span></h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mata Pelajaran</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalMapel }} <span class="text-xs font-medium text-slate-400">Mapel</span></h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Santri</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $totalSiswaDiajar }} <span class="text-xs font-medium text-slate-400">Santri</span></h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jurnal Hari Ini</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $jurnalTodayCount }} <span class="text-xs font-medium text-slate-400">Terisi</span></h3>
            </div>
        </div>
    </div>

    <!-- JADWAL MENGAJAR HARI INI & LABEL PUTRA / PUTRI -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-xs">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h3 class="font-black text-slate-900 text-sm uppercase">Jadwal Mengajar Hari Ini ({{ $namaHari }})</h3>
                    <p class="text-xs text-slate-400 font-medium">Dibedakan menurut segmentasi kelas Putra dan Putri</p>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-xl">
                    {{ $jadwalHariIni->count() }} Sesi
                </span>
            </div>

            <div class="space-y-3">
                @forelse($jadwalHariIni as $j)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $j->kelas?->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} flex items-center justify-center text-sm font-black shrink-0">
                                {{ $j->kelas?->unit?->gender === 'putra' ? 'PA' : 'PI' }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-black text-slate-900 text-xs">{{ $j->kelas?->nama_lengkap }}</span>
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $j->kelas?->unit?->gender === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $j->kelas?->unit?->gender === 'putra' ? 'MA Putra' : 'MA Putri' }}
                                    </span>
                                </div>
                                <span class="text-xs font-bold text-slate-600 block">{{ $j->mapel?->nama_mapel }}</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="text-xs font-mono font-bold text-slate-800 block">
                                {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                            </span>
                            <a href="{{ route('guru.absensi.siswa.index', ['kelas_id' => $j->kelas_id, 'mapel_id' => $j->mapel_id]) }}" class="text-[10px] font-bold text-school-primary hover:underline">
                                Absen Santri &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 italic text-xs">
                        Tidak ada jadwal mengajar pada hari {{ $namaHari }}. Anda dapat meninjau jadwal mingguan atau menyelesaikan administrasi penilaian.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Action Sidebar for Guru -->
        <div class="space-y-4">
            <div class="p-6 bg-slate-900 rounded-3xl text-white shadow-xl">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-1">Aksi Cepat Pengajar</span>
                <h3 class="text-sm font-black uppercase mb-4 text-white">Menu Favorit</h3>

                <div class="space-y-2.5">
                    @if($isAbsenToday)
                        <a href="{{ route('guru.jurnal.index') }}" class="flex items-center gap-3 p-3 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-300 rounded-2xl border border-emerald-500/20 transition-all">
                            <i class="fa-solid fa-book-open text-emerald-400"></i>
                            <div>
                                <span class="text-xs font-bold block">Tulis Jurnal Mengajar</span>
                                <span class="text-[10px] text-emerald-400/70">Akses terbuka</span>
                            </div>
                        </a>
                    @else
                        <div class="flex items-center gap-3 p-3 bg-white/5 text-slate-400 rounded-2xl border border-white/5 cursor-not-allowed opacity-60" title="Lakukan Absen Masuk terlebih dahulu">
                            <i class="fa-solid fa-lock text-rose-400"></i>
                            <div>
                                <span class="text-xs font-bold block text-slate-300">Jurnal Mengajar Terkunci</span>
                                <span class="text-[10px] text-rose-300">Wajib Absen Masuk dulu</span>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('guru.rumah-jurnal.index') }}" class="flex items-center gap-3 p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all text-white">
                        <i class="fa-solid fa-book-bookmark text-amber-400"></i>
                        <div>
                            <span class="text-xs font-bold block">Unggah ke Rumah Jurnal</span>
                            <span class="text-[10px] text-slate-400">Publikasi karya ilmiah</span>
                        </div>
                    </a>

                    <a href="{{ route('guru.evaluasi.index') }}" class="flex items-center gap-3 p-3 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all text-white">
                        <i class="fa-solid fa-award text-blue-400"></i>
                        <div>
                            <span class="text-xs font-bold block">Lihat Evaluasi Kinerja Diri</span>
                            <span class="text-[10px] text-slate-400">Skor 4 Kompetensi</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Pengisian Nilai Raport -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-black text-slate-900 text-base">Progress Pengisian Nilai Raport</h3>
                <p class="text-xs text-slate-400 mt-0.5">Pemantauan progres ketuntasan input nilai harian, PTS, PAS, dan catatan sikap santri</p>
            </div>
            <a href="{{ route('guru.raport.index') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 self-start sm:self-auto">
                <i class="fa-solid fa-file-pen text-emerald-400"></i> Kelola Raport
            </a>
        </div>

        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-black">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Status Kelengkapan Semester Aktif</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Seluruh rombel yang Anda ampu siap untuk penginputan nilai dan sikap santri.</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-36 bg-slate-200 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: 85%"></div>
                </div>
                <span class="text-xs font-black text-slate-700">85%</span>
            </div>
        </div>
    </div>
</div>
@endsection
