@extends('layouts.admin')

@section('title', 'Tambah Siswa Baru')
@section('page_title', 'Input Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Formulir Tambah Siswa Baru</h3>
            <p class="text-xs text-slate-500 mt-0.5">Input data induk siswa secara manual. Akun login otomatis dibuatkan oleh sistem.</p>
        </div>
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.siswa.store') }}" class="space-y-6">
            @csrf

            <!-- Section 1: Identitas Akademik & Akun -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-emerald-600"></i>
                    <span>1. Identitas Akademik & Akun Login</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nis" class="block text-xs font-bold text-slate-700 mb-1">
                            NIS (Nomor Induk Siswa) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis') }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: 20241001">
                        @error('nis')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nisn" class="block text-xs font-bold text-slate-700 mb-1">
                            NISN (Nomor Induk Siswa Nasional)
                        </label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: 0078912345 (10 digit)">
                        @error('nisn')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Lengkap Siswa <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: Muhammad Rayhan Akbar">
                        @error('name')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-xs font-bold text-slate-700 mb-1">
                            Pilih Kelas & Rombel <span class="text-rose-500">*</span>
                        </label>
                        <select id="kelas_id" name="kelas_id" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            <option value="">-- Pilih Rombel Kelas --</option>
                            @foreach ($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    Kelas {{ $k->nama_lengkap }} (Tingkat {{ $k->tingkat }})
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                            Alamat Email (Opsional)
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Otomatis di-generate jika dikosongkan">
                        @error('email')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1">
                            Password Awal (Opsional)
                        </label>
                        <input type="text" id="password" name="password" value="{{ old('password') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Default: Sama dengan NIS">
                        <p class="text-[10px] text-slate-400 mt-1">Jika dikosongkan, password awal otomatis disamakan dengan NIS siswa.</p>
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-bold text-slate-700 mb-1">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Data Diri & Kontak Keluarga -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-group text-emerald-600"></i>
                    <span>2. Data Pribadi & Kontak Orang Tua/Wali</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tempat_lahir" class="block text-xs font-bold text-slate-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: Malang">
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-bold text-slate-700 mb-1">Alamat Tempat Tinggal</label>
                        <textarea id="alamat" name="alamat" rows="2"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Alamat lengkap siswa...">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label for="nama_orang_tua" class="block text-xs font-bold text-slate-700 mb-1">Nama Orang Tua / Wali</label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: H. Bambang Sutejo">
                    </div>

                    <div>
                        <label for="no_hp_orang_tua" class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP Orang Tua</label>
                        <input type="text" id="no_hp_orang_tua" name="no_hp_orang_tua" value="{{ old('no_hp_orang_tua') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: 081234567890">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.siswa.index') }}" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Siswa & Buat Akun</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
