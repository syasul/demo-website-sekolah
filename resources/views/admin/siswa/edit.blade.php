@extends('layouts.admin')

@section('title', 'Edit Data Siswa')
@section('page_title', 'Perbarui Data Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Edit Data Profil Siswa</h3>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui data profil, penempatan rombel kelas, atau status akademik siswa.</p>
        </div>
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Akademik & Akun -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-emerald-600"></i>
                    <span>1. Identitas Akademik & Status</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nis" class="block text-xs font-bold text-slate-700 mb-1">
                            NIS (Nomor Induk Siswa) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                        @error('nis')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nisn" class="block text-xs font-bold text-slate-700 mb-1">
                            NISN
                        </label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                        @error('nisn')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Lengkap Siswa <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $siswa->user ? $siswa->user->name : '') }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                        @error('name')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1">
                            Email Akun Login <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $siswa->user ? $siswa->user->email : '') }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                        @error('email')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-xs font-bold text-slate-700 mb-1">
                            Pilih Kelas & Rombel <span class="text-rose-500">*</span>
                        </label>
                        <select id="kelas_id" name="kelas_id" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            @foreach ($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                    Kelas {{ $k->nama_lengkap }} (Tingkat {{ $k->tingkat }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-bold text-slate-700 mb-1">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 mb-1">
                            Status Akademik <span class="text-rose-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            <option value="aktif" {{ old('status', $siswa->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ old('status', $siswa->status) === 'lulus' ? 'selected' : '' }}>Lulus / Alumni</option>
                            <option value="pindah" {{ old('status', $siswa->status) === 'pindah' ? 'selected' : '' }}>Pindah Sekolah</option>
                            <option value="nonaktif" {{ old('status', $siswa->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Data Pribadi & Keluarga -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-group text-emerald-600"></i>
                    <span>2. Data Pribadi & Kontak Orang Tua/Wali</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tempat_lahir" class="block text-xs font-bold text-slate-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-bold text-slate-700 mb-1">Alamat Tempat Tinggal</label>
                        <textarea id="alamat" name="alamat" rows="2"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>

                    <div>
                        <label for="nama_orang_tua" class="block text-xs font-bold text-slate-700 mb-1">Nama Orang Tua / Wali</label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua" value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="no_hp_orang_tua" class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP Orang Tua</label>
                        <input type="text" id="no_hp_orang_tua" name="no_hp_orang_tua" value="{{ old('no_hp_orang_tua', $siswa->no_hp_orang_tua) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.siswa.index') }}" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
