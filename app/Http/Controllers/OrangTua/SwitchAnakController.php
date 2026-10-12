<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwitchAnakController extends Controller
{
    /**
     * Switch active child for parent portal.
     */
    public function switch(Request $request, $anakId)
    {
        $parent = Auth::user();

        $anak = $parent->anaks()->findOrFail($anakId);

        session(['active_anak_id' => $anak->id]);

        return back()->with('success', "Beralih memantau ananda: {$anak->name}.");
    }
}
