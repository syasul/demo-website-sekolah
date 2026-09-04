<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelases = Kelas::with('waliKelas')->withCount('siswas')->orderBy('tingkat')->orderBy('nama_rombel')->get();
        // Group by tingkat
        $groupedKelas = $kelases->groupBy('tingkat');
        
        return view('admin.kelas.index', compact('groupedKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|string',
            'nama_rombel' => 'required|string',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        // Check uniqueness
        $exists = Kelas::where('tingkat', $request->tingkat)
            ->where('nama_rombel', $request->nama_rombel)
            ->exists();
            
        if ($exists) {
            return back()->withInput()->withErrors(['nama_rombel' => 'Kelas dengan tingkat dan rombel ini sudah ada.']);
        }

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }
}
