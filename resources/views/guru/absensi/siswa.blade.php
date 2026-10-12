@extends('guru.layouts.app')

@section('title', 'Presensi Santri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Presensi Santri</h1>
            <p class="text-sm text-slate-500 mt-1">Pencatatan kehadiran santri harian dan per mata pelajaran terintegrasi notifikasi wali santri.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <i class="fa-solid fa-bell text-emerald-500"></i> Auto-Notifikasi Wali
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filter Kelas & Tanggal -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('guru.absensi.siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rombel / Kelas</label>
                <select name="kelas_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $selectedKelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_lengkap }} ({{ $k->unit ? $k->unit->nama : 'Umum' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Presensi</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
            </div>

            @if ($mapels->isNotEmpty())
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Mata Pelajaran (Opsional)</label>
                <select name="mapel_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                    <option value="">-- Presensi Harian Umum --</option>
                    @foreach ($mapels as $m)
                        <option value="{{ $m->id }}" {{ $mapelId == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <button type="submit" class="w-full px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i> Muat Siswa
                </button>
            </div>
        </form>
    </div>

    <!-- Form Presensi Siswa -->
    @if ($selectedKelas && $siswas->isNotEmpty())
        <form method="POST" action="{{ route('guru.absensi.siswa.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="mapel_id" value="{{ $mapelId }}">

            <!-- Quick Action Bar -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-5 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-lg shadow-emerald-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="font-bold text-base">{{ $selectedKelas->nama_lengkap }} — {{ $siswas->count() }} Santri</div>
                        <div class="text-xs text-emerald-100">Unit: {{ $selectedKelas->unit?->nama ?? 'Semua Unit' }} • Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="setAllStatus('hadir')" class="px-4 py-2 rounded-xl bg-white/20 hover:bg-white text-white hover:text-emerald-800 font-bold text-xs transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-check-double"></i> Set Semua Hadir
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-white text-emerald-800 hover:bg-emerald-50 font-black text-xs shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Presensi
                    </button>
                </div>
            </div>

            <!-- Tabel Siswa -->
            <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-black uppercase tracking-wider text-slate-500">
                                <th class="py-4 px-6 w-12 text-center">No</th>
                                <th class="py-4 px-6">Santri</th>
                                <th class="py-4 px-6 text-center">Status Kehadiran</th>
                                <th class="py-4 px-6">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach ($siswas as $index => $siswa)
                                @php
                                    $userId = $siswa->user_id;
                                    $current = $existingAbsensi->get($userId);
                                    $statusVal = $current ? $current->status : 'hadir';
                                    $ketVal = $current ? $current->keterangan : '';
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-4 px-6 text-center font-bold text-slate-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs border border-slate-200">
                                                {{ strtoupper(substr($siswa->user?->name ?? 'S', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 leading-tight">{{ $siswa->user?->name ?? 'Santri' }}</div>
                                                <div class="text-xs text-slate-400 mt-0.5">NIS: {{ $siswa->nis ?? '-' }} • NISN: {{ $siswa->nisn ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $userId }}][status]" value="hadir" class="sr-only peer status-radio" data-user="{{ $userId }}" {{ $statusVal === 'hadir' ? 'checked' : '' }}>
                                                <span class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 peer-checked:shadow-sm transition-all inline-block">
                                                    Hadir
                                                </span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $userId }}][status]" value="izin" class="sr-only peer status-radio" data-user="{{ $userId }}" {{ $statusVal === 'izin' ? 'checked' : '' }}>
                                                <span class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 peer-checked:bg-amber-500 peer-checked:text-white peer-checked:border-amber-500 peer-checked:shadow-sm transition-all inline-block">
                                                    Izin
                                                </span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $userId }}][status]" value="sakit" class="sr-only peer status-radio" data-user="{{ $userId }}" {{ $statusVal === 'sakit' ? 'checked' : '' }}>
                                                <span class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-500 peer-checked:shadow-sm transition-all inline-block">
                                                    Sakit
                                                </span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="absensi[{{ $userId }}][status]" value="alpa" class="sr-only peer status-radio" data-user="{{ $userId }}" {{ $statusVal === 'alpa' ? 'checked' : '' }}>
                                                <span class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 peer-checked:bg-rose-600 peer-checked:text-white peer-checked:border-rose-600 peer-checked:shadow-sm transition-all inline-block">
                                                    Alpa
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <input type="text" name="absensi[{{ $userId }}][keterangan]" value="{{ $ketVal }}" placeholder="Catatan/alasan (opsional)" class="w-full px-3.5 py-1.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs font-medium text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-slate-50/80 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i>
                        <span>Santri berstatus <b>Izin, Sakit, atau Alpa</b> akan otomatis mengirimkan notifikasi instan ke Wali Santri.</span>
                    </div>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 transition-all shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Simpan Presensi Hari Ini
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-users-slash"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-lg">Tidak Ada Data Santri</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Silakan pilih rombel/kelas lain pada filter di atas untuk melakukan presensi santri.</p>
        </div>
    @endif
</div>

<script>
    function setAllStatus(status) {
        document.querySelectorAll('.status-radio[value="' + status + '"]').forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endsection
