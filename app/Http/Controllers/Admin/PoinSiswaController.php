<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPoin;
use App\Models\Notifikasi;
use App\Models\PoinSiswa;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoinSiswaController extends Controller
{
    /**
     * Tampilkan riwayat poin kedisiplinan dan prestasi santri.
     */
    public function index(Request $request)
    {
        $tipe = $request->input('tipe');
        $kategoriId = $request->input('kategori_id');

        $kategoris = KategoriPoin::all();

        $query = PoinSiswa::with(['siswa', 'siswaProfile.kelas', 'kategori', 'pencatat', 'unit']);

        if ($tipe) {
            $query->whereHas('kategori', fn($q) => $q->where('tipe', $tipe));
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        $poinList = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_prestasi' => PoinSiswa::whereHas('kategori', fn($q) => $q->where('tipe', 'prestasi'))->count(),
            'total_pelanggaran' => PoinSiswa::whereHas('kategori', fn($q) => $q->where('tipe', 'pelanggaran'))->count(),
            'total_poin_plus' => PoinSiswa::where('poin', '>', 0)->sum('poin'),
            'total_poin_minus' => abs(PoinSiswa::where('poin', '<', 0)->sum('poin')),
        ];

        return view('admin.kedisiplinan.index', compact('poinList', 'kategoris', 'tipe', 'stats'));
    }

    /**
     * Form input poin kedisiplinan atau prestasi.
     */
    public function create()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $kategoris = KategoriPoin::all();

        return view('admin.kedisiplinan.create', compact('siswas', 'kategoris'));
    }

    /**
     * Simpan poin baru ke sistem.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategori_poins,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $kategori = KategoriPoin::findOrFail($request->kategori_id);
        $siswaUser = User::with('siswa')->findOrFail($request->siswa_id);

        $poin = ($kategori->tipe === 'prestasi') ? abs($kategori->bobot) : -abs($kategori->bobot);

        $poinSiswa = PoinSiswa::create([
            'siswa_id' => $siswaUser->id,
            'kategori_id' => $kategori->id,
            'unit_id' => $siswaUser->siswa?->unit_id,
            'poin' => $poin,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'pencatat_id' => Auth::id(),
        ]);

        // Cek total akumulasi poin santri (net score)
        $totalPoin = PoinSiswa::where('siswa_id', $siswaUser->id)->sum('poin');

        // Notifikasi ke Orang Tua
        $parent = $siswaUser->orangTuas->first();
        if ($parent) {
            $judul = ($kategori->tipe === 'prestasi')
                ? "Poin Prestasi Baru: {$kategori->nama}"
                : "Catatan Kedisiplinan: {$kategori->nama}";

            $isi = "Ananda {$siswaUser->name} mendapatkan " . ($poin > 0 ? "+{$poin}" : "{$poin}") . " poin. Catatan: " . ($request->catatan ?: $kategori->nama);

            Notifikasi::create([
                'user_id' => $parent->id,
                'tipe' => 'poin',
                'judul' => $judul,
                'isi' => $isi,
                'link' => '/orang-tua/poin',
            ]);

            // Jika limit pelanggaran terlewati (misal net point < -30)
            if ($totalPoin <= -30) {
                Notifikasi::create([
                    'user_id' => $parent->id,
                    'tipe' => 'poin',
                    'judul' => 'Peringatan Ambang Batas Kedisiplinan',
                    'isi' => "Perhatian: Akumulasi poin kedisiplinan ananda {$siswaUser->name} telah mencapai ambang batas ({$totalPoin} poin). Mohon berkoordinasi dengan Tim BK / Pengasuhan Pesantren.",
                    'link' => '/orang-tua/poin',
                ]);
            }
        }

        return redirect()->route('admin.kedisiplinan.index')->with('success', "Poin untuk {$siswaUser->name} berhasil dicatat.");
    }

    /**
     * Halaman Leaderboard "Student of the Year".
     */
    public function studentOfTheYear(Request $request)
    {
        // Hitung ranking akumulasi poin positif, dikurangi pelanggaran
        $students = User::where('role', 'siswa')
            ->with(['siswa.kelas', 'siswa.unit'])
            ->get()
            ->map(function ($s) {
                $poinPlus = PoinSiswa::where('siswa_id', $s->id)->where('poin', '>', 0)->sum('poin');
                $poinMinus = abs(PoinSiswa::where('siswa_id', $s->id)->where('poin', '<', 0)->sum('poin'));
                $netPoin = $poinPlus - $poinMinus;
                $rataNilai = (float) $s->nilais()->avg('nilai_pengetahuan') ?: 80.0;

                // Formula ranking: 60% Poin Karakter/Prestasi + 40% Rata-rata Akademik
                $finalScore = round(($netPoin * 0.6) + ($rataNilai * 0.4), 1);

                return [
                    'user' => $s,
                    'poin_plus' => $poinPlus,
                    'poin_minus' => $poinMinus,
                    'net_poin' => $netPoin,
                    'rata_nilai' => $rataNilai,
                    'skor_akhir' => $finalScore,
                    'nihil_pelanggaran' => $poinMinus === 0,
                ];
            })
            ->sortByDesc('skor_akhir')
            ->values();

        return view('admin.kedisiplinan.student-of-the-year', compact('students'));
    }
}
