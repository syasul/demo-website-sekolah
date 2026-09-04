@extends('layouts.admin')

@section('title', 'Pengaturan Sekolah')
@section('page_title', 'Pengaturan Sekolah & Kop Raport')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Identitas Sekolah & Kop Raport</h3>
            <p class="text-xs text-slate-500 mt-0.5">Konfigurasi identitas lembaga, kepala sekolah, periode aktif, dan kop surat resmi raport.</p>
        </div>
    </div>
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Madrasah / Sekolah -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-school text-emerald-600"></i>
                    <span>1. Identitas Instansi & Akreditasi</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="nama_sekolah" class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Resmi Sekolah / Madrasah <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $setting->nama_sekolah) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                        @error('nama_sekolah')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="npsn" class="block text-xs font-bold text-slate-700 mb-1">NPSN</label>
                        <input type="text" id="npsn" name="npsn" value="{{ old('npsn', $setting->npsn) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="nsm" class="block text-xs font-bold text-slate-700 mb-1">NSM (Nomor Statistik Madrasah)</label>
                        <input type="text" id="nsm" name="nsm" value="{{ old('nsm', $setting->nsm) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="akreditasi" class="block text-xs font-bold text-slate-700 mb-1">Peringkat Akreditasi</label>
                        <input type="text" id="akreditasi" name="akreditasi" value="{{ old('akreditasi', $setting->akreditasi) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: Terakreditasi 'A' (Unggul)">
                    </div>
                </div>
            </div>

            <!-- Section 2: Pimpinan & Kepala Madrasah -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-emerald-600"></i>
                    <span>2. Pimpinan / Kepala Sekolah (Tanda Tangan Raport)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_kepala_sekolah" class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Kepala Sekolah Lengkap & Gelar <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_kepala_sekolah" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah', $setting->nama_kepala_sekolah) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                        @error('nama_kepala_sekolah')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nip_kepala_sekolah" class="block text-xs font-bold text-slate-700 mb-1">NIP Kepala Sekolah</label>
                        <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $setting->nip_kepala_sekolah) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: 19710520 199703 1 003">
                    </div>
                </div>
            </div>

            <!-- Section 3: Periode Akademik Aktif -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                    <span>3. Periode Tahun Ajaran & Semester Aktif</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tahun_ajaran_aktif" class="block text-xs font-bold text-slate-700 mb-1">
                            Tahun Pelajaran Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="tahun_ajaran_aktif" name="tahun_ajaran_aktif" value="{{ old('tahun_ajaran_aktif', $setting->tahun_ajaran_aktif) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50"
                            placeholder="Contoh: 2024/2025">
                    </div>

                    <div>
                        <label for="semester_aktif" class="block text-xs font-bold text-slate-700 mb-1">
                            Semester Aktif <span class="text-rose-500">*</span>
                        </label>
                        <select id="semester_aktif" name="semester_aktif" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            <option value="ganjil" {{ old('semester_aktif', $setting->semester_aktif) === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (Satu)</option>
                            <option value="genap" {{ old('semester_aktif', $setting->semester_aktif) === 'genap' ? 'selected' : '' }}>Semester Genap (Dua)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 4: Alamat & Kontak -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-emerald-600"></i>
                    <span>4. Alamat Kantor & Kontak</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-xs font-bold text-slate-700 mb-1">
                            Alamat Jalan & Nomor <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $setting->alamat) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="kota" class="block text-xs font-bold text-slate-700 mb-1">Kota / Kabupaten <span class="text-rose-500">*</span></label>
                        <input type="text" id="kota" name="kota" value="{{ old('kota', $setting->kota) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="provinsi" class="block text-xs font-bold text-slate-700 mb-1">Provinsi <span class="text-rose-500">*</span></label>
                        <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi', $setting->provinsi) }}" required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="telepon" class="block text-xs font-bold text-slate-700 mb-1">Telepon Kantor</label>
                        <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $setting->telepon) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $setting->email) }}"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    </div>
                </div>
            </div>

            <!-- Section 5: Logo Sekolah -->
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-image text-emerald-600"></i>
                    <span>5. Pengaturan Logo Sekolah (Siap Jual ke Sekolah Lain)</span>
                </h3>

                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="text-center shrink-0">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block mb-1.5">Logo Saat Ini:</span>
                        @if ($setting->logo_custom && \Illuminate\Support\Facades\Storage::disk('public')->exists($setting->logo_custom))
                            <img src="{{ asset('storage/' . $setting->logo_custom) }}" alt="Logo Custom" class="w-16 h-16 object-contain mx-auto">
                        @else
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Default" class="w-16 h-16 object-contain mx-auto">
                        @endif
                    </div>

                    <div class="flex-1 space-y-1">
                        <label for="logo_custom" class="block text-xs font-bold text-slate-800">Unggah Logo Sekolah Baru (Opsional)</label>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Secara default, sistem menggunakan logo sekolah lama di <code>images/logo.png</code>. Jika aplikasi ini dipasang untuk sekolah lain, unggah logo baru di sini agar kop surat dan tampilan website otomatis menyesuaikan tanpa perlu mengubah file kode.
                        </p>
                        <input type="file" id="logo_custom" name="logo_custom" accept="image/*"
                            class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-slate-700 hover:file:bg-slate-100 cursor-pointer pt-2">
                        @error('logo_custom')
                            <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-7 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Pengaturan Sekolah</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
