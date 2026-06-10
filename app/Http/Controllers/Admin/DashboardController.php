<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => 1240,
            'total_teachers' => 85,
            'total_news' => 12,
            'pending_ppdb' => 45,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
