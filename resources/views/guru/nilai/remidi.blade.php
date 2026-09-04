@extends('guru.layouts.app')

@section('title', 'Program Remedial')
@section('page_title', 'Program Remedial (Remidi)')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('guru.nilai.remidi') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <!-- Kelas & Mapel Dropdown -->
            <div class="lg:col-span-2">
                <label for="penugasan_select" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pilih Kelas & Mapel</label>
                <select id="penugasan_select" onchange="updateSelection(this)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                    @foreach($guruMapels as $gm)
                        <option value="{{ $gm->kelas_id }}_{{ $gm->mapel_id }}" {{ ($selectedKelasId == $gm->kelas_id && $selectedMapelId == $gm->mapel_id) ? 'selected' : '' }}>
                            Kelas {{ $gm->kelas->nama_lengkap }} — {{ $gm->mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="kelas_id" id="hidden_kelas_id" value="{{ $selectedKelasId }}">
                <input type="hidden" name="mapel_id" id="hidden_mapel_id" value="{{ $selectedMapelId }}">
            </div>

            <!-- Semester -->
            <div>
                <label for="semester" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Semester</label>
                <select name="semester" id="semester" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                    <option value="ganjil" {{ $semester == 'ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                    <option value="genap" {{ $semester == 'genap' ? 'selected' : '' }}>Semester Genap</option>
                </select>
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label for="tahun_ajaran" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                    <option value="2025/2026" {{ $tahunAjaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    <option value="2024/2025" {{ $tahunAjaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-slate-900 text-white rounded-xl font-bold text-xs hover:bg-slate-800 transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fa-solid fa-filter"></i>
                    <span>Terapkan</span>
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl font-medium text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($kelas && $mapel)
    <!-- Info Banner KKM & Aturan Remidi -->
    <div class="bg-amber-50/80 p-5 border border-amber-200 rounded-3xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 font-black text-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-bold text-amber-900 text-sm">Ketentuan Remedial — KKM: {{ $kkm }}</h4>
                <p class="text-xs text-amber-800 mt-0.5 max-w-xl">
                    Siswa yang memperoleh nilai Ulangan Harian di bawah {{ $kkm }} otomatis masuk ke daftar ini. Nilai remedial akan menggantikan nilai lama dengan batas nilai maksimal diakui setara KKM ({{ $kkm }}).
                </p>
            </div>
        </div>
        <span class="px-4 py-2 bg-white text-amber-900 font-black text-xs rounded-xl shadow-sm border border-amber-200 shrink-0">
            {{ $remedialCandidates->where('status', 'perlu_remidi')->count() }} Siswa Perlu Remidi
        </span>
    </div>

    <!-- Table Remedial -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h4 class="font-bold text-slate-800 text-sm">Daftar Ulangan Harian di Bawah KKM</h4>
            <span class="text-xs text-slate-400">Kelas {{ $kelas->nama_lengkap }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-12 text-center">No</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Nama Lengkap Siswa</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Sesi Ulangan Harian</th>
                        <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest text-center">Nilai Asli</th>
                        <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest text-center">Nilai Diakui</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest text-center">Input Nilai Remidi</th>
                        <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($remedialCandidates as $idx => $cand)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-4 px-4 text-center font-mono text-xs text-slate-400 font-bold">{{ $idx + 1 }}</td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-800">{{ $cand['siswa']->name }}</span>
                            <span class="text-xs text-slate-400 font-mono block">{{ $cand['siswa']->email }}</span>
                        </td>
                        <td class="py-4 px-6 font-medium text-slate-700">
                            {{ $cand['uh']->judul }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-black font-mono">
                                {{ $cand['nilai_asli'] }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-black text-xs font-mono {{ $cand['effective_score'] >= $kkm ? 'text-emerald-700' : 'text-slate-700' }}">
                                {{ $cand['effective_score'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <form action="{{ route('guru.nilai.remidi.store') }}" method="POST" class="flex items-center justify-center gap-2">
                                @csrf
                                <input type="hidden" name="uh_id" value="{{ $cand['uh']->id }}">
                                <input type="number" step="0.1" min="0" max="100" 
                                       name="nilai_remidi" 
                                       value="{{ $cand['remidi'] ? $cand['remidi']->nilai : '' }}" 
                                       placeholder="Nilai..."
                                       required
                                       class="w-24 text-center py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                                <button type="submit" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold text-xs transition shadow-sm" title="Simpan Remidi">
                                    Simpan
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($cand['status'] == 'sudah_remidi')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-bold">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                    Sudah Remidi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold animate-pulse">
                                    <i class="fa-solid fa-clock text-[10px]"></i>
                                    Perlu Remidi
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-6 text-center text-slate-400 text-xs">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 text-xl">
                                <i class="fa-solid fa-shield-heart"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-700">Tidak Ada Siswa yang Memerlukan Remedial</p>
                            <p class="text-xs text-slate-400 mt-1">Seluruh nilai Ulangan Harian siswa di kelas ini telah tuntas mencapai nilai KKM ({{ $kkm }}).</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script>
    function updateSelection(selectElem) {
        const val = selectElem.value;
        if (val) {
            const parts = val.split('_');
            document.getElementById('hidden_kelas_id').value = parts[0];
            document.getElementById('hidden_mapel_id').value = parts[1];
        }
    }
</script>
@endsection
