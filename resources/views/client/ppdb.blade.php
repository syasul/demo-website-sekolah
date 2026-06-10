@extends('layouts.client')

@section('title', 'PPDB & Kontak — SMA Task Master')

@section('content')
<!-- Header PPDB -->
<section class="py-24 bg-school-primary text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-slate-900/10 -z-0"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <h1 class="text-4xl md:text-6xl font-black mb-6 italic uppercase tracking-tighter">PPDB <span class="text-school-accent">&</span> Kontak</h1>
        <p class="text-white/70 max-w-2xl leading-relaxed">Informasi pendaftaran siswa baru tahun ajaran 2024/2025 dan layanan bantuan informasi sekolah.</p>
    </div>
</section>

<!-- Info PPDB -->
<section class="py-32 max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20">
    <div class="space-y-12">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-6 uppercase tracking-tight">Alur Pendaftaran</h2>
            <div class="space-y-8">
                <div class="flex gap-6">
                    <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0">1</div>
                    <div>
                        <h4 class="font-bold text-lg">Pendaftaran Online</h4>
                        <p class="text-sm text-slate-500 mt-1 italic">Mengisi formulir melalui website ini dan mengunggah berkas yang diperlukan.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0">2</div>
                    <div>
                        <h4 class="font-bold text-lg">Verifikasi Berkas</h4>
                        <p class="text-sm text-slate-500 mt-1 italic">Tim panitia akan memverifikasi dokumen yang telah Anda unggah.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0">3</div>
                    <div>
                        <h4 class="font-bold text-lg">Tes Seleksi & Wawancara</h4>
                        <p class="text-sm text-slate-500 mt-1 italic">Ujian pemetaan akademik dan wawancara kesiapan siswa serta orang tua.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black shrink-0">4</div>
                    <div>
                        <h4 class="font-bold text-lg">Pengumuman & Daftar Ulang</h4>
                        <p class="text-sm text-slate-500 mt-1 italic">Hasil seleksi diumumkan online dan dilanjutkan dengan proses registrasi ulang.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-10 bg-slate-50 rounded-[40px] border border-slate-100">
            <h3 class="text-xl font-bold mb-6 italic uppercase tracking-widest text-slate-900">Jadwal Gelombang</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="font-bold text-sm">Gelombang 1</div>
                    <div class="text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase">Januari - Maret</div>
                </div>
                <div class="flex justify-between items-center p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <div class="font-bold text-sm">Gelombang 2</div>
                    <div class="text-xs font-black text-slate-400 bg-slate-50 px-3 py-1 rounded-full uppercase">April - Juni</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form Card -->
    <div class="lg:-mt-40 relative z-20">
        <div class="bg-white rounded-[50px] p-10 md:p-14 shadow-2xl border border-slate-100">
            <h2 class="text-3xl font-black text-slate-900 mb-8 italic uppercase tracking-tighter">Kirim Pesan</h2>
            <form action="#" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email</label>
                        <input type="email" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Subjek</label>
                    <select class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all appearance-none">
                        <option>Pertanyaan Umum</option>
                        <option>Info Pendaftaran (PPDB)</option>
                        <option>Kemitraan/Kerja Sama</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Pesan Anda</label>
                    <textarea rows="4" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all resize-none"></textarea>
                </div>
                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black uppercase tracking-widest hover:bg-school-primary transition-all shadow-xl">
                    Kirim Sekarang <i class="fa-solid fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Maps & Details -->
<section class="py-32 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 rounded-[50px] overflow-hidden shadow-xl border-8 border-white h-[500px]">
                <!-- Mock Map -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126438.28548022131!2d112.5617424667954!3d-7.978469465225139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62822063dc2fb%3A0x78844889694e9f9a!2sMalang%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            
            <div class="space-y-8">
                <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-900 mb-4 uppercase tracking-tighter text-lg">Alamat Kantor</h4>
                    <p class="text-sm text-slate-500 leading-relaxed italic">
                        Jl. Pendidikan No. 123, Kel. Merdeka, Kec. Klojen, Kota Malang, Jawa Timur 65111
                    </p>
                </div>
                <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="font-bold text-slate-900 mb-4 uppercase tracking-tighter text-lg">Jam Layanan</h4>
                    <p class="text-sm text-slate-500 leading-relaxed italic">
                        Senin - Jumat: 08:00 - 16:00 WIB <br>
                        Sabtu: 08:00 - 12:00 WIB
                    </p>
                </div>
                <div class="p-8 bg-slate-900 rounded-3xl shadow-xl border border-white/5 text-white">
                    <h4 class="font-bold mb-4 uppercase tracking-tighter text-lg">Butuh Cepat?</h4>
                    <p class="text-xs text-slate-400 mb-6 italic">Hubungi kami langsung melalui WhatsApp untuk respon instan.</p>
                    <a href="https://wa.me/628123456789" class="flex items-center justify-center gap-3 py-3 bg-emerald-500 rounded-2xl text-white font-bold text-sm uppercase hover:bg-emerald-600 transition-all">
                        <i class="fa-brands fa-whatsapp text-xl"></i> Chat Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
