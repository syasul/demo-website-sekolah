@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')
@section('page_title', 'Buat Artikel')

@section('content')
<div class="mb-6 sm:mb-8">
    <a href="{{ route('admin.articles.index') }}" class="text-[10px] sm:text-xs font-black uppercase text-slate-400 hover:text-slate-900 transition-colors inline-flex items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Kembali ke Daftar</span>
    </a>
</div>

<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
    @csrf
    
    <div class="lg:col-span-2 space-y-6 sm:space-y-8">
        <div class="p-6 sm:p-10 bg-white rounded-3xl sm:rounded-[40px] shadow-sm border border-slate-100 space-y-5 sm:space-y-6">
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl sm:rounded-3xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all font-bold text-slate-900"
                    placeholder="Masukkan judul berita yang menarik...">
                @error('title') <p class="text-rose-500 text-[10px] font-bold mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Konten Berita</label>
                <textarea name="content" id="editor" rows="12" required
                    class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl sm:rounded-3xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all resize-none text-slate-700 leading-relaxed"
                    placeholder="Tuliskan isi berita selengkap mungkin di sini...">{{ old('content') }}</textarea>
                @error('content') <p class="text-rose-500 text-[10px] font-bold mt-1 italic">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="space-y-6 sm:space-y-8">
        <div class="p-6 sm:p-8 bg-white rounded-3xl sm:rounded-[40px] shadow-sm border border-slate-100 space-y-5 sm:space-y-6">
            <h4 class="text-xs font-black uppercase tracking-widest text-slate-900 mb-4 sm:mb-6">Metadata & Publikasi</h4>
            
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Kategori</label>
                <select name="category" required class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all appearance-none font-bold text-slate-800">
                    <option value="berita">Berita Utama</option>
                    <option value="pengumuman">Pengumuman</option>
                    <option value="prestasi">Prestasi</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Gambar Unggulan</label>
                <div class="relative group cursor-pointer">
                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="p-6 sm:p-8 border-2 border-dashed border-slate-200 rounded-2xl sm:rounded-3xl text-center group-hover:border-school-primary/50 transition-all bg-slate-50/50">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl sm:text-3xl text-slate-300 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Klik atau drag gambar ke sini</p>
                    </div>
                </div>
                <p class="text-[9px] text-slate-400 italic">Maksimal 2MB. Format JPG, PNG, WEBP.</p>
                @error('image') <p class="text-rose-500 text-[10px] font-bold mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-100 !my-6">

            <button type="submit" class="w-full py-4 sm:py-5 bg-slate-900 text-white rounded-2xl sm:rounded-3xl font-black uppercase text-xs sm:text-sm tracking-widest hover:bg-school-primary transition-all shadow-xl hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                <span>Terbitkan Sekarang</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </div>
        
        <div class="p-6 sm:p-8 bg-amber-50 rounded-3xl sm:rounded-[40px] border border-amber-100">
            <div class="flex gap-3.5 sm:gap-4 items-start">
                <i class="fa-solid fa-lightbulb text-amber-500 text-lg sm:text-xl shrink-0 mt-0.5"></i>
                <p class="text-[11px] text-amber-800 leading-relaxed font-bold italic uppercase tracking-tight">Tips: Gunakan judul yang singkat dan padat untuk meningkatkan angka keterbacaan di media sosial.</p>
            </div>
        </div>
    </div>
</form>
@endsection

