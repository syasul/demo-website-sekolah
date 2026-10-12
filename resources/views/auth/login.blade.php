<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-4 sm:mb-6 p-3.5 sm:p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-xs sm:text-sm font-bold text-center">
            {{ session('status') }}
        </div>
    @endif

    <!-- QUICK DEMO PRESET BUTTONS (UNTUK PRESENTASI PROPOSAL) -->
    <div class="mb-6 p-4 rounded-3xl bg-slate-800/80 border border-white/10 shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[10px] font-black uppercase text-emerald-400 tracking-widest flex items-center gap-1.5">
                <i class="fa-solid fa-bolt"></i> Akun Cepat Demo Presentasi
            </span>
            <span class="text-[9px] text-slate-400 font-bold">Password: password</span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-left">
            <button type="button" onclick="fillLogin('admin.global@demo', 'password')" class="p-2 rounded-xl bg-white/5 hover:bg-emerald-600/30 text-white border border-white/10 text-[11px] font-bold transition-all text-left">
                <div class="text-emerald-400 text-[10px] font-black uppercase">👑 Admin Global</div>
                <div class="truncate text-slate-300">Yayasan Terpadu</div>
            </button>
            <button type="button" onclick="fillLogin('ortu@demo', 'password')" class="p-2 rounded-xl bg-white/5 hover:bg-emerald-600/30 text-white border border-white/10 text-[11px] font-bold transition-all text-left">
                <div class="text-teal-400 text-[10px] font-black uppercase">👨‍👩‍👧 Wali Santri</div>
                <div class="truncate text-slate-300">Multi-Anak (Putra/i)</div>
            </button>
            <button type="button" onclick="fillLogin('admin.putra@demo', 'password')" class="p-2 rounded-xl bg-white/5 hover:bg-sky-600/30 text-white border border-white/10 text-[11px] font-bold transition-all text-left">
                <div class="text-sky-400 text-[10px] font-black uppercase">👔 Admin Putra</div>
                <div class="truncate text-slate-300">MA Attaraqqie Putra</div>
            </button>
            <button type="button" onclick="fillLogin('admin.putri@demo', 'password')" class="p-2 rounded-xl bg-white/5 hover:bg-purple-600/30 text-white border border-white/10 text-[11px] font-bold transition-all text-left">
                <div class="text-purple-400 text-[10px] font-black uppercase">🧕 Admin Putri</div>
                <div class="truncate text-slate-300">MA Attaraqqie Putri</div>
            </button>
            <button type="button" onclick="fillLogin('guru.putra@demo', 'password')" class="p-2 rounded-xl bg-white/5 hover:bg-amber-600/30 text-white border border-white/10 text-[11px] font-bold transition-all text-left">
                <div class="text-amber-400 text-[10px] font-black uppercase">📖 Guru Putra</div>
                <div class="truncate text-slate-300">Ust. Ahmad Zaki</div>
            </button>
            <button type="button" onclick="fillLogin('guru.keduanya@demo', 'password')" class="p-2 rounded-xl bg-white/5 hover:bg-indigo-600/30 text-white border border-white/10 text-[11px] font-bold transition-all text-left">
                <div class="text-indigo-400 text-[10px] font-black uppercase">📚 Guru Lintas Unit</div>
                <div class="truncate text-slate-300">Ust. Dr. H. M. Hasbi</div>
            </button>
        </div>
    </div>

    <form id="form-login" method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email / Akun Pengguna</label>
            <div class="relative">
                <span class="absolute left-5 sm:left-6 top-1/2 -translate-y-1/2 text-slate-500 text-sm">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full pl-12 sm:pl-14 pr-5 sm:pr-6 py-3.5 sm:py-4 bg-slate-800/50 border border-white/5 rounded-2xl sm:rounded-3xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all text-white placeholder-slate-600 shadow-inner"
                    placeholder="admin.global@demo / guru.putra@demo / ortu@demo">
            </div>
            @if($errors->has('email'))
                <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 italic">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex justify-between items-center px-1">
                <label for="password" class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-school-primary hover:text-white transition-colors uppercase tracking-widest" href="{{ route('password.request') }}">
                        Lupa Sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="absolute left-5 sm:left-6 top-1/2 -translate-y-1/2 text-slate-500 text-sm">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-12 sm:pl-14 pr-5 sm:pr-6 py-3.5 sm:py-4 bg-slate-800/50 border border-white/5 rounded-2xl sm:rounded-3xl text-xs sm:text-sm focus:outline-none focus:border-school-primary transition-all text-white placeholder-slate-600 shadow-inner"
                    placeholder="••••••••">
            </div>
            @if($errors->has('password'))
                <p class="text-rose-500 text-[10px] font-bold mt-1.5 ml-1 italic">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative items-center flex">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 sm:w-5 sm:h-5 rounded-lg border-white/10 bg-slate-800 text-school-primary focus:ring-school-primary transition-all cursor-pointer" checked>
                </div>
                <span class="ms-2.5 sm:ms-3 text-[10px] sm:text-[11px] font-bold text-slate-400 group-hover:text-white transition-colors">Tetap masuk di perangkat ini</span>
            </label>
        </div>

        <div class="pt-2 sm:pt-4">
            <button type="submit" class="w-full py-4 sm:py-5 bg-white text-slate-900 rounded-2xl sm:rounded-3xl font-black uppercase text-xs sm:text-sm tracking-widest hover:bg-school-primary hover:text-white transition-all shadow-xl hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                <span>Masuk Portal</span>
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
            </button>
        </div>
        
        <div class="text-center pt-2 sm:pt-4">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Sistem Informasi Terpadu Multi-Unit MA At-Taraqqie</p>
        </div>
    </form>

    <script>
        function fillLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('form-login').submit();
        }
    </script>
</x-guest-layout>
