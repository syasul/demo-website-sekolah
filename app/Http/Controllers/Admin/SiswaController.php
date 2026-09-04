<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Exports\SiswaTemplateExport;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar seluruh siswa sekolah dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'kelas'])->latest();

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama, NIS, atau NISN
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nis', 'like', "%{$q}%")
                    ->orWhere('nisn', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        $siswas = $query->paginate(15)->withQueryString();
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_rombel')->get();

        $stats = [
            'total' => Siswa::count(),
            'aktif' => Siswa::where('status', 'aktif')->count(),
            'lulus' => Siswa::where('status', 'lulus')->count(),
        ];

        return view('admin.siswa.index', compact('siswas', 'kelasList', 'stats'));
    }

    /**
     * Form tambah siswa manual satuan.
     */
    public function create()
    {
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_rombel')->get();
        return view('admin.siswa.create', compact('kelasList'));
    }

    /**
     * Simpan data siswa baru dan otomatis buat akun login User.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis',
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:255',
            'no_hp_orang_tua' => 'nullable|string|max:25',
            'password' => 'nullable|string|min:6',
        ], [
            'nis.unique' => 'NIS ini sudah terdaftar untuk siswa lain.',
            'nisn.unique' => 'NISN ini sudah terdaftar untuk siswa lain.',
            'name.required' => 'Nama lengkap siswa wajib diisi.',
            'kelas_id.required' => 'Pilih kelas siswa terlebih dahulu.',
        ]);

        $nis = trim($request->nis);
        $email = $request->filled('email') 
            ? trim($request->email) 
            : 'siswa.' . $nis . '@attaraqqie.sch.id';
        
        $password = $request->filled('password') 
            ? $request->password 
            : $nis;

        DB::transaction(function () use ($request, $email, $password, $nis) {
            // 1. Buat akun User
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'siswa',
                'kelas_id' => $request->kelas_id,
            ]);

            // 2. Buat profil detail Siswa
            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nis' => $nis,
                'nisn' => $request->nisn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', "Siswa {$request->name} berhasil ditambahkan. Akun login dibuat dengan password: {$password}");
    }

    /**
     * Form edit data siswa.
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load(['user', 'kelas']);
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_rombel')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelasList'));
    }

    /**
     * Perbarui data siswa dan sinkronkan ke User.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => "required|string|max:20|unique:siswas,nis,{$siswa->id}",
            'nisn' => "nullable|string|max:20|unique:siswas,nisn,{$siswa->id}",
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$siswa->user_id}",
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string|max:255',
            'no_hp_orang_tua' => 'nullable|string|max:25',
            'status' => 'required|in:aktif,lulus,pindah,nonaktif',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            // Update User
            if ($siswa->user) {
                $siswa->user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'kelas_id' => $request->kelas_id,
                ]);
            }

            // Update Siswa
            $siswa->update([
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', "Data siswa {$request->name} berhasil diperbarui.");
    }

    /**
     * Hapus data siswa (Soft Delete agar riwayat raport tetap aman).
     */
    public function destroy(Siswa $siswa)
    {
        $name = $siswa->user ? $siswa->user->name : $siswa->nis;
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', "Data siswa {$name} berhasil dinonaktifkan/dihapus.");
    }

    /**
     * Reset kata sandi akun siswa ke NIS atau password default.
     */
    public function resetPassword(Siswa $siswa)
    {
        if (! $siswa->user) {
            return back()->with('error', 'Akun login untuk siswa ini tidak ditemukan.');
        }

        $newPassword = $siswa->nis ?: 'password123';
        $siswa->user->update([
            'password' => Hash::make($newPassword),
        ]);

        return back()->with('success', "Kata sandi siswa {$siswa->user->name} berhasil di-reset menjadi: {$newPassword}");
    }

    /**
     * Halaman upload & import file Excel data siswa.
     */
    public function importForm()
    {
        return view('admin.siswa.import');
    }

    /**
     * Parse file Excel dan tampilkan Pratinjau (Preview) sebelum disimpan ke database.
     */
    public function importPreview(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_excel.required' => 'Pilih file Excel (.xlsx / .xls / .csv) terlebih dahulu.',
            'file_excel.mimes' => 'Format file harus berupa Excel (.xlsx / .xls / .csv).',
            'file_excel.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        $file = $request->file('file_excel');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        if (count($rows) <= 1) {
            return back()->with('error', 'File Excel kosong atau hanya berisi baris judul header.');
        }

        $allKelas = Kelas::all()->keyBy(function ($k) {
            return strtoupper(trim($k->nama_lengkap));
        });

        $existingNis = Siswa::pluck('nis')->flip()->toArray();

        $previewRows = [];
        $validCount = 0;
        $invalidCount = 0;
        $seenNisInFile = [];

        // Loop baris data (mulai baris ke-2 setelah header)
        $isFirst = true;
        foreach ($rows as $rowIndex => $r) {
            if ($isFirst) {
                $isFirst = false;
                continue;
            }

            $nis = isset($r['A']) ? trim((string)$r['A']) : '';
            $nisn = isset($r['B']) ? trim((string)$r['B']) : null;
            $nama = isset($r['C']) ? trim((string)$r['C']) : '';
            $email = isset($r['D']) ? trim((string)$r['D']) : null;
            $namaKelas = isset($r['E']) ? strtoupper(trim((string)$r['E'])) : '';
            $jk = isset($r['F']) ? strtoupper(trim((string)$r['F'])) : 'L';
            $tempatLahir = isset($r['G']) ? trim((string)$r['G']) : null;
            $tglLahir = isset($r['H']) ? trim((string)$r['H']) : null;
            $alamat = isset($r['I']) ? trim((string)$r['I']) : null;
            $namaOrtu = isset($r['J']) ? trim((string)$r['J']) : null;
            $noHpOrtu = isset($r['K']) ? trim((string)$r['K']) : null;

            // Lewati baris kosong
            if (empty($nis) && empty($nama)) {
                continue;
            }

            $errors = [];

            if (empty($nis)) {
                $errors[] = 'NIS wajib diisi.';
            } elseif (isset($existingNis[$nis])) {
                $errors[] = 'NIS sudah terdaftar di sistem.';
            } elseif (isset($seenNisInFile[$nis])) {
                $errors[] = 'NIS duplikat di dalam file Excel ini.';
            } else {
                $seenNisInFile[$nis] = true;
            }

            if (empty($nama)) {
                $errors[] = 'Nama lengkap wajib diisi.';
            }

            $kelasId = null;
            if (empty($namaKelas)) {
                $errors[] = 'Kelas wajib diisi.';
            } elseif (! isset($allKelas[$namaKelas])) {
                $errors[] = "Kelas '{$namaKelas}' tidak ditemukan di database.";
            } else {
                $kelasId = $allKelas[$namaKelas]->id;
            }

            if (! in_array($jk, ['L', 'P'])) {
                $jk = 'L';
            }

            $isValid = empty($errors);
            if ($isValid) {
                $validCount++;
            } else {
                $invalidCount++;
            }

            $previewRows[] = [
                'row_number' => $rowIndex,
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $nama,
                'email' => $email,
                'kelas_nama' => $namaKelas,
                'kelas_id' => $kelasId,
                'jenis_kelamin' => $jk,
                'tempat_lahir' => $tempatLahir,
                'tanggal_lahir' => $tglLahir,
                'alamat' => $alamat,
                'nama_orang_tua' => $namaOrtu,
                'no_hp_orang_tua' => $noHpOrtu,
                'is_valid' => $isValid,
                'errors' => $errors,
            ];
        }

        session(['import_siswa_data' => $previewRows]);

        return view('admin.siswa.import', [
            'previewRows' => $previewRows,
            'validCount' => $validCount,
            'invalidCount' => $invalidCount,
            'hasPreview' => true,
        ]);
    }

    /**
     * Eksekusi penyimpanan data siswa yang valid dari hasil pratinjau.
     */
    public function importProcess(Request $request)
    {
        $previewRows = session('import_siswa_data', []);

        if (empty($previewRows)) {
            return redirect()->route('admin.siswa.import')->with('error', 'Tidak ada data yang siap diimpor. Silakan unggah file kembali.');
        }

        $successCount = 0;
        $failedCount = 0;

        DB::transaction(function () use ($previewRows, &$successCount, &$failedCount) {
            foreach ($previewRows as $row) {
                if (! $row['is_valid']) {
                    $failedCount++;
                    continue;
                }

                $nis = $row['nis'];
                $email = ! empty($row['email']) ? $row['email'] : "siswa.{$nis}@attaraqqie.sch.id";

                // Pastikan email unik jika auto-generate
                if (User::where('email', $email)->exists()) {
                    $email = "siswa.{$nis}." . Str::random(3) . "@attaraqqie.sch.id";
                }

                // 1. Buat User akun siswa
                $user = User::create([
                    'name' => $row['nama'],
                    'email' => $email,
                    'password' => Hash::make($nis), // Password default adalah NIS
                    'role' => 'siswa',
                    'kelas_id' => $row['kelas_id'],
                ]);

                // 2. Buat profil detail Siswa
                Siswa::create([
                    'user_id' => $user->id,
                    'kelas_id' => $row['kelas_id'],
                    'nis' => $nis,
                    'nisn' => $row['nisn'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'tempat_lahir' => $row['tempat_lahir'],
                    'tanggal_lahir' => ! empty($row['tanggal_lahir']) ? date('Y-m-d', strtotime($row['tanggal_lahir'])) : null,
                    'alamat' => $row['alamat'],
                    'nama_orang_tua' => $row['nama_orang_tua'],
                    'no_hp_orang_tua' => $row['no_hp_orang_tua'],
                    'status' => 'aktif',
                ]);

                $successCount++;
            }
        });

        session()->forget('import_siswa_data');

        return redirect()->route('admin.siswa.index')->with('success', "Import selesai: {$successCount} siswa berhasil ditambahkan ke database. Password awal tiap siswa adalah NIS masing-masing.");
    }

    /**
     * Download format template Excel baku untuk import siswa.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_import_siswa.xlsx');
    }

    /**
     * Export seluruh data siswa ke format Excel.
     */
    public function export(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $fileName = 'data_siswa_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new SiswaExport($kelasId), $fileName);
    }
}
