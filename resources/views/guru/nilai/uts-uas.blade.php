@extends('guru.layouts.app')

@section('title', 'Penilaian UTS & UAS')
@section('page_title', 'Penilaian UTS & UAS')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('guru.nilai.uts-uas') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
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
    <div class="bg-blue-50/70 p-4 border border-blue-100 rounded-2xl flex items-center gap-3 text-xs text-blue-800">
        <i class="fa-solid fa-circle-info text-blue-500 text-base"></i>
        <div>
            <span class="font-bold">Informasi Pembobotan Penilaian:</span>
            Nilai UTS memiliki bobot <span class="font-bold">20%</span> dan UAS memiliki bobot <span class="font-bold">30%</span> pada akumulasi Nilai Pengetahuan Raport.
        </div>
    </div>

    <form action="{{ route('guru.nilai.uts-uas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
        <input type="hidden" name="semester" value="{{ $semester }}">
        <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h4 class="font-bold text-slate-800 text-sm">Input Nilai UTS & UAS — Kelas {{ $kelas->nama_lengkap }} ({{ $mapel->nama_mapel }})</h4>
                <span class="text-xs text-slate-400 font-mono">KKM: {{ $mapel->kkm ?? 75 }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-12 text-center">No</th>
                            <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest">Nama Lengkap Siswa</th>
                            <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest w-48 text-center">Nilai UTS (Bobot 20%)</th>
                            <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest w-48 text-center">Nilai UAS (Bobot 30%)</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        @forelse($kelas->siswas as $idx => $siswa)
                        @php
                            $uts = $utsRecords->get($siswa->id);
                            $uas = $uasRecords->get($siswa->id);
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-4 text-center font-mono text-xs text-slate-400 font-bold">{{ $idx + 1 }}</td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800">{{ $siswa->name }}</span>
                                <span class="text-xs text-slate-400 font-mono block">{{ $siswa->email }}</span>
                            </td>
                            <!-- Nilai UTS -->
                            <td class="py-4 px-6 text-center">
                                <input type="number" step="0.1" min="0" max="100" 
                                       name="nilai_uts[{{ $siswa->id }}]" 
                                       value="{{ old('nilai_uts.' . $siswa->id, $uts?->nilai) }}" 
                                       placeholder="0-100"
                                       class="w-32 text-center py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            </td>
                            <!-- Nilai UAS -->
                            <td class="py-4 px-6 text-center">
                                <input type="number" step="0.1" min="0" max="100" 
                                       name="nilai_uas[{{ $siswa->id }}]" 
                                       value="{{ old('nilai_uas.' . $siswa->id, $uas?->nilai) }}" 
                                       placeholder="0-100"
                                       class="w-32 text-center py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 px-6 text-center text-slate-400 text-xs">
                                Tidak ada siswa terdaftar di kelas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-school-primary hover:bg-school-primary/90 text-white rounded-xl font-bold text-xs shadow-lg shadow-school-primary/30 transition flex items-center gap-2">
                <i class="fa-solid fa-save"></i>
                <span>Simpan Nilai UTS & UAS</span>
            </button>
        </div>
    </form>
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
