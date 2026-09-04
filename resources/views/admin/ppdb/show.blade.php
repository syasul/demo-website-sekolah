@extends('layouts.admin')

@section('title', 'Detail Calon Siswa')
@section('page_title', 'Verifikasi Berkas PPDB')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Detail Pendaftar Calon Siswa</h3>
            <p class="text-xs text-slate-500 mt-0.5">Verifikasi berkas, tentukan hasil seleksi, dan konversi calon siswa menjadi akun siswa aktif.</p>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all shadow-xs">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Col 1 & 2: Detail Data Calon Siswa -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">No. Registrasi PPDB</span>
                        <h3 class="text-xl font-mono font-black text-emerald-700">{{ $pendaftar->nomor_pendaftaran }}</h3>
                    </div>
                    <span class="text-xs text-slate-400">
                        Diajukan: {{ $pendaftar->created_at->translatedFormat('d F Y, H:i') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Nama Lengkap</span>
                        <p class="font-bold text-slate-900 text-base">{{ $pendaftar->nama_lengkap }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">NISN</span>
                        <p class="font-mono text-slate-700 font-semibold">{{ $pendaftar->nisn ?: '-' }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Jenis Kelamin</span>
                        <p class="font-semibold text-slate-800">{{ $pendaftar->jenis_kelamin === 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Tempat & Tanggal Lahir</span>
                        <p class="font-semibold text-slate-800">
                            {{ $pendaftar->tempat_lahir ?: '-' }}, {{ $pendaftar->tanggal_lahir ? $pendaftar->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Asal Sekolah (SMP / MTs)</span>
                        <p class="font-semibold text-slate-800">{{ $pendaftar->asal_sekolah ?: '-' }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">No. WhatsApp / HP</span>
                        <p class="font-mono font-bold text-slate-800">{{ $pendaftar->no_hp }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Nama Orang Tua / Wali</span>
                        <p class="font-semibold text-slate-800">{{ $pendaftar->nama_orang_tua ?: '-' }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Status Seleksi</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                            {{ $pendaftar->status === 'pending' ? 'bg-amber-50 text-amber-800 border border-amber-200' : '' }}
                            {{ $pendaftar->status === 'diterima' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : '' }}
                            {{ $pendaftar->status === 'ditolak' ? 'bg-rose-50 text-rose-800 border border-rose-200' : '' }}">
                            {{ ucfirst($pendaftar->status) }}
                        </span>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Alamat Lengkap</span>
                        <p class="text-slate-700 leading-relaxed bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            {{ $pendaftar->alamat ?: 'Alamat tidak dicantumkan.' }}
                        </p>
                    </div>

                    @if ($pendaftar->catatan_admin)
                        <div class="sm:col-span-2">
                            <span class="text-xs font-bold text-slate-400 block mb-1 uppercase tracking-wider">Catatan Verifikator Admin</span>
                            <p class="text-slate-700 italic bg-amber-50/60 p-3.5 rounded-2xl border border-amber-200">
                                "{{ $pendaftar->catatan_admin }}"
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Col 3: Status Update & Conversion Action -->
        <div class="space-y-6">
            <!-- Form Ubah Status -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-check text-emerald-600"></i>
                    <span>Tentukan Status Seleksi</span>
                </h3>

                <form method="POST" action="{{ route('admin.ppdb.update-status', $pendaftar->id) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Verifikasi</label>
                        <select name="status" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                            <option value="pending" {{ $pendaftar->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="diterima" {{ $pendaftar->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $pendaftar->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan_admin" rows="3" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50" placeholder="Catatan hasil seleksi / jadwal daftar ulang...">{{ old('catatan_admin', $pendaftar->catatan_admin) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-colors">
                        Simpan Keputusan
                    </button>
                </form>
            </div>

            <!-- Fitur Konversi ke Siswa Baru -->
            @if ($pendaftar->status === 'diterima')
                <div class="bg-linear-to-br from-emerald-50 via-teal-50 to-white rounded-3xl border border-emerald-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xs">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-emerald-950">Konversi ke Siswa Aktif</h3>
                    </div>

                    @if ($pendaftar->is_converted)
                        <div class="p-4 rounded-2xl bg-emerald-100/70 border border-emerald-200 text-emerald-900 text-xs font-semibold flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span>Calon siswa ini sudah resmi dikonversi menjadi Siswa Baru.</span>
                        </div>
                    @else
                        <p class="text-xs text-emerald-800 mb-4 leading-relaxed">
                            Calon siswa ini berstatus <strong>Diterima</strong>. Anda dapat langsung meng-generate akun login dan memasukkannya ke rombel kelas.
                        </p>

                        <form method="POST" action="{{ route('admin.ppdb.konversi', $pendaftar->id) }}" class="space-y-4">
                            @csrf

                            <div>
                                <label for="nis" class="block text-xs font-bold text-slate-800 mb-1">
                                    Tentukan NIS Siswa <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="nis" name="nis" required placeholder="Contoh: 20241050"
                                    class="w-full px-4 py-2 text-xs rounded-xl border border-emerald-300 focus:border-emerald-600 focus:ring-emerald-600 bg-white">
                                @error('nis')
                                    <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelas_id" class="block text-xs font-bold text-slate-800 mb-1">
                                    Pilih Rombel Kelas <span class="text-rose-500">*</span>
                                </label>
                                <select id="kelas_id" name="kelas_id" required
                                    class="w-full px-4 py-2 text-xs rounded-xl border border-emerald-300 focus:border-emerald-600 focus:ring-emerald-600 bg-white">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasList as $k)
                                        <option value="{{ $k->id }}">Kelas {{ $k->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <p class="text-rose-500 text-[11px] font-bold mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md shadow-emerald-900/20 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Jadikan Siswa Aktif & Buat Akun</span>
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
