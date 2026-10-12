<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    /**
     * Tampilkan halaman formulir dan informasi PPDB.
     */
    public function index()
    {
        $jenjangs = \App\Models\Jenjang::with('units')->where('aktif', true)->get();
        return view('client.ppdb', compact('jenjangs'));
    }

    /**
     * Simpan pendaftaran siswa baru secara online.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'jenjang_id' => 'nullable|exists:jenjangs,id',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'asal_sekolah' => 'nullable|string|max:255',
            'nama_orang_tua' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:25',
            'alamat' => 'nullable|string',
        ], [
            'nama_lengkap.required' => 'Nama lengkap calon siswa wajib diisi.',
            'no_hp.required' => 'Nomor WhatsApp / HP yang aktif wajib diisi.',
        ]);

        $nomorPendaftaran = Pendaftar::generateNomor();

        $gender = ($request->jenis_kelamin === 'L') ? 'putra' : 'putri';
        $unitId = null;
        if ($request->filled('jenjang_id')) {
            $unit = \App\Models\Unit::where('jenjang_id', $request->jenjang_id)
                ->where('gender', $gender)
                ->first();
            $unitId = $unit?->id;
        }

        $pendaftar = Pendaftar::create([
            'nomor_pendaftaran' => $nomorPendaftaran,
            'nama_lengkap' => $request->nama_lengkap,
            'nisn' => $request->nisn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jenjang_id' => $request->jenjang_id,
            'unit_id' => $unitId,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'asal_sekolah' => $request->asal_sekolah,
            'nama_orang_tua' => $request->nama_orang_tua,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => 'pending',
        ]);

        return back()->with('ppdb_success', [
            'nomor' => $nomorPendaftaran,
            'nama' => $pendaftar->nama_lengkap,
        ]);
    }

    /**
     * Cek status verifikasi pendaftaran PPDB.
     */
    public function cekStatus(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));
        $pendaftar = null;

        if (! empty($keyword)) {
            $pendaftar = Pendaftar::where('nomor_pendaftaran', $keyword)
                ->orWhere('no_hp', $keyword)
                ->orWhere('nisn', $keyword)
                ->first();
        }

        return view('client.ppdb-status', compact('pendaftar', 'keyword'));
    }
}
