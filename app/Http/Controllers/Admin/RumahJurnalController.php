<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RumahJurnal;
use Illuminate\Http\Request;

class RumahJurnalController extends Controller
{
    /**
     * Tampilkan moderasi karya ilmiah Rumah Jurnal.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = RumahJurnal::with(['guru', 'unit']);

        if ($status) {
            $query->where('status', $status);
        }

        $jurnals = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => RumahJurnal::count(),
            'approved' => RumahJurnal::where('status', 'approved')->count(),
            'pending' => RumahJurnal::where('status', 'pending')->count(),
        ];

        return view('admin.rumah_jurnal.index', compact('jurnals', 'stats', 'status'));
    }

    /**
     * Update status moderasi (Approve / Reject).
     */
    public function updateStatus(Request $request, RumahJurnal $rumahJurnal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $rumahJurnal->update(['status' => $request->status]);

        return back()->with('success', "Status publikasi '{$rumahJurnal->judul}' diubah menjadi {$request->status}.");
    }

    /**
     * Hapus karya jurnal.
     */
    public function destroy(RumahJurnal $rumahJurnal)
    {
        $rumahJurnal->delete();
        return back()->with('success', 'Karya ilmiah berhasil dihapus dari arsip.');
    }
}
