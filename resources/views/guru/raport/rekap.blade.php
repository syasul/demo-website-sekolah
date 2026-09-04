@extends('guru.layouts.app')

@section('title', 'Rekapitulasi Nilai Raport')
@section('page_title', 'Rekapitulasi Nilai Raport')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('guru.raport.rekap') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
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

            <!-- Submit -->
            <div>
                <button type="submit" class="w-full py-2.5 bg-slate-900 text-white rounded-xl font-bold text-xs hover:bg-slate-800 transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fa-solid fa-filter"></i>
                    <span>Tampilkan Rekap</span>
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
        @php
            $gradedList = $nilais->filter(fn($n) => $n->nilai_pengetahuan !== null);
            $avgPengetahuan = $gradedList->count() > 0 ? round($gradedList->avg('nilai_pengetahuan'), 1) : 0;
            $avgKeterampilan = $gradedList->count() > 0 ? round($gradedList->avg('nilai_keterampilan'), 1) : 0;
            $avgTotal = $gradedList->count() > 0 ? round(($avgPengetahuan + $avgKeterampilan) / 2, 1) : 0;
        @endphp

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $kelas->siswas->count() }} <span class="text-xs font-normal text-slate-400">Siswa</span></h4>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Pengetahuan</p>
                <h4 class="text-2xl font-black text-blue-600 mt-1">{{ $avgPengetahuan }}</h4>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Keterampilan</p>
                <h4 class="text-2xl font-black text-emerald-600 mt-1">{{ $avgKeterampilan }}</h4>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nilai Rata-rata Kelas</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $avgTotal }}</h4>
            </div>
        </div>

        <!-- Action Bar: Lock & Print -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-2">
                @if($isLocked)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-xl text-xs font-bold">
                        <i class="fa-solid fa-lock text-[11px]"></i>
                        <span>Status: Terkunci / Final</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold">
                        <i class="fa-solid fa-lock-open text-[11px]"></i>
                        <span>Status: Draft (Dapat diedit)</span>
                    </span>
                @endif
                <span class="text-xs text-slate-400">•</span>
                <span class="text-xs font-medium text-slate-600">{{ $gradedList->count() }} dari {{ $kelas->siswas->count() }} siswa telah dinilai</span>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <form action="{{ route('guru.raport.hitung-ulang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                    <input type="hidden" name="semester" value="{{ $semester }}">
                    <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">
                    <button type="submit" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl font-bold text-xs transition flex items-center gap-1.5" title="Kalkulasi ulang nilai raport dari komponen Tugas, UH, UTS, UAS">
                        <i class="fa-solid fa-arrows-rotate text-xs"></i>
                        <span>Hitung Ulang Bobot</span>
                    </button>
                </form>
                <button onclick="window.print()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-print text-xs"></i>
                    <span>Cetak Ledger</span>
                </button>
                @if(!$isLocked)
                    <a href="{{ route('guru.raport.create', ['kelas_id' => $kelas->id, 'mapel_id' => $mapel->id, 'semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}" class="px-3.5 py-2 bg-school-primary text-white hover:bg-school-primary/90 rounded-xl font-bold text-xs transition shadow-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Edit Sikap/Catatan</span>
                    </a>
                    <form action="{{ route('guru.raport.lock') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengunci nilai semester ini? Setelah dikunci, nilai tidak dapat diubah lagi tanpa izin Admin.');">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                        <input type="hidden" name="semester" value="{{ $semester }}">
                        <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">
                        <button type="submit" class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-xs transition shadow-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span>Kunci Semester</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Recap Table with Components Breakdown -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden print:shadow-none print:border-none">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-3 text-center w-10">No</th>
                            <th class="py-3 px-4 min-w-[170px]">Nama Siswa</th>
                            <th class="py-3 px-2 text-center text-blue-600">Tugas (20%)</th>
                            <th class="py-3 px-2 text-center text-amber-600">UH (30%)</th>
                            <th class="py-3 px-2 text-center text-purple-600">UTS (20%)</th>
                            <th class="py-3 px-2 text-center text-indigo-600">UAS (30%)</th>
                            <th class="py-3 px-3 text-center bg-slate-100/70 text-slate-700">Nilai Akhir</th>
                            <th class="py-3 px-2 text-center">Predikat</th>
                            <th class="py-3 px-3 text-center">Status Remidi</th>
                            <th class="py-3 px-2 text-center">Sikap</th>
                            <th class="py-3 px-4 min-w-[180px]">Catatan Guru</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-slate-100">
                        @forelse($kelas->siswas as $index => $siswa)
                        @php
                            $row = $nilais->get($siswa->id);
                            $siswaKomponens = isset($komponens) && $komponens->has($siswa->id) ? $komponens->get($siswa->id) : collect();
                            
                            $tugasItems = $siswaKomponens->where('jenis', 'tugas');
                            $avgTugas = $tugasItems->isNotEmpty() ? round($tugasItems->avg('nilai'), 1) : '-';

                            $uhItems = $siswaKomponens->where('jenis', 'uh');
                            $avgUh = $uhItems->isNotEmpty() ? round($uhItems->avg('nilai'), 1) : '-';

                            $utsItem = $siswaKomponens->where('jenis', 'uts')->first();
                            $valUts = $utsItem ? $utsItem->nilai : '-';

                            $uasItem = $siswaKomponens->where('jenis', 'uas')->first();
                            $valUas = $uasItem ? $uasItem->nilai : '-';

                            $kkm = $mapel->kkm ?? 75;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-3 text-center font-mono text-slate-400 font-bold">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ $siswa->name }}</td>
                            <td class="py-3.5 px-2 text-center font-mono">{{ $avgTugas }}</td>
                            <td class="py-3.5 px-2 text-center font-mono">{{ $avgUh }}</td>
                            <td class="py-3.5 px-2 text-center font-mono">{{ $valUts }}</td>
                            <td class="py-3.5 px-2 text-center font-mono">{{ $valUas }}</td>
                            <td class="py-3.5 px-3 text-center bg-slate-50/60 font-black font-mono">
                                @if($row && $row->nilai_pengetahuan !== null)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs {{ $row->nilai_pengetahuan >= $kkm ? 'text-emerald-700 font-black' : 'text-rose-600 font-black' }}">
                                        {{ $row->nilai_pengetahuan }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-2 text-center font-bold text-slate-600">
                                {{ $row ? $row->predikat : '-' }}
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                @if($row && $row->status_remidi == 'perlu')
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded text-[10px] font-bold">
                                        Perlu Remidi
                                    </span>
                                @elseif($row && $row->status_remidi == 'sudah_remidi')
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[10px] font-bold">
                                        Sudah Remidi
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-medium">
                                        Tuntas
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-2 text-center font-bold">
                                <span class="px-2 py-0.5 bg-slate-100 rounded text-[11px] text-slate-700">
                                    {{ $row->nilai_sikap ?? 'A' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 text-[11px]">
                                {{ $row?->catatan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="py-12 px-6 text-center text-slate-400 text-xs font-medium">
                                Belum ada data siswa di kelas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white p-12 rounded-3xl border border-slate-100 text-center">
            <p class="text-slate-400 text-sm font-medium">Silakan pilih kelas dan mata pelajaran pada filter di atas.</p>
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
