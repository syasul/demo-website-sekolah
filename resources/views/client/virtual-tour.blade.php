@extends('layouts.client')

@section('title', 'Virtual Tour 360° — SMA Task Master')

@section('head')
<!-- Pannellum CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
<style>
    #panorama {
        width: 100%;
        height: 70vh;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 40px 100px -20px rgba(0,0,0,0.2);
        border: 8px solid white;
    }
    .custom-hotspot {
        height: 30px;
        width: 30px;
        background: #4f46e5;
        border-radius: 50%;
        border: 3px solid white;
        cursor: pointer;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(79, 70, 229, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
    }
</style>
@endsection

@section('content')
<section class="py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="max-w-xl">
                <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 italic uppercase tracking-tighter">Virtual Tour</h1>
                <p class="text-slate-500 leading-relaxed italic">Jelajahi setiap sudut SMA Task Master secara interaktif dengan teknologi 360°.</p>
            </div>
            <div class="flex gap-4">
                <button onclick="loadScene('library')" class="px-6 py-2 bg-white border border-slate-200 rounded-full text-xs font-bold hover:bg-slate-900 hover:text-white transition-all uppercase">Perpustakaan</button>
                <button onclick="loadScene('lab')" class="px-6 py-2 bg-white border border-slate-200 rounded-full text-xs font-bold hover:bg-slate-900 hover:text-white transition-all uppercase">Laboratorium</button>
                <button onclick="loadScene('field')" class="px-6 py-2 bg-white border border-slate-200 rounded-full text-xs font-bold hover:bg-slate-900 hover:text-white transition-all uppercase">Lapangan</button>
            </div>
        </div>

        <div id="panorama"></div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-100 flex items-start gap-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shrink-0"><i class="fa-solid fa-arrows-to-eye"></i></div>
                <div>
                    <h4 class="font-bold mb-2">Kontrol Navigasi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">Klik dan seret untuk melihat sekeliling. Gunakan scroll untuk memperbesar area.</p>
                </div>
            </div>
            <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-100 flex items-start gap-6">
                <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0"><i class="fa-solid fa-location-crosshairs"></i></div>
                <div>
                    <h4 class="font-bold mb-2">Hotspot Interaktif</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">Klik pada ikon bulat biru untuk berpindah antar ruangan atau melihat info detail.</p>
                </div>
            </div>
            <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-100 flex items-start gap-6">
                <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shrink-0"><i class="fa-solid fa-mobile-screen"></i></div>
                <div>
                    <h4 class="font-bold mb-2">Mobile Ready</h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic">Dapat diakses melalui smartphone dengan dukungan sensor giroskop yang imersif.</p>
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
            "author": "SMA Task Master",
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
                "panorama": "https://pannellum.org/images/alma.jpg", // Placeholder
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
                "panorama": "https://pannellum.org/images/cerro-toco-0.jpg", // Placeholder
                "hotSpots": [
                    {
                        "pitch": -0.6,
                        "yaw": 37.1,
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
