@extends('layouts.admin')

@section('title', 'Manajemen Berita')
@section('page_title', 'Semua Berita')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div class="space-y-1">
        <h3 class="text-2xl font-black text-slate-900 uppercase italic">Daftar Konten</h3>
        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Kelola artikel, pengumuman, dan prestasi</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-xl hover:bg-school-primary transition-all flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Berita
    </a>
</div>

@if(session('success'))
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-sm font-bold flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Utama</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Penulis</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($articles as $article)
                <tr class="group hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm bg-slate-100 shrink-0">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 text-xl"><i class="fa-solid fa-image"></i></div>
                                @endif
                            </div>
                            <div class="max-w-xs">
                                <h4 class="font-bold text-slate-900 truncate uppercase tracking-tight text-sm">{{ $article->title }}</h4>
                                <p class="text-[10px] text-slate-400 font-medium truncate">{{ Str::limit(strip_tags($article->content), 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $article->category }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-xs font-bold text-slate-600">{{ $article->author->name }}</div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-tighter">{{ $article->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="text-4xl text-slate-100 mb-4"><i class="fa-solid fa-newspaper"></i></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">Belum ada berita yang diterbitkan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($articles->hasPages())
    <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection
