@extends('layouts.client')

@section('title', 'Virtual Tour 360° — MA At-Taraqqie')

@section('head')
<!-- Pannellum CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
<style>
    #panorama {
        width: 100%;
        height: 55vh;
        min-height: 320px;
        max-height: 600px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 80px -20px rgba(0,0,0,0.2);
        border: 4px solid white;
    }
    @media (min-width: 640px) {
        #panorama {
            height: 65vh;
            border-radius: 40px;
            border: 8px solid white;
        }
    }
    .custom-hotspot {
        height: 30px;
        width: 30px;
        background: #7a2b37;
        border-radius: 50%;
        border: 3px solid white;
        cursor: pointer;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(122, 43, 55, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(122, 43, 55, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(122, 43, 55, 0); }
    }
</style>
@endsection

@section('content')
<section class="py-14 sm:py-20 lg:py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 sm:mb-12 gap-6">
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-school-primary/10 rounded-full border border-school-primary/20 mb-3 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-school-primary">
                    Eksplorasi Interaktif
                </div>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 mb-3 sm:mb-4 italic uppercase tracking-tighter">Virtual Tour</h1>
                <p class="text-xs sm:text-base text-slate-500 leading-relaxed italic">Jelajahi setiap sudut MA At-Taraqqie secara interaktif dengan teknologi 360°.</p>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <button onclick="loadScene('library')" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold hover:bg-slate-900 hover:text-white transition-all uppercase shadow-sm">Perpustakaan</button>
                <button onclick="loadScene('lab')" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold hover:bg-slate-900 hover:text-white transition-all uppercase shadow-sm">Laboratorium</button>
                <button onclick="loadScene('field')" class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white border border-slate-200 rounded-full text-xs font-bold hover:bg-slate-900 hover:text-white transition-all uppercase shadow-sm">Lapangan</button>
            </div>
        </div>

        <div id="panorama"></div>

        <div class="mt-8 sm:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-8">
            <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100 flex items-start gap-4 sm:gap-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-school-primary/10 rounded-2xl flex items-center justify-center text-school-primary shrink-0 text-base sm:text-lg"><i class="fa-solid fa-arrows-to-eye"></i></div>
                <div>
                    <h4 class="font-bold text-sm sm:text-base mb-1.5 text-slate-900">Kontrol Navigasi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">Klik dan seret untuk melihat sekeliling. Gunakan scroll untuk memperbesar area.</p>
                </div>
            </div>
            <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100 flex items-start gap-4 sm:gap-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0 text-base sm:text-lg"><i class="fa-solid fa-location-crosshairs"></i></div>
                <div>
                    <h4 class="font-bold text-sm sm:text-base mb-1.5 text-slate-900">Hotspot Interaktif</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">Klik pada ikon penanda interaktif untuk berpindah antar ruangan atau melihat info detail.</p>
                </div>
            </div>
            <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100 flex items-start gap-4 sm:gap-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shrink-0 text-base sm:text-lg"><i class="fa-solid fa-mobile-screen"></i></div>
                <div>
                    <h4 class="font-bold text-sm sm:text-base mb-1.5 text-slate-900">Mobile Ready</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">Dapat diakses melalui smartphone dengan navigasi sentuh yang responsif dan imersif.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script>
    const viewer = pannellum.viewer('panorama', {
        "default": {
            "firstScene": "library",
            "author": "MA At-Taraqqie",
            "sceneFadeDuration": 1000,
            "autoLoad": true
        },

        "scenes": {
            "library": {
                "title": "Perpustakaan Digital",
                "hfov": 110,
                "pitch": -3,
                "yaw": 117,
                "type": "equirectangular",
                "panorama": "https://pannellum.org/images/alma.jpg",
                "hotSpots": [
                    {
                        "pitch": -10,
                        "yaw": 140,
                        "type": "scene",
                        "text": "Menuju Laboratorium",
                        "sceneId": "lab"
                    }
                ]
            },

            "lab": {
                "title": "Laboratorium Terpadu",
                "hfov": 110,
                "yaw": 5,
                "type": "equirectangular",
                "panorama": "https://pannellum.org/images/cerro-toco-0.jpg",
                "hotSpots": [
                    {
                        "pitch": -0.6,
                        "yaw": 37.1,
                        "type": "scene",
                        "text": "Kembali ke Perpustakaan",
                        "sceneId": "library"
                    }
                ]
            },

            "field": {
                "title": "Lapangan Olahraga",
                "hfov": 110,
                "yaw": 5,
                "type": "equirectangular",
                "panorama": "https://pannellum.org/images/alma.jpg",
                "hotSpots": [
                    {
                        "pitch": -5,
                        "yaw": 100,
                        "type": "scene",
                        "text": "Kembali ke Perpustakaan",
                        "sceneId": "library"
                    }
                ]
            }
        }
    });

    function loadScene(id) {
        viewer.loadScene(id);
    }
</script>
@endsection

