@extends('layouts.admin')

@section('title', 'Pendaftar PPDB')
@section('page_title', 'Data Pendaftar PPDB')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Calon Peserta Didik Baru</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola verifikasi pendaftaran calon siswa baru dan konversi pendaftar yang diterima menjadi siswa aktif.</p>
        </div>
    </div>
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Total Pendaftar</span>
                <span class="text-2xl font-black text-slate-900">{{ $stats['total'] }}</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Menunggu Verifikasi</span>
                <span class="text-2xl font-black text-amber-600">{{ $stats['pending'] }}</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Diterima</span>
                <span class="text-2xl font-black text-emerald-600">{{ $stats['diterima'] }}</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Ditolak</span>
                <span class="text-2xl font-black text-rose-600">{{ $stats['ditolak'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.ppdb.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6 relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama lengkap, no registrasi (PPDB-...), atau no HP..." class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
            </div>

            <div class="sm:col-span-4">
                <select name="status" class="w-full py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    <option value="">-- Semua Status Seleksi --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                    Terapkan
                </button>
                @if (request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.ppdb.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                        <th class="py-4 px-4 text-center w-12">No</th>
                        <th class="py-4 px-5">Calon Peserta Didik</th>
                        <th class="py-4 px-4">No. Registrasi</th>
                        <th class="py-4 px-4">Asal Sekolah</th>
                        <th class="py-4 px-4">No. WhatsApp</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-4 text-center">Akun Siswa</th>
                        <th class="py-4 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($pendaftars as $idx => $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-4 text-center font-medium text-slate-400">
                                {{ $pendaftars->firstItem() + $idx }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $p->nama_lengkap }}</div>
                                <div class="text-xs text-slate-400">JK: {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; NISN: {{ $p->nisn ?: '-' }}</div>
                            </td>
                            <td class="py-4 px-4 font-mono font-bold text-xs text-emerald-700">
                                {{ $p->nomor_pendaftaran }}
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                {{ $p->asal_sekolah ?: '-' }}
                            </td>
                            <td class="py-4 px-4 text-xs font-mono text-slate-700">
                                {{ $p->no_hp }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if ($p->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <i class="fa-solid fa-clock text-[10px]"></i> Pending
                                    </span>
                                @elseif ($p->status === 'diterima')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-check text-[10px]"></i> Diterima
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                        <i class="fa-solid fa-xmark text-[10px]"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if ($p->is_converted)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        <i class="fa-solid fa-user-check"></i> Siswa Aktif
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                <a href="{{ route('admin.ppdb.show', $p->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition-colors">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300 block"></i>
                                Belum ada data pendaftar calon siswa yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendaftars->hasPages())
            <div class="p-5 border-t border-slate-100">
                {{ $pendaftars->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
