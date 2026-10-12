<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RumahJurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RumahJurnalController extends Controller
{
    /**
     * Tampilkan katalog karya ilmiah Rumah Jurnal.
     */
    public function index(Request $request)
    {
        $kategori = $request->input('kategori');
        $q = $request->input('q');

        $query = RumahJurnal::where('status', 'approved');

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($q) {
            $query->where(function($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('penulis', 'like', "%{$q}%")
                  ->orWhere('abstrak', 'like', "%{$q}%");
            });
        }

        $jurnals = $query->latest()->paginate(12)->withQueryString();

        $myJurnals = RumahJurnal::where('guru_id', Auth::id())->latest()->get();

        $kategoris = [
            'Inovasi Pembelajaran',
            'Pendidikan Karakter',
            'Kajian Turats & Islam',
            'Sains & Teknologi',
            'Pendidikan Bahasa',
        ];

        return view('guru.rumah_jurnal.index', compact('jurnals', 'myJurnals', 'kategoris', 'kategori', 'q'));
    }

    /**
     * Unggah karya ilmiah baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'abstrak' => 'required|string',
            'tahun' => 'required|integer',
        ]);

        $guru = Auth::user();

        RumahJurnal::create([
            'judul' => $request->judul,
            'penulis' => $guru->name,
            'guru_id' => $guru->id,
            'unit_id' => $guru->units->first()?->id,
            'kategori' => $request->kategori,
            'abstrak' => $request->abstrak,
            'tahun' => $request->tahun,
            'status' => 'approved', // Auto-approved for demo presentation
        ]);

        return back()->with('success', "Karya ilmiah '{$request->judul}' berhasil diunggah ke Rumah Jurnal.");
    }
}
