@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')
@section('page_title', 'Mata Pelajaran')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali ke Daftar Mapel</span>
        </a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="pb-5 mb-6 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-900">Perbarui Mata Pelajaran</h2>
            <p class="text-xs text-slate-500 mt-0.5">Ubah rincian kode, nama, atau tingkatan rombel mata pelajaran.</p>
        </div>

        <form action="{{ route('admin.mata-pelajaran.update', $mataPelajaran) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label for="kode_mapel" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Mapel <span class="text-rose-500">*</span></label>
                <input type="text" name="kode_mapel" id="kode_mapel" value="{{ old('kode_mapel', $mataPelajaran->kode_mapel) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs font-mono font-bold text-slate-800 focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-all outline-none" required>
                @error('kode_mapel')
                    <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_mapel" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Mata Pelajaran <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_mapel" id="nama_mapel" value="{{ old('nama_mapel', $mataPelajaran->nama_mapel) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs font-semibold text-slate-800 focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-all outline-none" required>
                @error('nama_mapel')
                    <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tingkat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alokasi Tingkat</label>
                <select name="tingkat" id="tingkat" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs font-semibold text-slate-800 focus:bg-white focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-all outline-none">
                    <option value="">-- Berlaku Semua Tingkat --</option>
                    <option value="10" {{ old('tingkat', $mataPelajaran->tingkat) == '10' ? 'selected' : '' }}>Tingkat 10 (Sepuluh)</option>
                    <option value="11" {{ old('tingkat', $mataPelajaran->tingkat) == '11' ? 'selected' : '' }}>Tingkat 11 (Sebelas)</option>
                    <option value="12" {{ old('tingkat', $mataPelajaran->tingkat) == '12' ? 'selected' : '' }}>Tingkat 12 (Dua Belas)</option>
                </select>
                <p class="mt-1.5 text-[11px] text-slate-400">Pilih jika mata pelajaran ini hanya diajarkan di jenjang kelas tertentu.</p>
                @error('tingkat')
                    <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                <a href="{{ route('admin.mata-pelajaran.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-xs transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-semibold text-xs shadow-xs transition-colors">Perbarui Mata Pelajaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
