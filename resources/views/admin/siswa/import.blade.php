@extends('layouts.admin')

@section('title', 'Import Data Siswa')
@section('page_title', 'Import Data Siswa Excel')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Unggah Spreadsheet Data Siswa</h3>
            <p class="text-xs text-slate-500 mt-0.5">Unggah berkas spreadsheet (.xlsx/.xls/.csv), verifikasi pratinjau data, dan generate akun siswa secara massal.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.siswa.template') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all shadow-xs">
                <i class="fa-solid fa-file-arrow-down text-emerald-600"></i>
                <span>Unduh Format Template</span>
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>
    <!-- Step 1 & 2 Instruction Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black shrink-0">1</div>
            <div>
                <h4 class="font-bold text-sm text-slate-900">Unduh Format Baku</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Gunakan format kolom yang telah disediakan agar data NIS, Kelas, dan identitas dapat dipetakan secara akurat.</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-black shrink-0">2</div>
            <div>
                <h4 class="font-bold text-sm text-slate-900">Unggah & Pratinjau</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Sistem memvalidasi NIS ganda dan mencocokkan nama rombel kelas sebelum disimpan ke database.</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center font-black shrink-0">3</div>
            <div>
                <h4 class="font-bold text-sm text-slate-900">Auto-Generate Akun</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Setiap siswa valid otomatis mendapatkan akun login dengan kata sandi awal disamakan dengan nomor NIS.</p>
            </div>
        </div>
    </div>

    <!-- Upload Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.siswa.import.preview') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label for="file_excel" class="block text-sm font-bold text-slate-800 mb-2">
                    Pilih Berkas Excel / CSV Siswa <span class="text-rose-500">*</span>
                </label>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <input type="file" id="file_excel" name="file_excel" required accept=".xlsx,.xls,.csv"
                        class="block w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-300 rounded-2xl p-2 bg-slate-50/50">
                    
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-md shrink-0 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                        <span>Periksa & Pratinjau Data</span>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Dukungan format: .xlsx, .xls, .csv (Maksimal ukuran file: 5 MB).</p>
                @error('file_excel')
                    <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </div>

    <!-- Preview Results Section (Displayed after upload) -->
    @if (!empty($hasPreview) && isset($previewRows))
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Hasil Verifikasi & Pratinjau Berkas</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Periksa keabsahan data sebelum mengonfirmasi penyimpanan ke database.</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ $validCount }} Baris Siap Simpan</span>
                    </span>
                    @if ($invalidCount > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <span>{{ $invalidCount }} Baris Mengandung Masalah</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Preview Table -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-bold text-slate-600 uppercase tracking-wider border-b border-slate-200">
                            <th class="py-3 px-3 text-center w-12">Baris</th>
                            <th class="py-3 px-3">NIS</th>
                            <th class="py-3 px-3">NISN</th>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-3 text-center">Kelas</th>
                            <th class="py-3 px-3 text-center">L/P</th>
                            <th class="py-3 px-3">Nama Wali</th>
                            <th class="py-3 px-4 text-center">Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($previewRows as $r)
                            <tr class="{{ $r['is_valid'] ? 'hover:bg-slate-50/50' : 'bg-rose-50/40 hover:bg-rose-50/70' }} transition-colors">
                                <td class="py-3 px-3 text-center font-mono text-slate-400">#{{ $r['row_number'] }}</td>
                                <td class="py-3 px-3 font-mono font-bold text-slate-800">{{ $r['nis'] ?: '-' }}</td>
                                <td class="py-3 px-3 font-mono text-slate-500">{{ $r['nisn'] ?: '-' }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $r['nama'] ?: '-' }}</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded-md font-bold text-[11px] {{ $r['kelas_id'] ? 'bg-slate-100 text-slate-800' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $r['kelas_nama'] ?: 'Kosong' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center font-bold">{{ $r['jenis_kelamin'] }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $r['nama_orang_tua'] ?: '-' }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if ($r['is_valid'])
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                            <i class="fa-solid fa-check"></i> Valid
                                        </span>
                                    @else
                                        <div class="text-left text-rose-600 space-y-0.5">
                                            @foreach ($r['errors'] as $err)
                                                <div class="flex items-center gap-1 text-[11px] font-semibold">
                                                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                                    <span>{{ $err }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Confirmation Action -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500">
                    Baris yang berstatus <strong>Valid ({{ $validCount }})</strong> akan langsung diproses dan dibuatkan akun login. Baris yang bermasalah akan otomatis dilewati.
                </p>

                @if ($validCount > 0)
                    <form method="POST" action="{{ route('admin.siswa.import.process') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md shadow-emerald-900/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Simpan & Buat Akun Siswa ({{ $validCount }} Data)</span>
                        </button>
                    </form>
                @else
                    <button disabled class="px-6 py-3 rounded-2xl bg-slate-200 text-slate-400 text-xs font-bold cursor-not-allowed">
                        Tidak Ada Data Valid untuk Disimpan
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
