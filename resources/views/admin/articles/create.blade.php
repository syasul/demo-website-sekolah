@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')
@section('page_title', 'Buat Artikel')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.articles.index') }}" class="text-[10px] font-black uppercase text-slate-400 hover:text-slate-900 transition-colors flex items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    @csrf
    
    <div class="lg:col-span-2 space-y-8">
        <div class="p-10 bg-white rounded-[40px] shadow-sm border border-slate-100 space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all font-bold text-slate-900"
                    placeholder="Masukkan judul berita yang menarik...">
                @error('title') <p class="text-rose-500 text-[10px] font-bold mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Konten Berita</label>
                <textarea name="content" id="editor" rows="15" required
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all resize-none text-slate-700 leading-relaxed"
                    placeholder="Tuliskan isi berita selengkap mungkin di sini...">{{ old('content') }}</textarea>
                @error('content') <p class="text-rose-500 text-[10px] font-bold mt-1 italic">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="p-8 bg-white rounded-[40px] shadow-sm border border-slate-100 space-y-6">
            <h4 class="text-xs font-black uppercase tracking-widest text-slate-900 mb-6">Metadata & Publikasi</h4>
            
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Kategori</label>
                <select name="category" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm focus:outline-none focus:border-school-primary transition-all appearance-none font-bold">
                    <option value="berita">Berita Utama</option>
                    <option value="pengumuman">Pengumuman</option>
                    <option value="prestasi">Prestasi</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Gambar Unggulan</label>
                <div class="relative group cursor-pointer">
                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="p-8 border-2 border-dashed border-slate-200 rounded-3xl text-center group-hover:border-school-primary/50 transition-all bg-slate-50/50">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Klik atau drag gambar ke sini</p>
                    </div>
                </div>
                <p class="text-[9px] text-slate-400 italic">Maksimal 2MB. Format JPG, PNG, WEBP.</p>
                @error('image') <p class="text-rose-500 text-[10px] font-bold mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-50 !my-8">

            <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black uppercase tracking-widest hover:bg-school-primary transition-all shadow-xl hover:scale-[1.02] active:scale-[0.98]">
                Terbitkan Sekarang <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>
        </div>
        
        <div class="p-8 bg-amber-50 rounded-[40px] border border-amber-100">
            <div class="flex gap-4">
                <i class="fa-solid fa-lightbulb text-amber-500 text-xl"></i>
                <p class="text-[11px] text-amber-700 leading-relaxed font-bold italic uppercase tracking-tight">Tips: Gunakan judul yang singkat dan padat untuk meningkatkan angka keterbacaan di media sosial.</p>
            </div>
        </div>
    </div>
</form>
@endsection
