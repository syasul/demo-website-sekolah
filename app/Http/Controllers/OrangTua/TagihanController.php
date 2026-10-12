<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    /**
     * Tampilkan data tagihan SPP dan riwayat pembayaran bagi orang tua.
     */
    public function index()
    {
        /** @var User $parent */
        $parent = Auth::user();
        $anaks = $parent->anaks()->with('siswa.kelas.unit')->get();

        $activeAnakId = session('active_anak_id', $anaks->first()?->id);
        $selectedAnak = $anaks->firstWhere('id', $activeAnakId) ?: $anaks->first();

        if (! $selectedAnak) {
            return redirect()->route('orang-tua.dashboard');
        }

        $tagihans = Tagihan::with('pembayarans')
            ->where('siswa_id', $selectedAnak->id)
            ->latest('jatuh_tempo')
            ->paginate(12);

        $totalTagihan = Tagihan::where('siswa_id', $selectedAnak->id)->sum('nominal');
        $totalLunas = Tagihan::where('siswa_id', $selectedAnak->id)->where('status', 'lunas')->sum('nominal');
        $sisaTunggakan = Tagihan::where('siswa_id', $selectedAnak->id)->where('status', '!=', 'lunas')->sum('nominal');

        return view('orang_tua.tagihan.index', compact(
            'anaks',
            'selectedAnak',
            'tagihans',
            'totalTagihan',
            'totalLunas',
            'sisaTunggakan'
        ));
    }
}
