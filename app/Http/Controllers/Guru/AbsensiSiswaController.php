<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiSiswaController extends Controller
{
    /**
     * Tampilkan form input absensi santri.
     */
    public function index(Request $request)
    {
        $guru = Auth::user();
        $kelasIds = $guru->guruMapels->pluck('kelas_id')->unique();

        $kelasList = Kelas::whereIn('id', $kelasIds)->with('unit')->get();
        if ($kelasList->isEmpty()) {
            $kelasList = Kelas::with('unit')->get();
        }

        $selectedKelasId = $request->input('kelas_id', $kelasList->first()?->id);
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $mapelId = $request->input('mapel_id');

        $selectedKelas = Kelas::with('unit')->find($selectedKelasId);

        $siswas = collect();
        if ($selectedKelas) {
            $siswas = Siswa::with('user')
                ->where('kelas_id', $selectedKelas->id)
                ->where('status', 'aktif')
                ->get();
        }

        // Get existing attendance records for the date and class
        $existingAbsensi = AbsensiSiswa::where('kelas_id', $selectedKelasId)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        $mapels = $guru->guruMapels->where('kelas_id', $selectedKelasId)->pluck('mapel')->unique();

        return view('guru.absensi.siswa', compact('kelasList', 'selectedKelas', 'selectedKelasId', 'tanggal', 'mapelId', 'siswas', 'existingAbsensi', 'mapels'));
    }

    /**
     * Simpan absensi siswa massal.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
        ]);

        $guru = Auth::user();
        $kelas = Kelas::with('unit')->findOrFail($request->kelas_id);
        $tanggal = $request->tanggal;
        $mapelId = $request->mapel_id ?: null;

        $count = 0;
        foreach ($request->absensi as $siswaUserId => $data) {
            $status = $data['status'] ?? 'hadir';
            $keterangan = $data['keterangan'] ?? null;

            AbsensiSiswa::updateOrCreate(
                [
                    'siswa_id' => $siswaUserId,
                    'kelas_id' => $kelas->id,
                    'tanggal' => $tanggal,
                ],
                [
                    'unit_id' => $kelas->unit_id,
                    'mapel_id' => $mapelId,
                    'guru_id' => $guru->id,
                    'status' => $status,
                    'keterangan' => $keterangan,
                ]
            );

            // Jika status tidak hadir (izin, sakit, alpa), kirim notifikasi ke orang tua
            if (in_array($status, ['izin', 'sakit', 'alpa'])) {
                $siswaUser = User::find($siswaUserId);
                if ($siswaUser && $siswaUser->orangTuas->isNotEmpty()) {
                    $parent = $siswaUser->orangTuas->first();
                    $statusLabel = strtoupper($status);
                    Notifikasi::create([
                        'user_id' => $parent->id,
                        'tipe' => 'absen',
                        'judul' => "Presensi Harian: Ananda {$statusLabel}",
                        'isi' => "Pemberitahuan kehadiran: Ananda {$siswaUser->name} pada tanggal " . Carbon::parse($tanggal)->translatedFormat('d F Y') . " tercatat {$statusLabel}. Keterangan: " . ($keterangan ?: 'Tidak ada keterangan tambahan.'),
                        'link' => '/orang-tua/absensi',
                    ]);
                }
            }

            $count++;
        }

        return back()->with('success', "Presensi {$count} santri kelas {$kelas->nama_lengkap} tanggal {$tanggal} berhasil disimpan.");
    }
}
