@extends('layouts.admin')

@section('title', 'Form Penilaian Kinerja Guru')
@section('page_title', 'Penilaian Kinerja Pendidik')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h3 class="text-base font-black text-slate-900 uppercase">Instrumen Penilaian Kinerja Guru (PKG)</h3>
            <p class="text-xs text-slate-500 font-medium">Berdasarkan 4 kompetensi guru: Pedagogik, Profesional, Kepribadian, dan Sosial.</p>
        </div>
        <a href="{{ route('admin.evaluasi.index') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Teacher Selection Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-6 mb-6">
        <form method="GET" action="{{ route('admin.evaluasi.create') }}">
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Pilih Guru yang Dinilai</label>
            <div class="flex gap-3">
                <select name="guru_id" onchange="this.form.submit()" class="flex-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                    <option value="">-- Pilih Guru / Asatidz --</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}" {{ $selectedGuru && $selectedGuru->id == $g->id ? 'selected' : '' }}>
                            {{ $g->name }} ({{ $g->email }})
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if($selectedGuru)
        <!-- Auto Metrics Card -->
        @if($autoMetrics)
        <div class="mb-6 p-5 bg-indigo-50/70 border border-indigo-100 rounded-3xl grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-indigo-900/60 uppercase tracking-wider block">Data Kehadiran Otomatis</span>
                    <span class="text-sm font-black text-indigo-950">{{ $autoMetrics['kehadiran_persen'] }}% Tingkat Kehadiran</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-indigo-900/60 uppercase tracking-wider block">Kelengkapan Jurnal</span>
                    <span class="text-sm font-black text-indigo-950">{{ $autoMetrics['total_jurnal'] }} Sesi Jurnal Mengajar</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Evaluation Form -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-6 sm:p-8">
            <form method="POST" action="{{ route('admin.evaluasi.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="guru_id" value="{{ $selectedGuru->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Tahun Ajaran</label>
                        <input type="text" name="periode_tahun" value="2024/2025" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Semester</label>
                        <select name="semester" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                            <option value="ganjil">Semester Ganjil</option>
                            <option value="genap">Semester Genap</option>
                        </select>
                    </div>
                </div>

                <!-- 4 Competencies Scores -->
                <div class="space-y-4 pt-2">
                    <h4 class="font-black text-slate-900 text-sm uppercase">Skor Nilai 4 Pilar Kompetensi (Skala 0 - 100)</h4>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-xs font-bold text-slate-800">1. Kompetensi Pedagogik (Bobot 25%)</label>
                            <span class="text-xs font-bold text-slate-400">Desain ajar & diferensiasi santri</span>
                        </div>
                        <input type="number" step="0.5" min="0" max="100" name="skor_pedagogik" value="88.0" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-900">
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-xs font-bold text-slate-800">2. Kompetensi Profesional (Bobot 25%)</label>
                            <span class="text-xs font-bold text-slate-400">Penguasaan materi & integrasi turats</span>
                        </div>
                        <input type="number" step="0.5" min="0" max="100" name="skor_profesional" value="87.5" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-900">
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-xs font-bold text-slate-800">3. Kompetensi Kepribadian (Bobot 25%)</label>
                            <span class="text-xs font-bold text-slate-400">Akhlakul karimah & keteladanan asrama</span>
                        </div>
                        <input type="number" step="0.5" min="0" max="100" name="skor_kepribadian" value="92.0" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-900">
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-xs font-bold text-slate-800">4. Kompetensi Sosial (Bobot 25%)</label>
                            <span class="text-xs font-bold text-slate-400">Komunikasi wali murid & dewan guru</span>
                        </div>
                        <input type="number" step="0.5" min="0" max="100" name="skor_sosial" value="90.0" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-900">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Catatan & Rekomendasi Kepala Madrasah</label>
                    <textarea name="catatan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary" placeholder="Tuliskan apresiasi, saran pengembangan keprofesian, dan tindak lanjut..."></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider rounded-2xl transition-all shadow-md">
                        Simpan & Finalisasi Evaluasi
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
