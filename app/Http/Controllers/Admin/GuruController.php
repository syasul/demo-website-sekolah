<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $gurus = User::where('role', 'guru')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with(['kelasWali', 'guruMapels.kelas', 'guruMapels.mapel'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.guru.index', compact('gurus', 'search'));
    }

    /**
     * Show the form for creating a new teacher account.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap guru wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Akun Guru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the teacher account.
     */
    public function edit(User $guru)
    {
        if (!$guru->isGuru()) {
            abort(404);
        }

        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update the teacher in storage.
     */
    public function update(Request $request, User $guru)
    {
        if (!$guru->isGuru()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($guru->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap guru wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $guru->name = $validated['name'];
        $guru->email = $validated['email'];

        if (!empty($validated['password'])) {
            $guru->password = Hash::make($validated['password']);
        }

        $guru->save();

        return redirect()->route('admin.guru.index')->with('success', 'Data akun Guru berhasil diperbarui.');
    }

    /**
     * Remove the teacher from storage.
     */
    public function destroy(User $guru)
    {
        if (!$guru->isGuru()) {
            abort(404);
        }

        // Remove homeroom assignment if any
        Kelas::where('wali_kelas_id', $guru->id)->update(['wali_kelas_id' => null]);

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Akun Guru berhasil dihapus.');
    }

    /**
     * Show teacher assignment page (classes, subjects, and homeroom).
     */
    public function assignView(User $guru)
    {
        if (!$guru->isGuru()) {
            abort(404);
        }

        $guru->load(['guruMapels.kelas', 'guruMapels.mapel', 'kelasWali']);
        $kelases = Kelas::orderBy('tingkat')->orderBy('nama_rombel')->get();
        $mapels = MataPelajaran::orderBy('nama_mapel')->get();

        return view('admin.guru.assign', compact('guru', 'kelases', 'mapels'));
    }

    /**
     * Assign class and subject to the teacher.
     */
    public function assignStore(Request $request, User $guru)
    {
        if (!$guru->isGuru()) {
            abort(404);
        }

        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
        ], [
            'kelas_id.required' => 'Pilih kelas terlebih dahulu.',
            'mapel_id.required' => 'Pilih mata pelajaran terlebih dahulu.',
        ]);

        $exists = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $validated['kelas_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['penugasan' => 'Guru sudah ditugaskan mengajar mata pelajaran ini di kelas tersebut.']);
        }

        GuruMapel::create([
            'guru_id' => $guru->id,
            'kelas_id' => $validated['kelas_id'],
            'mapel_id' => $validated['mapel_id'],
        ]);

        return back()->with('success', 'Penugasan mengajar berhasil ditambahkan.');
    }

    /**
     * Remove class and subject assignment from teacher.
     */
    public function assignDestroy(User $guru, GuruMapel $guruMapel)
    {
        if (!$guru->isGuru() || $guruMapel->guru_id !== $guru->id) {
            abort(403);
        }

        $guruMapel->delete();

        return back()->with('success', 'Penugasan mengajar berhasil dihapus.');
    }

    /**
     * Assign or unassign homeroom (wali kelas) status.
     */
    public function assignWaliKelas(Request $request, User $guru)
    {
        if (!$guru->isGuru()) {
            abort(404);
        }

        $validated = $request->validate([
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        // Reset previous homeroom class for this teacher
        Kelas::where('wali_kelas_id', $guru->id)->update(['wali_kelas_id' => null]);

        if (!empty($validated['kelas_id'])) {
            $kelas = Kelas::findOrFail($validated['kelas_id']);
            $kelas->update(['wali_kelas_id' => $guru->id]);
            return back()->with('success', "Berhasil menetapkan {$guru->name} sebagai Wali Kelas {$kelas->nama_lengkap}.");
        }

        return back()->with('success', "Status Wali Kelas untuk {$guru->name} berhasil dicabut.");
    }
}
