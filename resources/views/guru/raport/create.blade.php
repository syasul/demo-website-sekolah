@extends('guru.layouts.app')

@section('title', 'Input Nilai Raport — ' . $mapel->nama_mapel)
@section('page_title', 'Input Nilai Raport')

@section('content')
<div class="space-y-6">
    <!-- Header info & back button -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-school-primary text-white font-black rounded-xl text-xs">
                    Kelas {{ $kelas->nama_lengkap }}
                </span>
                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-xs">
                    Semester {{ ucfirst($semester) }}
                </span>
                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-xs">
                    TA {{ $tahunAjaran }}
                </span>
            </div>
            <h2 class="text-2xl font-black text-slate-800">{{ $mapel->nama_mapel }} <span class="text-sm font-mono text-slate-400">[{{ $mapel->kode_mapel }}]</span></h2>
            <p class="text-xs text-slate-500 mt-1">Isi nilai pengetahuan (0-100), keterampilan (0-100), predikat sikap, dan catatan untuk tiap siswa.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('guru.raport.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Ganti Kelas/Mapel
            </a>
            <a href="{{ route('guru.raport.rekap', ['kelas_id' => $kelas->id, 'mapel_id' => $mapel->id, 'semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" class="px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl font-bold text-xs transition flex items-center gap-1.5">
                <i class="fa-solid fa-table text-xs"></i>
                <span>Lihat Rekap</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl font-medium text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($isLocked)
    <div class="p-4 bg-amber-50 text-amber-800 border border-amber-200 rounded-2xl font-medium text-xs flex items-center gap-3">
        <i class="fa-solid fa-lock text-amber-500 text-base"></i>
        <div>
            <p class="font-bold">Nilai Semester Ini Telah Dikunci / Difinalisasi</p>
            <p class="text-amber-700 mt-0.5">Nilai hanya dapat dilihat dan tidak dapat diubah lagi. Hubungi Administrator jika terdapat kesalahan data.</p>
        </div>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="p-4 bg-rose-50 text-rose-700 border border-rose-200 rounded-2xl font-medium text-xs">
        <div class="font-bold mb-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>Terdapat beberapa kesalahan:</span>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Mass Grading Form -->
    <form action="{{ route('guru.raport.store') }}" method="POST" id="form-nilai">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
        <input type="hidden" name="semester" value="{{ $semester }}">
        <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-12 text-center">No</th>
                            <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest min-w-[200px]">Nama Siswa</th>
                            <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-32 text-center">Pengetahuan</th>
                            <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-32 text-center">Keterampilan</th>
                            <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-28 text-center">Rata-rata</th>
                            <th class="py-4 px-4 font-bold text-slate-400 text-xs uppercase tracking-widest w-28 text-center">Sikap</th>
                            <th class="py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-widest min-w-[220px]">Catatan Capaian Siswa</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        @forelse($kelas->siswas as $index => $siswa)
                        @php
                            $row = $existingNilai->get($siswa->id);
                            $pengetahuan = old("nilai.{$siswa->id}.pengetahuan", $row?->nilai_pengetahuan);
                            $keterampilan = old("nilai.{$siswa->id}.keterampilan", $row?->nilai_keterampilan);
                            $sikap = old("nilai.{$siswa->id}.sikap", $row?->nilai_sikap ?? 'A');
                            $catatan = old("nilai.{$siswa->id}.catatan", $row?->catatan);
                            $avg = ($pengetahuan !== null && $keterampilan !== null) ? round(($pengetahuan + $keterampilan) / 2, 1) : '-';
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition row-siswa" data-siswa-id="{{ $siswa->id }}">
                            <td class="py-4 px-4 text-center font-mono text-xs text-slate-400 font-bold">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $siswa->name }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $siswa->email }}</div>
                            </td>
                            <!-- Nilai Pengetahuan -->
                            <td class="py-4 px-4 text-center">
                                <input type="number" step="0.1" min="0" max="100" 
                                       name="nilai[{{ $siswa->id }}][pengetahuan]" 
                                       value="{{ $pengetahuan }}"
                                       placeholder="0-100"
                                       {{ $isLocked ? 'disabled' : '' }}
                                       class="input-pengetahuan w-24 text-center py-2 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            </td>
                            <!-- Nilai Keterampilan -->
                            <td class="py-4 px-4 text-center">
                                <input type="number" step="0.1" min="0" max="100" 
                                       name="nilai[{{ $siswa->id }}][keterampilan]" 
                                       value="{{ $keterampilan }}"
                                       placeholder="0-100"
                                       {{ $isLocked ? 'disabled' : '' }}
                                       class="input-keterampilan w-24 text-center py-2 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            </td>
                            <!-- Nilai Akhir / Rata-rata Live Indicator -->
                            <td class="py-4 px-4 text-center">
                                <span class="label-rata font-black text-xs px-2.5 py-1 bg-slate-100 rounded-lg text-slate-700 font-mono">
                                    {{ $avg }}
                                </span>
                            </td>
                            <!-- Nilai Sikap -->
                            <td class="py-4 px-4 text-center">
                                <select name="nilai[{{ $siswa->id }}][sikap]" {{ $isLocked ? 'disabled' : '' }}
                                        class="py-2 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                                    <option value="A" {{ $sikap == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                    <option value="B" {{ $sikap == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                    <option value="C" {{ $sikap == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                    <option value="D" {{ $sikap == 'D' ? 'selected' : '' }}>D (Kurang)</option>
                                </select>
                            </td>
                            <!-- Catatan -->
                            <td class="py-4 px-6">
                                <input type="text" name="nilai[{{ $siswa->id }}][catatan]" 
                                       value="{{ $catatan }}" 
                                       placeholder="Catatan kompetensi siswa..."
                                       {{ $isLocked ? 'disabled' : '' }}
                                       class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 px-6 text-center text-slate-400 text-xs font-medium">
                                Tidak ada siswa terdaftar di kelas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(!$isLocked && $kelas->siswas->count() > 0)
        <!-- Sticky Action Bar -->
        <div class="sticky bottom-4 z-20 bg-slate-900/90 backdrop-blur-md p-4 sm:p-5 rounded-2xl text-white shadow-2xl border border-white/10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-floppy-disk"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-white">Simpan Nilai Kelas {{ $kelas->nama_lengkap }}</p>
                    <p class="text-[11px] text-slate-300">Data tersimpan akan langsung diperbarui pada buku nilai dan raport.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold text-xs shadow-lg shadow-emerald-500/30 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Semua Nilai</span>
                </button>
            </div>
        </div>
        @endif
    </form>
