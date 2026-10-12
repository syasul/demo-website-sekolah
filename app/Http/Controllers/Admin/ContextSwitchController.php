<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContextSwitchController extends Controller
{
    /**
     * Switch active unit / educational stage session context.
     */
    public function switch(Request $request)
    {
        $user = Auth::user();

        // Dedicated gender-restricted admin cannot switch outside their assigned gender
        if ($user && $user->admin_level === 'putra' && $request->filled('unit_id')) {
            $unit = Unit::find($request->unit_id);
            if ($unit && $unit->gender !== 'putra') {
                abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengakses data Unit Putri.');
            }
        }

        if ($user && $user->admin_level === 'putri' && $request->filled('unit_id')) {
            $unit = Unit::find($request->unit_id);
            if ($unit && $unit->gender !== 'putri') {
                abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengakses data Unit Putra.');
            }
        }

        $mode = $request->input('mode');
        if (! $mode) {
            if ($request->filled('unit_id')) {
                $mode = 'unit';
            } elseif ($request->filled('jenjang_id')) {
                $mode = 'jenjang';
            } else {
                $mode = 'global';
            }
        }

        if ($mode === 'global') {
            session()->forget(['active_unit_id', 'active_jenjang_id']);
            return back()->with('success', 'Beralih ke Konteks: Semua Unit (Admin Global Yayasan).');
        }

        if ($mode === 'jenjang' && $request->filled('jenjang_id')) {
            $jenjang = Jenjang::findOrFail($request->jenjang_id);
            session([
                'active_jenjang_id' => $jenjang->id,
            ]);
            session()->forget('active_unit_id');
            return back()->with('success', "Beralih ke Konteks Jenjang: {$jenjang->nama}.");
        }

        if ($mode === 'unit' && $request->filled('unit_id')) {
            $unit = Unit::with('jenjang')->findOrFail($request->unit_id);
            session([
                'active_unit_id' => $unit->id,
                'active_jenjang_id' => $unit->jenjang_id,
            ]);
            return back()->with('success', "Beralih ke Konteks: {$unit->nama}.");
        }

        session()->forget(['active_unit_id', 'active_jenjang_id']);
        return back()->with('success', 'Konteks berhasil direset ke Semua Unit.');
    }
}
