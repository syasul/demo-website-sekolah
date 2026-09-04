@extends('guru.layouts.app')

@section('title', 'Tugas & Ulangan Harian')
@section('page_title', 'Tugas & Ulangan Harian (UH)')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('guru.nilai.tugas-uh') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
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

    @if($kelas && $mapel)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Form Tambah Sesi & Nilai Siswa (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Buat Sesi Tugas / UH Baru</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Input nilai 1 per 1 untuk seluruh siswa kelas {{ $kelas->nama_lengkap }}.</p>
                    </div>
                    <span class="px-3 py-1 bg-school-primary/10 text-school-primary font-bold text-xs rounded-xl">
                        KKM: {{ $mapel->kkm ?? 75 }}
                    </span>
                </div>

                <form action="{{ route('guru.nilai.tugas-uh.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                    <input type="hidden" name="semester" value="{{ $semester }}">
                    <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Jenis -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jenis Penilaian</label>
                            <select name="jenis" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                                <option value="tugas">Tugas Harian / PR</option>
                                <option value="uh">Ulangan Harian (UH)</option>
                            </select>
                        </div>

                        <!-- Judul -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama / Judul Sesi</label>
                            <input type="text" name="judul" required placeholder="Contoh: Tugas 1 / UH Bab 2" 
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tanggal Penilaian</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                        </div>
                    </div>

                    <!-- Input Nilai Per Siswa -->
                    <div class="border border-slate-100 rounded-2xl overflow-hidden">
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-600 flex justify-between items-center">
                            <span>Daftar Siswa ({{ $kelas->siswas->count() }} Orang)</span>
                            <span class="text-slate-400 font-normal text-[11px]">Rentang Nilai 0 - 100</span>
                        </div>
                        <div class="max-h-96 overflow-y-auto divide-y divide-slate-100">
                            @foreach($kelas->siswas as $idx => $siswa)
                            <div class="p-3.5 flex items-center justify-between hover:bg-slate-50/70 transition">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 text-xs font-mono font-bold text-slate-400">{{ $idx + 1 }}</span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">{{ $siswa->name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $siswa->email }}</p>
                                    </div>
                                </div>
                                <div class="w-28">
                                    <input type="number" step="0.1" min="0" max="100" 
                                           name="nilai[{{ $siswa->id }}]" 
                                           placeholder="Nilai..."
                                           class="w-full text-center py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:bg-white focus:ring-2 focus:ring-school-primary/20 focus:border-school-primary transition">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-3 bg-school-primary hover:bg-school-primary/90 text-white rounded-xl font-bold text-xs shadow-lg shadow-school-primary/30 transition flex items-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            <span>Simpan Sesi & Nilai</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Sesi yang Sudah Diinput (1 Col) -->
        <div class="space-y-4">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="font-bold text-slate-800 text-sm mb-1">Riwayat Sesi Penilaian ({{ $sessions->count() }})</h4>
                <p class="text-xs text-slate-400 mb-4">Daftar tugas & UH yang telah diinput semester ini.</p>

                <div class="space-y-3">
                    @forelse($sessions as $s)
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $s['jenis'] == 'uh' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $s['jenis'] == 'uh' ? 'Ulangan Harian' : 'Tugas Harian' }}
                            </span>
                            <form action="{{ route('guru.nilai.tugas-uh.destroy') }}" method="POST" onsubmit="return confirm('Hapus seluruh nilai untuk sesi ini?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                                <input type="hidden" name="semester" value="{{ $semester }}">
                                <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">
                                <input type="hidden" name="jenis" value="{{ $s['jenis'] }}">
                                <input type="hidden" name="judul" value="{{ $s['judul'] }}">
                                <button type="submit" class="text-slate-400 hover:text-rose-600 text-xs transition" title="Hapus Sesi">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                        <h5 class="font-bold text-slate-800 text-xs">{{ $s['judul'] }}</h5>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-200/50 text-[11px] text-slate-500">
                            <span>{{ $s['count'] }} Siswa Dinilai</span>
                            <span class="font-bold text-slate-700">Rata-rata: {{ $s['avg'] }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400 text-xs">
                        Belum ada sesi tugas atau UH yang diinput untuk kelas ini.
                    </div>
                    @endforelse
                </div>
            </div>
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
