<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Article;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Pendaftar;
use App\Models\PoinSiswa;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Base counts (respecting active scope if filtered)
        $totalStudents = Siswa::count();
        $totalTeachers = User::where('role', 'guru')->count();
        $totalClasses = Kelas::count();
        $pendingPpdb = Pendaftar::where('status', 'pending')->count();
        $totalNews = Article::count();

        // Cross-unit statistics for Global or comparison
        $siswaPutraCount = Siswa::withoutUnitScope()
            ->whereHas('unit', fn($q) => $q->where('gender', 'putra'))
            ->count();

        $siswaPutriCount = Siswa::withoutUnitScope()
            ->whereHas('unit', fn($q) => $q->where('gender', 'putri'))
            ->count();

        // Today's attendance
        $todayAttendancePutra = AbsensiSiswa::withoutUnitScope()
            ->where('tanggal', $today)
            ->whereHas('unit', fn($q) => $q->where('gender', 'putra'))
            ->where('status', 'hadir')
            ->count();

        $todayAttendancePutri = AbsensiSiswa::withoutUnitScope()
            ->where('tanggal', $today)
            ->whereHas('unit', fn($q) => $q->where('gender', 'putri'))
            ->where('status', 'hadir')
            ->count();

        // SPP collection stats
        $sppLunasCount = Tagihan::where('status', 'lunas')->count();
        $sppBelumCount = Tagihan::where('status', '!=', 'lunas')->count();
        $sppTotalNominal = Tagihan::sum('nominal');
        $sppCollectedNominal = Tagihan::where('status', 'lunas')->sum('nominal');

        // Recent activity
        $recentJurnals = Jurnal::with(['guru', 'kelas', 'mapel', 'unit'])->latest()->take(5)->get();
        $recentPoins = PoinSiswa::with(['siswa', 'kategori', 'unit'])->latest()->take(5)->get();
        $recentPendaftars = Pendaftar::with('unit')->latest()->take(5)->get();

        $stats = [
            'total_students' => $totalStudents,
            'total_teachers' => $totalTeachers,
            'total_classes' => $totalClasses,
            'total_news' => $totalNews,
            'pending_ppdb' => $pendingPpdb,
            'siswa_putra' => $siswaPutraCount,
            'siswa_putri' => $siswaPutriCount,
            'absen_putra_today' => $todayAttendancePutra,
            'absen_putri_today' => $todayAttendancePutri,
            'spp_lunas' => $sppLunasCount,
            'spp_belum' => $sppBelumCount,
            'spp_collected' => $sppCollectedNominal,
            'spp_total' => $sppTotalNominal,
        ];

        return view('admin.dashboard', compact('stats', 'recentJurnals', 'recentPoins', 'recentPendaftars'));
    }
}
