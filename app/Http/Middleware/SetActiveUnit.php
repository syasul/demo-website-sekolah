<?php

namespace App\Http\Middleware;

use App\Models\Jenjang;
use App\Models\Unit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetActiveUnit
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $activeUnitId = session('active_unit_id');
        $activeJenjangId = session('active_jenjang_id');

        $badge = [
            'label' => 'Semua Unit (Yayasan Global)',
            'color' => 'emerald',
            'bg_class' => 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400',
            'dot_class' => 'bg-emerald-400',
            'mode' => 'global',
        ];

        if ($user && $user->role === 'admin') {
            if ($user->admin_level === 'putra') {
                $badge = [
                    'label' => 'Unit Putra (MA / Khusus Putra)',
                    'color' => 'blue',
                    'bg_class' => 'bg-blue-500/10 border-blue-500/30 text-blue-400',
                    'dot_class' => 'bg-blue-400',
                    'mode' => 'putra',
                ];
            } elseif ($user->admin_level === 'putri') {
                $badge = [
                    'label' => 'Unit Putri (MA / Khusus Putri)',
                    'color' => 'purple',
                    'bg_class' => 'bg-purple-500/10 border-purple-500/30 text-purple-400',
                    'dot_class' => 'bg-purple-400',
                    'mode' => 'putri',
                ];
            } elseif ($activeUnitId) {
                $unit = Unit::with('jenjang')->find($activeUnitId);
                if ($unit) {
                    $isPutra = $unit->gender === 'putra';
                    $badge = [
                        'label' => $unit->nama,
                        'color' => $isPutra ? 'blue' : 'purple',
                        'bg_class' => $isPutra ? 'bg-blue-500/10 border-blue-500/30 text-blue-400' : 'bg-purple-500/10 border-purple-500/30 text-purple-400',
                        'dot_class' => $isPutra ? 'bg-blue-400' : 'bg-purple-400',
                        'mode' => $unit->gender,
                        'unit' => $unit,
                    ];
                }
            } elseif ($activeJenjangId) {
                $jenjang = Jenjang::find($activeJenjangId);
                if ($jenjang) {
                    $badge = [
                        'label' => 'Jenjang ' . $jenjang->nama,
                        'color' => 'amber',
                        'bg_class' => 'bg-amber-500/10 border-amber-500/30 text-amber-400',
                        'dot_class' => 'bg-amber-400',
                        'mode' => 'jenjang',
                        'jenjang' => $jenjang,
                    ];
                }
            }
        }

        // Share globally to views if table exists
        if (Schema::hasTable('jenjangs')) {
            $allJenjangs = Jenjang::with('units')->get();
            View::share('allJenjangs', $allJenjangs);
        }

        View::share('contextBadge', $badge);
        View::share('activeUnitId', $activeUnitId);
        View::share('activeJenjangId', $activeJenjangId);

        return $next($request);
    }
}
