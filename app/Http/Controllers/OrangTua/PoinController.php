<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\PoinSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoinController extends Controller
{
    /**
     * Tampilkan catatan kedisiplinan dan poin prestasi santri.
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

        $poins = PoinSiswa::with(['kategori', 'pencatat'])
            ->where('siswa_id', $selectedAnak->id)
            ->latest('tanggal')
            ->paginate(15);

        $poinPlus = PoinSiswa::where('siswa_id', $selectedAnak->id)->where('poin', '>', 0)->sum('poin');
        $poinMinus = abs(PoinSiswa::where('siswa_id', $selectedAnak->id)->where('poin', '<', 0)->sum('poin'));
        $netPoin = $poinPlus - $poinMinus;

        return view('orang_tua.poin.index', compact(
            'anaks',
            'selectedAnak',
            'poins',
            'poinPlus',
            'poinMinus',
            'netPoin'
        ));
    }
}
