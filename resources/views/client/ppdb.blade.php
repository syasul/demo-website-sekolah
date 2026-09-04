@extends('layouts.client')

@section('title', 'PPDB & Kontak — MA At-Taraqqie')

@section('content')
<!-- Header PPDB -->
<section class="py-14 sm:py-20 lg:py-24 bg-school-primary text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-slate-900/10 -z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full border border-white/10 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-accent">
            Penerimaan Siswa Baru
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black mb-4 sm:mb-6 italic uppercase tracking-tighter">PPDB <span class="text-school-accent">&</span> Kontak</h1>
        <p class="text-sm sm:text-base text-white/80 max-w-2xl leading-relaxed">Informasi pendaftaran siswa baru tahun ajaran 2024/2025 dan layanan bantuan informasi sekolah.</p>
    </div>
</section>

<!-- Info PPDB -->
<section class="py-16 sm:py-24 lg:py-32 max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-2 gap-10 sm:gap-14 lg:gap-20">
    <div class="space-y-8 sm:space-y-12">
        <div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-6 uppercase tracking-tight">Alur Pendaftaran</h2>
            <div class="space-y-6 sm:space-y-8">
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0 text-sm sm:text-base">1</div>
                    <div>
                        <h4 class="font-bold text-base sm:text-lg text-slate-900">Pendaftaran Online</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 italic leading-relaxed">Mengisi formulir melalui website ini dan mengunggah berkas yang diperlukan.</p>
                    </div>
                </div>
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0 text-sm sm:text-base">2</div>
                    <div>
                        <h4 class="font-bold text-base sm:text-lg text-slate-900">Verifikasi Berkas</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 italic leading-relaxed">Tim panitia akan memverifikasi dokumen yang telah Anda unggah.</p>
                    </div>
                </div>
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0 text-sm sm:text-base">3</div>
                    <div>
                        <h4 class="font-bold text-base sm:text-lg text-slate-900">Tes Seleksi & Wawancara</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 italic leading-relaxed">Ujian pemetaan akademik dan wawancara kesiapan siswa serta orang tua.</p>
                    </div>
                </div>
                <div class="flex gap-4 sm:gap-6 items-start">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0 text-sm sm:text-base">4</div>
                    <div>
                        <h4 class="font-bold text-base sm:text-lg text-slate-900">Pengumuman & Daftar Ulang</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 italic leading-relaxed">Hasil seleksi diumumkan online dan dilanjutkan dengan proses registrasi ulang.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 sm:p-10 bg-slate-50 rounded-3xl sm:rounded-[40px] border border-slate-100 shadow-sm">
            <h3 class="text-lg sm:text-xl font-bold mb-6 italic uppercase tracking-widest text-slate-900">Jadwal Gelombang</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="font-bold text-xs sm:text-sm text-slate-900">Gelombang 1</div>
                    <div class="text-[11px] sm:text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase">Januari - Maret</div>
                </div>
                <div class="flex justify-between items-center p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="font-bold text-xs sm:text-sm text-slate-900">Gelombang 2</div>
                    <div class="text-[11px] sm:text-xs font-black text-slate-400 bg-slate-50 px-3 py-1 rounded-full uppercase">April - Juni</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form Card -->
    <div class="lg:-mt-24 relative z-20">
        <div class="bg-white rounded-3xl sm:rounded-[40px] lg:rounded-[50px] p-6 sm:p-10 md:p-12 shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 italic uppercase tracking-tighter">Formulir PPDB</h2>
                    <p class="text-xs text-slate-500 mt-1">Isi identitas calon siswa dengan data yang valid.</p>
                </div>
                <a href="{{ route('ppdb.status') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all shrink-0 flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    <span>Cek Status</span>
                </a>
            </div>

            @if(session('ppdb_success'))
                <div class="mb-8 p-6 rounded-3xl bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-3">
                    <div class="flex items-center gap-3 text-emerald-700 font-bold text-base">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                        <span>Pendaftaran Berhasil Dikirim!</span>
                    </div>
                    <p class="text-xs text-emerald-800 leading-relaxed">
                        Terima kasih, data pendaftaran atas nama <strong>{{ session('ppdb_success')['nama'] }}</strong> telah kami terima.
                    </p>
                    <div class="p-4 rounded-2xl bg-white border border-emerald-200/80 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Nomor Registrasi Anda</span>
                            <span class="text-lg font-mono font-black text-emerald-700 tracking-wider">{{ session('ppdb_success')['nomor'] }}</span>
                        </div>
                        <a href="{{ route('ppdb.status', ['keyword' => session('ppdb_success')['nomor']]) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors">
                            Cek Status Langsung
                        </a>
                    </div>
                    <p class="text-[11px] text-emerald-700">Simpan nomor registrasi di atas untuk melacak status verifikasi berkas dan pengumuman hasil seleksi.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('ppdb.store') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                        Nama Lengkap Calon Siswa <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Muhammad Rayhan Akbar" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    @error('nama_lengkap')
                        <p class="text-rose-500 text-[11px] font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">NISN (10 Digit)</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Contoh: 0071234567" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <select name="jenis_kelamin" required class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Malang" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Asal Sekolah (SMP / MTs)</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Contoh: MTs Negeri 1 Malang" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                            No. WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 081234567890" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                        @error('no_hp')
                            <p class="text-rose-500 text-[11px] font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Orang Tua / Wali</label>
                    <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" placeholder="Contoh: H. Bambang Sutejo" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Alamat Tempat Tinggal</label>
                    <textarea name="alamat" rows="3" placeholder="Alamat domisili lengkap..." class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all resize-none">{{ old('alamat') }}</textarea>
                </div>

                <button type="submit" class="w-full py-4 sm:py-5 bg-slate-900 text-white rounded-2xl font-black uppercase text-xs sm:text-sm tracking-widest hover:bg-school-primary transition-all shadow-xl shadow-slate-900/10 flex items-center justify-center gap-2">
                    <span>Kirim Formulir Pendaftaran</span>
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Maps & Details -->
<section class="py-16 sm:py-24 lg:py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-12">
            <div class="lg:col-span-2 rounded-3xl sm:rounded-[40px] lg:rounded-[50px] overflow-hidden shadow-xl border-4 sm:border-8 border-white h-72 sm:h-96 lg:h-[500px]">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.28548022131!2d112.5617424667954!3d-7.978469465225139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62822063dc2fb%3A0x78844889694e9f9a!2sMalang%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            
            <div class="space-y-6 sm:space-y-8">
                <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-900 mb-3 uppercase tracking-tight text-base sm:text-lg">Alamat Kantor</h4>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed italic">
                        Jl. Pendidikan No. 123, Kel. Merdeka, Kec. Klojen, Kota Malang, Jawa Timur 65111
                    </p>
                </div>
                <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-900 mb-3 uppercase tracking-tight text-base sm:text-lg">Jam Layanan</h4>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed italic">
                        Senin - Jumat: 08:00 - 16:00 WIB <br>
                        Sabtu: 08:00 - 12:00 WIB
                    </p>
                </div>
                <div class="p-6 sm:p-8 bg-slate-900 rounded-3xl shadow-xl border border-white/5 text-white">
                    <h4 class="font-bold mb-3 uppercase tracking-tight text-base sm:text-lg">Butuh Cepat?</h4>
                    <p class="text-xs text-slate-400 mb-5 italic">Hubungi kami langsung melalui WhatsApp untuk respon instan.</p>
                    <a href="https://wa.me/628123456789" class="flex items-center justify-center gap-3 py-3.5 bg-emerald-500 rounded-2xl text-white font-bold text-xs sm:text-sm uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                        <i class="fa-brands fa-whatsapp text-lg sm:text-xl"></i>
                        <span>Chat Admin WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

