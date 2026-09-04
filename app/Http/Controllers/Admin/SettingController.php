<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman formulir pengaturan identitas dan profil sekolah.
     */
    public function index()
    {
        $setting = SchoolSetting::getActive();
        return view('admin.settings.index', compact('setting'));
    }

    /**
     * Perbarui konfigurasi sekolah (Nama, Alamat, Kepala Sekolah, Logo, Periode).
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'nsm' => 'nullable|string|max:40',
            'npsn' => 'nullable|string|max:40',
            'akreditasi' => 'nullable|string|max:30',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|string|max:150',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'tahun_ajaran_aktif' => 'required|string|max:20',
            'semester_aktif' => 'required|in:ganjil,genap',
            'logo_custom' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ], [
            'nama_sekolah.required' => 'Nama instansi sekolah wajib diisi.',
            'alamat.required' => 'Alamat lengkap sekolah wajib diisi.',
            'nama_kepala_sekolah.required' => 'Nama kepala sekolah wajib diisi untuk kop surat raport.',
        ]);

        $setting = SchoolSetting::getActive();

        $data = $request->except(['logo_custom']);

        if ($request->hasFile('logo_custom')) {
            // Hapus file logo kustom lama jika ada
            if ($setting->logo_custom && Storage::disk('public')->exists($setting->logo_custom)) {
                Storage::disk('public')->delete($setting->logo_custom);
            }
            $data['logo_custom'] = $request->file('logo_custom')->store('settings', 'public');
        }

        $setting->update($data);

        return back()->with('success', 'Pengaturan identitas sekolah dan kop raport berhasil diperbarui.');
    }
}
