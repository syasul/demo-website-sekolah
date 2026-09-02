<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Portal — SMA Task Master</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-900 text-white font-sans overflow-x-hidden">
        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-1/2 h-full bg-school-primary/5 -z-0 rounded-bl-[100px]"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-school-accent/10 rounded-full blur-[120px] -z-0"></div>
            
            <div class="w-full sm:max-w-xl z-10 my-6">
                <div class="text-center mb-8 sm:mb-12">
                    <a href="/" class="inline-flex items-center gap-2.5 sm:gap-3 mb-6 sm:mb-8 hover:scale-105 transition-transform">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-school-primary rounded-2xl flex items-center justify-center text-white text-2xl sm:text-3xl shadow-lg border border-white/20">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <span class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase italic">Task Master</span>
                    </a>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Portal Admin & Guru</h2>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1.5 sm:mt-2">Silakan masuk untuk mengelola sistem informasi sekolah.</p>
                </div>

                <div class="glass p-6 sm:p-10 md:p-14 rounded-3xl sm:rounded-[40px] lg:rounded-[50px] shadow-3xl border border-white/10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-school-primary/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                    {{ $slot }}
                </div>
                
                <div class="text-center mt-8 sm:mt-12 text-slate-500 text-xs italic">
                    &copy; {{ date('Y') }} SMA Task Master. Secured Portal.
                </div>
            </div>
        </div>
    </body>
</html>

