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
            'label' => 'Semua Unit',
            'full_label' => 'Yayasan Global — Semua Unit',
            'color' => 'emerald',
            'bg_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
            'dot_class' => 'bg-emerald-500',
            'mode' => 'global',
        ];

        if ($user && $user->role === 'admin') {
            if ($user->admin_level === 'putra') {
                $badge = [
                    'label' => 'Unit Putra',
                    'full_label' => 'MA Attaraqqie (Putra)',
                    'color' => 'sky',
                    'bg_class' => 'bg-sky-50 text-sky-700 border-sky-200/80',
                    'dot_class' => 'bg-sky-500',
                    'mode' => 'putra',
                ];
            } elseif ($user->admin_level === 'putri') {
                $badge = [
                    'label' => 'Unit Putri',
                    'full_label' => 'MA Attaraqqie (Putri)',
                    'color' => 'purple',
                    'bg_class' => 'bg-purple-50 text-purple-700 border-purple-200/80',
                    'dot_class' => 'bg-purple-500',
                    'mode' => 'putri',
                ];
            } elseif ($activeUnitId) {
                $unit = Unit::with('jenjang')->find($activeUnitId);
                if ($unit) {
                    $isPutra = $unit->gender === 'putra';
                    $badge = [
                        'label' => $unit->nama,
                        'full_label' => $unit->nama,
                        'color' => $isPutra ? 'sky' : 'purple',
                        'bg_class' => $isPutra ? 'bg-sky-50 text-sky-700 border-sky-200/80' : 'bg-purple-50 text-purple-700 border-purple-200/80',
                        'dot_class' => $isPutra ? 'bg-sky-500' : 'bg-purple-500',
                        'mode' => $unit->gender,
                        'unit' => $unit,
                    ];
                }
            } elseif ($activeJenjangId) {
                $jenjang = Jenjang::find($activeJenjangId);
                if ($jenjang) {
                    $badge = [
                        'label' => 'Jenjang ' . $jenjang->nama,
                        'full_label' => 'Jenjang ' . $jenjang->nama,
                        'color' => 'amber',
                        'bg_class' => 'bg-amber-50 text-amber-800 border-amber-200/80',
                        'dot_class' => 'bg-amber-500',
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
