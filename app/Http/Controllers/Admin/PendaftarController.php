<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftar;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PendaftarController extends Controller
{
    /**
     * Tampilkan seluruh data pendaftar calon siswa baru (PPDB).
     */
    public function index(Request $request)
    {
        $query = Pendaftar::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nomor_pendaftaran', 'like', "%{$q}%")
                    ->orWhere('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%")
                    ->orWhere('asal_sekolah', 'like', "%{$q}%");
            });
        }

        $pendaftars = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Pendaftar::count(),
            'pending' => Pendaftar::where('status', 'pending')->count(),
            'diterima' => Pendaftar::where('status', 'diterima')->count(),
            'ditolak' => Pendaftar::where('status', 'ditolak')->count(),
        ];

        return view('admin.ppdb.index', compact('pendaftars', 'stats'));
    }

    /**
     * Tampilkan detail pendaftar dan aksi verifikasi.
     */
    public function show(Pendaftar $pendaftar)
    {
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_rombel')->get();
        return view('admin.ppdb.show', compact('pendaftar', 'kelasList'));
    }

    /**
     * Perbarui status pendaftaran (Terima / Tolak) + catatan admin.
     */
    public function updateStatus(Request $request, Pendaftar $pendaftar)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $pendaftar->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        $statusLabel = [
            'pending' => 'Pending (Menunggu)',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ][$request->status];

        return back()->with('success', "Status pendaftaran {$pendaftar->nama_lengkap} diubah menjadi: {$statusLabel}.");
    }

    /**
     * Konversi pendaftar yang berstatus 'diterima' langsung menjadi akun Siswa baru.
     */
    public function konversiSiswa(Request $request, Pendaftar $pendaftar)
    {
        if ($pendaftar->is_converted) {
            return back()->with('error', 'Pendaftar ini sudah pernah dikonversi menjadi siswa aktif.');
        }

        if ($pendaftar->status !== 'diterima') {
            return back()->with('error', 'Pendaftar harus berstatus "Diterima" sebelum dapat dikonversi menjadi siswa.');
        }

        $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS siswa baru wajib ditentukan.',
            'nis.unique' => 'NIS ini sudah digunakan oleh siswa lain.',
            'kelas_id.required' => 'Pilih rombel kelas untuk siswa baru.',
        ]);

        $nis = trim($request->nis);
        $email = 'siswa.' . $nis . '@attaraqqie.sch.id';

        DB::transaction(function () use ($pendaftar, $request, $nis, $email) {
            // 1. Buat User Siswa
            $user = User::create([
                'name' => $pendaftar->nama_lengkap,
                'email' => $email,
                'password' => Hash::make($nis), // Password awal = NIS
                'role' => 'siswa',
                'kelas_id' => $request->kelas_id,
            ]);

            // 2. Buat profil Siswa
            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nis' => $nis,
                'nisn' => $pendaftar->nisn,
                'jenis_kelamin' => $pendaftar->jenis_kelamin,
                'tempat_lahir' => $pendaftar->tempat_lahir,
                'tanggal_lahir' => $pendaftar->tanggal_lahir,
                'alamat' => $pendaftar->alamat,
                'nama_orang_tua' => $pendaftar->nama_orang_tua,
                'no_hp_orang_tua' => $pendaftar->no_hp,
                'status' => 'aktif',
            ]);

            // 3. Tandai pendaftar telah dikonversi
            $pendaftar->update([
                'is_converted' => true,
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', "Pendaftar {$pendaftar->nama_lengkap} berhasil dikonversi menjadi Siswa Baru dengan NIS: {$nis}. Akun login telah dibuat.");
    }
}
