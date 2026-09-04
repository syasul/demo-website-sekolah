@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa')
@section('page_title', 'Data Induk Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-extrabold text-lg text-slate-800">Daftar Siswa Sekolah</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data induk siswa, penempatan rombel kelas, import/export Excel, dan akun login.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.siswa.template') }}" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all shadow-xs">
                <i class="fa-solid fa-file-arrow-down text-emerald-600"></i>
                <span>Unduh Template</span>
            </a>
            <a href="{{ route('admin.siswa.import') }}" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 hover:bg-emerald-100 text-xs font-bold transition-all shadow-xs">
                <i class="fa-solid fa-file-excel"></i>
                <span>Import Excel</span>
            </a>
            <a href="{{ route('admin.siswa.export', request()->query()) }}" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 text-xs font-bold transition-all shadow-xs">
                <i class="fa-solid fa-file-export"></i>
                <span>Export Excel</span>
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-md">
                <i class="fa-solid fa-user-plus text-xs"></i>
                <span>Tambah Siswa</span>
            </a>
        </div>
    </div>
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Total Siswa Terdaftar</span>
                <span class="text-2xl font-black text-slate-900">{{ $stats['total'] }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Siswa Aktif</span>
                <span class="text-2xl font-black text-emerald-600">{{ $stats['aktif'] }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Alumni / Lulus</span>
                <span class="text-2xl font-black text-amber-600">{{ $stats['lulus'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIS, atau NISN siswa..." class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
            </div>

            <div class="sm:col-span-3">
                <select name="kelas_id" class="w-full py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            Kelas {{ $k->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <select name="status" class="w-full py-2 text-xs rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50/50">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="lulus" {{ request('status') === 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ request('status') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                    Terapkan
                </button>
                @if (request()->hasAny(['q', 'kelas_id', 'status']))
                    <a href="{{ route('admin.siswa.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Student Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                        <th class="py-4 px-4 text-center w-12">No</th>
                        <th class="py-4 px-5">Profil Siswa</th>
                        <th class="py-4 px-4">NIS / NISN</th>
                        <th class="py-4 px-4 text-center">Kelas</th>
                        <th class="py-4 px-4 text-center">L/P</th>
                        <th class="py-4 px-4">Kontak Wali</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($siswas as $idx => $s)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-4 text-center font-medium text-slate-400">
                                {{ $siswas->firstItem() + $idx }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($s->user ? $s->user->name : 'S', 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="font-bold text-slate-900 truncate">{{ $s->user ? $s->user->name : 'Tanpa Nama' }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $s->user ? $s->user->email : '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-mono text-xs text-slate-700">
                                <div class="font-bold">{{ $s->nis }}</div>
                                <div class="text-[11px] text-slate-400">{{ $s->nisn ?: '-' }}</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if ($s->kelas)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $s->kelas->nama_lengkap }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum assign</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center font-bold text-xs">
                                <span class="{{ $s->jenis_kelamin === 'L' ? 'text-blue-600' : 'text-pink-600' }}">
                                    {{ $s->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                <div>{{ $s->nama_orang_tua ?: '-' }}</div>
                                <div class="text-slate-400 font-mono text-[11px]">{{ $s->no_hp_orang_tua ?: '-' }}</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-md text-xs font-bold
                                    {{ $s->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                    {{ $s->status === 'lulus' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                                    {{ $s->status === 'pindah' ? 'bg-purple-50 text-purple-700 border border-purple-200' : '' }}
                                    {{ $s->status === 'nonaktif' ? 'bg-slate-100 text-slate-600' : '' }}">
                                    {{ ucfirst($s->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <form method="POST" action="{{ route('admin.siswa.reset-password', $s->id) }}" onsubmit="return confirm('Reset password akun siswa ini ke NIS ({{ $s->nis }})?');">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center text-xs transition-colors" title="Reset Password ke NIS">
                                            <i class="fa-solid fa-key"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition-colors" title="Edit Siswa">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? (Data raport akan tetap tersimpan aman via soft delete)');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center text-xs transition-colors" title="Hapus Siswa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-users-slash text-4xl mb-3 text-slate-300 block"></i>
                                Tidak ditemukan data siswa yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($siswas->hasPages())
            <div class="p-5 border-t border-slate-100">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
