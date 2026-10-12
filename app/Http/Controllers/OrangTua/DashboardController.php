<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Nilai;
use App\Models\Notifikasi;
use App\Models\PoinSiswa;
use App\Models\Tagihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard orang tua (mobile-first / responsive).
     */
    public function index()
    {
        /** @var User $parent */
        $parent = Auth::user();

        $anaks = $parent->anaks()->with(['siswa.kelas.unit', 'siswa.unit'])->get();

        if ($anaks->isEmpty()) {
            return view('orang_tua.no_anak');
        }

        // Active child from session or default to first
        $activeAnakId = session('active_anak_id', $anaks->first()->id);
        $selectedAnak = $anaks->firstWhere('id', $activeAnakId) ?: $anaks->first();
        session(['active_anak_id' => $selectedAnak->id]);

        $today = Carbon::today()->toDateString();

        // 1. Today's Attendance
        $absenToday = AbsensiSiswa::where('siswa_id', $selectedAnak->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Attendance stats for this month
        $startOfMonth = Carbon::today()->startOfMonth()->toDateString();
        $totalHadirBulanIni = AbsensiSiswa::where('siswa_id', $selectedAnak->id)
            ->whereBetween('tanggal', [$startOfMonth, $today])
            ->where('status', 'hadir')
            ->count();

        // 2. Discipline / Character Points
        $poinPlus = PoinSiswa::where('siswa_id', $selectedAnak->id)->where('poin', '>', 0)->sum('poin');
        $poinMinus = abs(PoinSiswa::where('siswa_id', $selectedAnak->id)->where('poin', '<', 0)->sum('poin'));
        $netPoin = $poinPlus - $poinMinus;
        $recentPoins = PoinSiswa::with('kategori')
            ->where('siswa_id', $selectedAnak->id)
            ->latest('tanggal')
            ->take(3)
            ->get();

        // 3. Tuition / SPP
        $latestTagihan = Tagihan::with('pembayarans')
            ->where('siswa_id', $selectedAnak->id)
            ->latest('jatuh_tempo')
            ->first();

        // 4. Academic Snapshot
        $recentNilais = Nilai::with('mapel')
            ->where('siswa_id', $selectedAnak->id)
            ->latest()
            ->take(4)
            ->get();

        // 5. Unread Notifications
        $unreadNotifCount = Notifikasi::where('user_id', $parent->id)->whereNull('dibaca_at')->count();

        return view('orang_tua.dashboard', compact(
            'parent',
            'anaks',
            'selectedAnak',
            'absenToday',
            'totalHadirBulanIni',
            'poinPlus',
            'poinMinus',
            'netPoin',
            'recentPoins',
            'latestTagihan',
            'recentNilais',
            'unreadNotifCount'
        ));
    }
}
