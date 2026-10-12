@extends('guru.layouts.app')

@section('title', 'Rumah Jurnal Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Rumah Jurnal Pendidik</h1>
            <p class="text-sm text-slate-500 mt-1">Repositori karya ilmiah, modul inovasi pembelajaran, dan riset tindakan kelas terpadu MA At-Taraqqie.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="document.getElementById('modal-upload-jurnal').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Karya Ilmiah
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Pencarian & Filter Kategori -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('guru.rumah-jurnal.index') }}" class="flex flex-col md:flex-row items-center gap-4">
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul artikel, topik inovasi, atau nama guru penulis..." class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-sm font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
            </div>

            <div class="w-full md:w-64">
                <select name="kategori" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                    <option value="">Semua Kategori Riset</option>
                    @foreach ($kategoris as $kat)
                        <option value="{{ $kat }}" {{ $kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 transition-all shadow-sm flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                @if ($q || $kategori)
                    <a href="{{ route('guru.rumah-jurnal.index') }}" class="px-4 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm transition-all flex items-center justify-center">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Grid Publikasi Jurnal -->
    @if ($jurnals->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($jurnals as $item)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $item->kategori }}
                            </span>
                            <span class="text-xs font-bold text-slate-400">
                                <i class="fa-regular fa-calendar-check mr-1"></i> {{ $item->tahun }}
                            </span>
                        </div>

                        <h3 class="font-black text-slate-900 text-base leading-snug group-hover:text-emerald-700 transition-colors">
                            {{ $item->judul }}
                        </h3>

                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mt-2 mb-4">
                            <i class="fa-solid fa-user-pen text-slate-400"></i>
                            <span>{{ $item->penulis }}</span>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-4 bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            {{ $item->abstrak }}
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Terverifikasi
                        </span>
                        <a href="javascript:void(0)" onclick="alert('Simulasi Dokumen: Modul PDF {{ addslashes($item->judul) }} dapat diunduh pada repositori digital madrasah.')" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 text-xs font-bold transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($jurnals->hasPages())
            <div class="mt-6">
                {{ $jurnals->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <h4 class="font-bold text-slate-800 text-base">Tidak Ada Publikasi Ditemukan</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Silakan ubah kata kunci pencarian atau kategori riset di atas.</p>
        </div>
    @endif

    <!-- Karya Ilmiah Guru Saya -->
    @if ($myJurnals->isNotEmpty())
        <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl mt-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-base">Karya Ilmiah Saya ({{ $myJurnals->count() }})</h3>
                        <p class="text-xs text-slate-400">Artikel dan modul yang telah Anda publikasikan ke Rumah Jurnal</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($myJurnals as $my)
                    <div class="bg-slate-800/80 rounded-2xl p-4 border border-slate-700">
                        <div class="flex items-center justify-between text-[11px] text-emerald-400 font-bold mb-1">
                            <span>{{ $my->kategori }}</span>
                            <span>Tahun {{ $my->tahun }}</span>
                        </div>
                        <h4 class="font-bold text-white text-sm line-clamp-2">{{ $my->judul }}</h4>
                        <p class="text-xs text-slate-400 mt-2 line-clamp-2">{{ $my->abstrak }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Modal Upload Jurnal -->
<div id="modal-upload-jurnal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full border border-slate-200 shadow-2xl relative">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
            <h3 class="font-black text-slate-900 text-lg flex items-center gap-2.5">
                <i class="fa-solid fa-cloud-arrow-up text-emerald-600"></i> Unggah Karya Ilmiah Guru
            </h3>
            <button onclick="document.getElementById('modal-upload-jurnal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('guru.rumah-jurnal.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Judul Karya Ilmiah / Artikel</label>
                <input type="text" name="judul" placeholder="Contoh: Implementasi Pembelajaran Fiqih Berbasis Saintifik..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kategori Bidang</label>
                    <select name="kategori" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tahun Terbit</label>
                    <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Abstrak / Ringkasan Eksekutif</label>
                <textarea name="abstrak" rows="4" placeholder="Uraikan latar belakang, metodologi, dan implikasi riset/modul..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all" required></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-upload-jurnal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-xs text-slate-600 transition-all">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
