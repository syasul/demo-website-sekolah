@extends('layouts.admin')

@section('title', 'Penugasan Guru')
@section('page_title', 'Kelola Penugasan Guru')

@section('content')
<div class="space-y-8">
    <!-- Header & Teacher Info -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-3xl bg-school-primary/10 text-school-primary font-black text-xl flex items-center justify-center border border-school-primary/20 shadow-sm shrink-0">
                {{ strtoupper(substr($guru->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $guru->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-slate-500 font-medium">{{ $guru->email }}</span>
                    <span class="text-slate-300">•</span>
                    @if($guru->kelasWali)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md text-xs font-bold">
                            <i class="fa-solid fa-id-badge text-[10px]"></i>
                            Wali Kelas {{ $guru->kelasWali->nama_lengkap }}
                        </span>
                    @else
                        <span class="text-xs text-slate-400 font-medium">Bukan Wali Kelas</span>
                    @endif
                </div>
            </div>
        </div>
        <a href="{{ route('admin.guru.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-200 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Data Guru</span>
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl font-medium text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="p-4 bg-rose-50 text-rose-700 border border-rose-200 rounded-2xl font-medium text-xs">
        <div class="font-bold mb-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>Perhatian:</span>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Section 1: Wali Kelas Card (1 Col) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Penetapan Wali Kelas</h3>
                    <p class="text-xs text-slate-400">Tentukan rombel yang dibimbing oleh guru ini.</p>
                </div>
            </div>

            <form action="{{ route('admin.guru.assign.wali', $guru) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="wali_kelas_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pilih Rombongan Belajar</label>
                    <select name="kelas_id" id="wali_kelas_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                        <option value="">-- Bukan Wali Kelas / Kosongkan --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id }}" {{ $guru->kelasWali && $guru->kelasWali->id === $k->id ? 'selected' : '' }}>
                                Kelas {{ $k->nama_lengkap }}
                                @if($k->waliKelas && $k->waliKelas->id !== $guru->id)
                                    (Wali saat ini: {{ $k->waliKelas->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-900 text-white rounded-2xl font-bold text-xs hover:bg-slate-800 transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Wali Kelas</span>
                </button>
            </form>
        </div>

        <!-- Section 2: Penugasan Mata Pelajaran & Kelas (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Form Tambah Penugasan -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Tambah Penugasan Mengajar</h3>
                        <p class="text-xs text-slate-400">Pilih kelas dan mata pelajaran yang diajarkan oleh {{ $guru->name }}.</p>
                    </div>
                </div>

                <form action="{{ route('admin.guru.assign.store', $guru) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="sm:col-span-5">
                        <label for="kelas_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kelas</label>
                        <select name="kelas_id" id="kelas_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelases as $k)
                                <option value="{{ $k->id }}">Kelas {{ $k->nama_lengkap }} (Tingkat {{ $k->tingkat }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-5">
                        <label for="mapel_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Mata Pelajaran</label>
                        <select name="mapel_id" id="mapel_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mapel }} [{{ $m->kode_mapel }}]</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full py-2.5 bg-school-primary text-white rounded-xl font-bold text-xs hover:bg-school-primary/90 transition shadow-lg shadow-school-primary/20 flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-plus"></i>
                            <span>Tugaskan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- List Penugasan Aktif -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 text-sm">Daftar Kelas & Mapel yang Diampu ({{ $guru->guruMapels->count() }})</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="py-3.5 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Kelas</th>
                                <th class="py-3.5 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Mata Pelajaran</th>
                                <th class="py-3.5 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Kode Mapel</th>
                                <th class="py-3.5 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100">
                            @forelse($guru->guruMapels as $gm)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-6 font-bold text-slate-900">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-800 rounded-lg text-xs font-black">
                                        Kelas {{ $gm->kelas->nama_lengkap ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 font-semibold text-slate-700">
                                    {{ $gm->mapel->nama_mapel ?? '-' }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[11px] font-mono font-bold">
                                        {{ $gm->mapel->kode_mapel ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <form action="{{ route('admin.guru.assign.destroy', [$guru, $gm]) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin melepas penugasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold hover:bg-rose-100 transition flex items-center gap-1 ml-auto" title="Lepas Penugasan">
                                            <i class="fa-solid fa-trash-can text-[11px]"></i>
                                            <span>Lepas</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 px-6 text-center text-slate-400 text-xs font-medium">
                                    Belum ada mata pelajaran dan kelas yang ditugaskan ke guru ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
