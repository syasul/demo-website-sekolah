<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm font-bold text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email Unit Kerja</label>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-500">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full pl-14 pr-6 py-4 bg-slate-800/50 border border-white/5 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all text-white placeholder-slate-600 shadow-inner"
                    placeholder="nama@smataskmaster.sch.id">
            </div>
            @if($errors->has('email'))
                <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 italic">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center px-1">
                <label for="password" class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-school-primary hover:text-white transition-colors uppercase tracking-widest" href="{{ route('password.request') }}">
                        Lupa Sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-500">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-14 pr-6 py-4 bg-slate-800/50 border border-white/5 rounded-3xl text-sm focus:outline-none focus:border-school-primary transition-all text-white placeholder-slate-600 shadow-inner"
                    placeholder="••••••••">
            </div>
            @if($errors->has('password'))
                <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 italic">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative items-center flex">
                    <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-white/10 bg-slate-800 text-school-primary focus:ring-school-primary transition-all cursor-pointer">
                </div>
                <span class="ms-3 text-[11px] font-bold text-slate-400 group-hover:text-white transition-colors">Tetap masuk di perangkat ini</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-5 bg-white text-slate-900 rounded-3xl font-black uppercase tracking-widest hover:bg-school-primary hover:text-white transition-all shadow-xl hover:scale-[1.02] active:scale-[0.98]">
                Masuk Portal <i class="fa-solid fa-right-to-bracket ml-2"></i>
            </button>
        </div>
        
        <div class="text-center pt-4">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Masalah akses? <a href="#" class="text-school-primary hover:underline">Hubungi IT Support</a></p>
        </div>
    </form>
</x-guest-layout>