</div>

<script>
    // Realtime Average Calculation on Input
    document.addEventListener('DOMContentLoaded', () => {
        const rows = document.querySelectorAll('.row-siswa');

        rows.forEach(row => {
            const inputP = row.querySelector('.input-pengetahuan');
            const inputK = row.querySelector('.input-keterampilan');
            const labelRata = row.querySelector('.label-rata');

            function updateAvg() {
                const valP = parseFloat(inputP.value);
                const valK = parseFloat(inputK.value);

                if (!isNaN(valP) && !isNaN(valK)) {
                    const avg = ((valP + valK) / 2).toFixed(1);
                    labelRata.textContent = avg;
                    if (avg >= 75) {
                        labelRata.className = 'label-rata font-black text-xs px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-mono';
                    } else {
                        labelRata.className = 'label-rata font-black text-xs px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg font-mono';
                    }
                } else if (!isNaN(valP)) {
                    labelRata.textContent = valP.toFixed(1);
                } else if (!isNaN(valK)) {
                    labelRata.textContent = valK.toFixed(1);
                } else {
                    labelRata.textContent = '-';
                    labelRata.className = 'label-rata font-black text-xs px-2.5 py-1 bg-slate-100 rounded-lg text-slate-700 font-mono';
                }
            }

            if (inputP && inputK) {
                inputP.addEventListener('input', updateAvg);
                inputK.addEventListener('input', updateAvg);
                updateAvg();
            }
        });
    });
</script>
@endsection
