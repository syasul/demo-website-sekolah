@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran')
@section('page_title', 'Tambah Mata Pelajaran')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.mata-pelajaran.index') }}" class="text-sm font-bold text-slate-500 hover:text-school-primary transition">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Daftar Mapel
    </a>
</div>

<div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100 max-w-3xl">
    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="kode_mapel" class="block text-sm font-bold text-slate-700 mb-2">Kode Mapel</label>
            <input type="text" name="kode_mapel" id="kode_mapel" value="{{ old('kode_mapel') }}" placeholder="Contoh: MAT, IPA, BIND" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-school-primary focus:ring focus:ring-school-primary/20 transition-all outline-none font-mono" required>
            @error('kode_mapel')
                <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="nama_mapel" class="block text-sm font-bold text-slate-700 mb-2">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" id="nama_mapel" value="{{ old('nama_mapel') }}" placeholder="Contoh: Matematika Wajib" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-school-primary focus:ring focus:ring-school-primary/20 transition-all outline-none" required>
            @error('nama_mapel')
                <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-8">
            <label for="tingkat" class="block text-sm font-bold text-slate-700 mb-2">Tingkat (Opsional)</label>
            <select name="tingkat" id="tingkat" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-school-primary focus:ring focus:ring-school-primary/20 transition-all outline-none">
                <option value="">-- Berlaku Semua Tingkat --</option>
                <option value="10" {{ old('tingkat') == '10' ? 'selected' : '' }}>10 (Sepuluh)</option>
                <option value="11" {{ old('tingkat') == '11' ? 'selected' : '' }}>11 (Sebelas)</option>
                <option value="12" {{ old('tingkat') == '12' ? 'selected' : '' }}>12 (Dua Belas)</option>
            </select>
            <p class="mt-2 text-xs text-slate-400">Pilih jika mapel ini hanya diajarkan di tingkat tertentu.</p>
            @error('tingkat')
                <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4 border-t border-slate-100 pt-6">
            <button type="reset" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">Reset</button>
            <button type="submit" class="px-6 py-3 bg-school-primary text-white rounded-xl font-bold text-sm hover:bg-school-primary/90 transition shadow-lg shadow-school-primary/30">Simpan Mapel</button>
        </div>
    </form>
</div>
@endsection
