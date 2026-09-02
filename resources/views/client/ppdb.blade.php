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

    <!-- Contact Form Card -->
    <div class="lg:-mt-24 relative z-20">
        <div class="bg-white rounded-3xl sm:rounded-[40px] lg:rounded-[50px] p-6 sm:p-10 md:p-12 shadow-2xl border border-slate-100">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-6 sm:mb-8 italic uppercase tracking-tighter">Kirim Pesan</h2>
            <form action="#" class="space-y-4 sm:space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" placeholder="Nama Anda" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email</label>
                        <input type="email" placeholder="nama@domain.com" class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Subjek</label>
                    <select class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all appearance-none">
                        <option>Pertanyaan Umum</option>
                        <option>Info Pendaftaran (PPDB)</option>
                        <option>Kemitraan / Kerja Sama</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Pesan Anda</label>
                    <textarea rows="4" placeholder="Tuliskan pesan pertanyaan atau kebutuhan Anda..." class="w-full px-5 sm:px-6 py-3.5 sm:py-4 bg-slate-50 border border-slate-100 rounded-2xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all resize-none"></textarea>
                </div>
                <button type="submit" class="w-full py-4 sm:py-5 bg-slate-900 text-white rounded-2xl font-black uppercase text-xs sm:text-sm tracking-widest hover:bg-school-primary transition-all shadow-xl shadow-slate-900/10 flex items-center justify-center gap-2">
                    <span>Kirim Sekarang</span>
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

