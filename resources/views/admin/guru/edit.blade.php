@extends('layouts.admin')

@section('title', 'Edit Profil Guru')
@section('page_title', 'Edit Data Guru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Akun Guru</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui data profil atau atur ulang password akun guru.</p>
        </div>
        <a href="{{ route('admin.guru.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-200 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    @if (isset($errors) && $errors->any())
    <div class="mb-6 p-4 bg-rose-50 text-rose-700 border border-rose-200 rounded-2xl font-medium text-xs">
        <div class="font-bold mb-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>Terdapat beberapa kesalahan:</span>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.guru.update', $guru) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap & Gelar</label>
                <input type="text" name="name" id="name" value="{{ old('name', $guru->name) }}" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $guru->email) }}" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
            </div>

            <div class="p-4 bg-amber-50/70 border border-amber-100 rounded-2xl">
                <p class="text-xs font-bold text-amber-800 mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Ubah Password (Opsional)</span>
                </p>
                <p class="text-[11px] text-amber-700">Biarkan field password di bawah ini kosong jika Anda tidak bermaksud mengubah password.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" placeholder="Kosongkan jika tetap"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.guru.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-school-primary text-white rounded-xl font-bold text-xs hover:bg-school-primary/90 transition shadow-lg shadow-school-primary/30 flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
