@extends('layouts.admin')

@section('title', 'Catat Poin Kedisiplinan & Prestasi')
@section('page_title', 'Input Poin Karakter Santri')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h3 class="text-base font-black text-slate-900 uppercase">Form Catatan Kedisiplinan</h3>
            <p class="text-xs text-slate-500 font-medium">Poin prestasi dapat menebus akumulasi pelanggaran santri secara proporsional.</p>
        </div>
        <a href="{{ route('admin.kedisiplinan.index') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.kedisiplinan.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Pilih Santri / Siswa <span class="text-rose-500">*</span></label>
                <select name="siswa_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                    <option value="">-- Pilih Santri --</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->user_id }}">
                            {{ $s->nama_lengkap }} (Kelas: {{ $s->kelas?->nama_lengkap }} - NIS: {{ $s->nis }})
                        </option>
                    @endforeach
                </select>
                @error('siswa_id') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Kategori Pelanggaran / Prestasi <span class="text-rose-500">*</span></label>
                <select name="kategori_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                    <option value="">-- Pilih Kategori Tindakan --</option>
                    <optgroup label="PRESTASI (Poin Plus +)">
                        @foreach($kategoris->where('tipe', 'prestasi') as $k)
                            <option value="{{ $k->id }}">
                                🏆 {{ $k->nama }} (+{{ $k->bobot }} Poin)
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="PELANGGARAN (Poin Minus -)">
                        @foreach($kategoris->where('tipe', 'pelanggaran') as $k)
                            <option value="{{ $k->id }}">
                                ⚠️ {{ $k->nama }} (-{{ $k->bobot }} Poin)
                            </option>
                        @endforeach
                    </optgroup>
                </select>
                @error('kategori_id') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Tanggal Peristiwa <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary">
                @error('tanggal') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5">Catatan Tambahan / Keterangan</label>
                <textarea name="catatan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-school-primary" placeholder="Tuliskan keterangan detail, lokasi, saksi, atau tindak lanjut..."></textarea>
            </div>

            <div class="p-3.5 bg-amber-50 rounded-2xl border border-amber-200 text-amber-800 text-[11px] flex items-start gap-2.5">
                <i class="fa-solid fa-bell text-amber-600 mt-0.5 text-xs"></i>
                <div>
                    <span class="font-bold block">Pemberitahuan Otomatis ke Orang Tua:</span>
                    <span>Setiap pencatatan poin akan otomatis mengirimkan notifikasi in-app ke akun Wali Murid terkait. Apabila batas pelanggaran terlampaui, peringatan khusus akan dipicu ke BK.</span>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider rounded-2xl transition-all shadow-md">
                    Simpan Catatan Poin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
