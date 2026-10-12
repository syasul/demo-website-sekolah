<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanSppController extends Controller
{
    /**
     * Tampilkan data tagihan SPP dan status pembayaran.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $periode = $request->input('periode');
        $q = $request->input('q');

        $query = Tagihan::with(['siswa', 'siswaProfile.kelas', 'unit', 'pembayarans']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($periode) {
            $query->where('periode', $periode);
        }

        if ($q) {
            $query->whereHas('siswa', fn($sq) => $sq->where('name', 'like', "%{$q}%"));
        }

        $tagihans = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_tagihan' => Tagihan::count(),
            'total_lunas' => Tagihan::where('status', 'lunas')->count(),
            'total_belum' => Tagihan::where('status', 'belum')->count(),
            'nominal_terkumpul' => Tagihan::where('status', 'lunas')->sum('nominal'),
            'nominal_tunggakan' => Tagihan::where('status', 'belum')->sum('nominal'),
        ];

        $kelasList = Kelas::with('unit')->orderBy('tingkat')->orderBy('nama_rombel')->get();

        return view('admin.keuangan.index', compact('tagihans', 'stats', 'kelasList', 'status', 'periode', 'q'));
    }

    /**
     * Generate tagihan SPP massal per rombel / kelas.
     */
    public function generateMassal(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'periode' => 'required|string',
            'nominal' => 'required|numeric|min:1000',
            'jatuh_tempo' => 'required|date',
        ]);

        $kelas = Kelas::with('unit')->findOrFail($request->kelas_id);
        $siswas = Siswa::where('kelas_id', $kelas->id)->where('status', 'aktif')->get();

        $count = 0;
        foreach ($siswas as $siswa) {
            $exists = Tagihan::where('siswa_id', $siswa->user_id)
                ->where('periode', $request->periode)
                ->exists();

            if (! $exists) {
                Tagihan::create([
                    'siswa_id' => $siswa->user_id,
                    'unit_id' => $siswa->unit_id ?: $kelas->unit_id,
                    'periode' => $request->periode,
                    'nominal' => $request->nominal,
                    'jatuh_tempo' => $request->jatuh_tempo,
                    'status' => 'belum',
                ]);
                $count++;
            }
        }

        return back()->with('success', "Berhasil men-generate {$count} tagihan SPP untuk kelas {$kelas->nama_lengkap} periode {$request->periode}.");
    }

    /**
     * Catat pembayaran tagihan manual (Kasir TU / Bukti Transfer).
     */
    public function catatPembayaran(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
            'metode' => 'required|string',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        Pembayaran::create([
            'tagihan_id' => $tagihan->id,
            'nominal' => $request->nominal,
            'metode' => $request->metode,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'penerima_id' => Auth::id(),
        ]);

        $totalDibayar = $tagihan->pembayarans()->sum('nominal');

        if ($totalDibayar >= $tagihan->nominal) {
            $tagihan->update(['status' => 'lunas']);
        } elseif ($totalDibayar > 0) {
            $tagihan->update(['status' => 'sebagian']);
        }

        return back()->with('success', "Pembayaran tagihan periode {$tagihan->periode} sebesar Rp " . number_format($request->nominal, 0, ',', '.') . " berhasil dicatat.");
    }

    /**
     * Kirim notifikasi pengingat ke orang tua murid.
     */
    public function kirimPengingat(Tagihan $tagihan)
    {
        $siswaUser = $tagihan->siswa;
        $parent = $siswaUser->orangTuas->first();

        if ($parent) {
            Notifikasi::create([
                'user_id' => $parent->id,
                'tipe' => 'spp',
                'judul' => "Pengingat Tagihan SPP: {$tagihan->periode}",
                'isi' => "Pemberitahuan: Tagihan SPP ananda {$siswaUser->name} periode {$tagihan->periode} sebesar Rp " . number_format($tagihan->nominal, 0, ',', '.') . " belum diselesaikan. Jatuh tempo: " . Carbon::parse($tagihan->jatuh_tempo)->translatedFormat('d F Y') . ".",
                'link' => '/orang-tua/tagihan',
            ]);

            return back()->with('success', "Notifikasi pengingat pembayaran berhasil dikirimkan ke akun Orang Tua ({$parent->name}).");
        }

        return back()->with('error', 'Tidak ditemukan akun Orang Tua yang terhubung dengan santri ini.');
    }
}
