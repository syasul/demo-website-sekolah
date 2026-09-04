@extends('layouts.admin')

@section('title', 'Tambah Kelas')
@section('page_title', 'Tambah Kelas Baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.kelas.index') }}" class="text-sm font-bold text-slate-500 hover:text-school-primary transition">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Daftar Kelas
    </a>
</div>

<div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100 max-w-3xl">
    <form action="{{ route('admin.kelas.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="tingkat" class="block text-sm font-bold text-slate-700 mb-2">Tingkat Kelas</label>
            <select name="tingkat" id="tingkat" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-school-primary focus:ring focus:ring-school-primary/20 transition-all outline-none" required>
                <option value="">-- Pilih Tingkat --</option>
                <option value="10" {{ old('tingkat') == '10' ? 'selected' : '' }}>10 (Sepuluh)</option>
                <option value="11" {{ old('tingkat') == '11' ? 'selected' : '' }}>11 (Sebelas)</option>
                <option value="12" {{ old('tingkat') == '12' ? 'selected' : '' }}>12 (Dua Belas)</option>
            </select>
            @error('tingkat')
                <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="nama_rombel" class="block text-sm font-bold text-slate-700 mb-2">Nama Rombel / Penjurusan</label>
            <input type="text" name="nama_rombel" id="nama_rombel" value="{{ old('nama_rombel') }}" placeholder="Contoh: A, B, IPA 1, IPS 2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-school-primary focus:ring focus:ring-school-primary/20 transition-all outline-none" required>
            <p class="mt-2 text-xs text-slate-400">Pastikan kombinasi Tingkat dan Nama Rombel tidak duplikat.</p>
            @error('nama_rombel')
                <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-8">
            <label for="wali_kelas_id" class="block text-sm font-bold text-slate-700 mb-2">Wali Kelas (Opsional)</label>
            <select name="wali_kelas_id" id="wali_kelas_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-school-primary focus:ring focus:ring-school-primary/20 transition-all outline-none">
                <option value="">-- Tidak Ada / Pilih Nanti --</option>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>{{ $guru->name }}</option>
                @endforeach
            </select>
            @error('wali_kelas_id')
                <p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4 border-t border-slate-100 pt-6">
            <button type="reset" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">Reset</button>
            <button type="submit" class="px-6 py-3 bg-school-primary text-white rounded-xl font-bold text-sm hover:bg-school-primary/90 transition shadow-lg shadow-school-primary/30">Simpan Kelas</button>
        </div>
    </form>
</div>
@endsection
