<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiGuruController extends Controller
{
    /**
     * Aksi "Absen Masuk" guru hari ini.
     */
    public function checkIn(Request $request)
    {
        $guru = Auth::user();
        $today = Carbon::today();

        $existing = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today->toDateString())
            ->first();

        if ($existing) {
            return back()->with('info', "Anda sudah melakukan Absen Masuk hari ini pada pukul {$existing->jam_masuk}.");
        }

        $now = Carbon::now();

        AbsensiGuru::create([
            'guru_id' => $guru->id,
            'unit_id' => $guru->units->first()?->id,
            'tanggal' => $today->toDateString(),
            'jam_masuk' => $now->toTimeString(),
            'status' => 'hadir',
            'catatan' => $request->input('catatan', 'Hadir mandiri via Portal Guru'),
        ]);

        return back()->with('success', "Alhamdulillah, Absen Masuk berhasil dicatat pada pukul {$now->format('H:i')}. Akses Pengisian Jurnal Mengajar kini telah aktif.");
    }
}
