@extends('layouts.client')

@section('title', 'Cek Status Pendaftaran PPDB — MA At-Taraqqie')

@section('content')
<!-- Header Banner -->
<section class="py-14 sm:py-20 bg-school-primary text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-slate-900/10 -z-0"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full border border-white/10 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-accent">
            Verifikasi Calon Peserta Didik
        </div>
        <h1 class="text-3xl sm:text-5xl font-black mb-3 italic uppercase tracking-tighter">Cek Status PPDB Online</h1>
        <p class="text-xs sm:text-sm text-white/80 max-w-xl mx-auto leading-relaxed">Masukkan Nomor Registrasi (PPDB-YYYY-XXXX) atau Nomor WhatsApp yang didaftarkan.</p>
    </div>
</section>

<!-- Search Form & Status Result -->
<section class="py-12 sm:py-16 max-w-4xl mx-auto px-4 sm:px-6">
    <div class="bg-white rounded-3xl sm:rounded-[36px] border border-slate-200/80 shadow-xl p-6 sm:p-10 -mt-16 sm:-mt-20 relative z-20">
        <form method="GET" action="{{ route('ppdb.status') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="keyword" value="{{ $keyword }}" required placeholder="Contoh: PPDB-2025-0001 atau 081234567890"
                    class="w-full pl-11 pr-4 py-3.5 text-sm rounded-2xl border border-slate-300 focus:border-school-primary focus:ring-school-primary bg-slate-50/50">
            </div>
            <button type="submit" class="px-8 py-3.5 bg-school-primary text-white font-bold text-sm rounded-2xl hover:opacity-95 transition-all shadow-md shrink-0">
                Lacak Status
            </button>
        </form>

        @if (!empty($keyword))
            <div class="mt-8 pt-8 border-t border-slate-100">
                @if ($pendaftar)
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200">
                            <div>
                                <span class="text-xs font-bold text-slate-400 block uppercase">Nomor Registrasi</span>
                                <span class="text-lg font-mono font-black text-slate-900">{{ $pendaftar->nomor_pendaftaran }}</span>
                            </div>
                            <div>
                                @if ($pendaftar->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-100 text-amber-800 text-xs font-black">
                                        <i class="fa-solid fa-clock"></i> SEDANG DALAM PROSES VERIFIKASI
                                    </span>
                                @elseif ($pendaftar->status === 'diterima')
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black">
                                        <i class="fa-solid fa-circle-check"></i> SELAMAT, ANDA DINYATAKAN DITERIMA!
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-rose-100 text-rose-800 text-xs font-black">
                                        <i class="fa-solid fa-circle-xmark"></i> MOHON MAAF, BELUM MEMENUHI SYARAT
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                            <div>
                                <span class="text-slate-400 block text-xs">Nama Calon Siswa:</span>
                                <strong class="text-slate-900 font-bold text-base">{{ $pendaftar->nama_lengkap }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-xs">Asal Sekolah:</span>
                                <span class="text-slate-700 font-semibold">{{ $pendaftar->asal_sekolah ?: '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-xs">Tanggal Pengajuan:</span>
                                <span class="text-slate-700">{{ $pendaftar->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-xs">Nomor Kontak Terdaftar:</span>
                                <span class="text-slate-700 font-mono">{{ $pendaftar->no_hp }}</span>
                            </div>
                        </div>

                        @if ($pendaftar->catatan_admin)
                            <div class="p-4 rounded-2xl bg-white border border-slate-200 mt-2">
                                <span class="text-xs font-bold text-slate-800 block mb-1">Catatan Panitia PPDB:</span>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $pendaftar->catatan_admin }}</p>
                            </div>
                        @endif

                        @if ($pendaftar->status === 'diterima')
                            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs leading-relaxed">
                                <strong class="block mb-1 font-bold">Langkah Selanjutnya:</strong>
                                Silakan melakukan proses daftar ulang langsung ke Sekretariat PPDB MA At-Taraqqie Malang atau menunggu instruksi aktivasi akun siswa dari panitia.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="py-8 text-center text-slate-400">
                        <i class="fa-solid fa-magnifying-glass-chart text-4xl mb-3 text-slate-300 block"></i>
                        <p class="text-sm font-semibold text-slate-700">Data pendaftaran tidak ditemukan</p>
                        <p class="text-xs text-slate-400 mt-1">Pastikan Anda memasukkan nomor registrasi yang tepat (misal: PPDB-2025-0001) atau nomor WhatsApp yang aktif saat mendaftar.</p>
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="/ppdb" class="text-xs font-bold text-school-primary hover:underline inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Halaman Pendaftaran PPDB</span>
            </a>
        </div>
    </div>
</section>
@endsection
