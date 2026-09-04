<x-guest-layout>
    <div class="mb-6 text-center">
        <h3 class="text-xl font-bold text-white tracking-tight">Atur Ulang Kata Sandi</h3>
        <p class="text-xs text-slate-400 mt-2 leading-relaxed">
            Lupa kata sandi Anda? Masukkan alamat email terdaftar di bawah ini, dan kami akan mengirimkan tautan reset kata sandi ke kotak masuk Anda.
        </p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-xs sm:text-sm font-bold text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email Terdaftar</label>
            <div class="relative">
                <span class="absolute left-5 sm:left-6 top-1/2 -translate-y-1/2 text-slate-500 text-sm">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full pl-12 sm:pl-14 pr-5 sm:pr-6 py-3.5 sm:py-4 bg-slate-800/50 border border-white/5 rounded-2xl sm:rounded-3xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all text-white placeholder-slate-600 shadow-inner"
                    placeholder="nama@attaraqqie.sch.id">
            </div>
            @if($errors->has('email'))
                <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 italic">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-4 sm:py-5 bg-white text-slate-900 rounded-2xl sm:rounded-3xl font-black uppercase text-xs sm:text-sm tracking-widest hover:bg-school-primary hover:text-white transition-all shadow-xl hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                <span>Kirim Tautan Reset</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="text-slate-400 hover:text-white text-xs font-bold transition-colors inline-flex items-center gap-2">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Halaman Masuk</span>
            </a>
        </div>
    </form>
</x-guest-layout>
