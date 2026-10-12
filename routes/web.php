<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Public Client Routes
 */
Route::get('/', function () {
    return view('client.home');
});

Route::get('/profil', function () {
    return view('client.profil');
});

Route::get('/akademik', function () {
    return view('client.akademik');
});

Route::get('/kesiswaan', function () {
    return view('client.kesiswaan');
});

Route::get('/berita', function () {
    return view('client.berita.index');
});

Route::get('/fasilitas', function () {
    return view('client.fasilitas');
});

Route::get('/ppdb', [\App\Http\Controllers\Client\PpdbController::class, 'index'])->name('ppdb');
Route::post('/ppdb', [\App\Http\Controllers\Client\PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/status', [\App\Http\Controllers\Client\PpdbController::class, 'cekStatus'])->name('ppdb.status');

Route::get('/virtual-tour', function () {
    return view('client.virtual-tour');
});

/**
 * Admin Panel Routes (Protected)
 */
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/switch-unit', [\App\Http\Controllers\Admin\ContextSwitchController::class, 'switch'])->name('switch-unit');
    Route::resource('berita', \App\Http\Controllers\Admin\ArticleController::class)->names('articles');
    
    // Manajemen Kelas (Index, Create, Store)
    Route::resource('kelas', \App\Http\Controllers\KelasController::class)->only(['index', 'create', 'store']);

    // Manajemen Mata Pelajaran (Full CRUD)
    Route::resource('mata-pelajaran', \App\Http\Controllers\MataPelajaranController::class)->parameters(['mata-pelajaran' => 'mataPelajaran']);

    // Manajemen Guru & Penugasan
    Route::resource('guru', \App\Http\Controllers\Admin\GuruController::class);
    Route::get('guru/{guru}/assign', [\App\Http\Controllers\Admin\GuruController::class, 'assignView'])->name('guru.assign');
    Route::post('guru/{guru}/assign', [\App\Http\Controllers\Admin\GuruController::class, 'assignStore'])->name('guru.assign.store');
    Route::delete('guru/{guru}/assign/{guruMapel}', [\App\Http\Controllers\Admin\GuruController::class, 'assignDestroy'])->name('guru.assign.destroy');
    Route::post('guru/{guru}/assign-wali', [\App\Http\Controllers\Admin\GuruController::class, 'assignWaliKelas'])->name('guru.assign.wali');

    // Manajemen Data Siswa (CRUD, Import Excel, Export, Reset Password)
    Route::get('siswa/template', [\App\Http\Controllers\Admin\SiswaController::class, 'downloadTemplate'])->name('siswa.template');
    Route::get('siswa/export', [\App\Http\Controllers\Admin\SiswaController::class, 'export'])->name('siswa.export');
    Route::get('siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'importForm'])->name('siswa.import');
    Route::post('siswa/import/preview', [\App\Http\Controllers\Admin\SiswaController::class, 'importPreview'])->name('siswa.import.preview');
    Route::post('siswa/import/process', [\App\Http\Controllers\Admin\SiswaController::class, 'importProcess'])->name('siswa.import.process');
    Route::post('siswa/{siswa}/reset-password', [\App\Http\Controllers\Admin\SiswaController::class, 'resetPassword'])->name('siswa.reset-password');
    Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);

    // Manajemen PPDB & Konversi Siswa
    Route::get('ppdb', [\App\Http\Controllers\Admin\PendaftarController::class, 'index'])->name('ppdb.index');
    Route::get('ppdb/{pendaftar}', [\App\Http\Controllers\Admin\PendaftarController::class, 'show'])->name('ppdb.show');
    Route::patch('ppdb/{pendaftar}/status', [\App\Http\Controllers\Admin\PendaftarController::class, 'updateStatus'])->name('ppdb.update-status');
    Route::post('ppdb/{pendaftar}/konversi', [\App\Http\Controllers\Admin\PendaftarController::class, 'konversiSiswa'])->name('ppdb.konversi');

    // Pengaturan Sekolah Dinamis (Settings)
    Route::get('pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Absensi Siswa & Guru
    Route::get('/absensi-siswa', [\App\Http\Controllers\Admin\AbsensiSiswaController::class, 'index'])->name('absensi.siswa');
    Route::get('/absensi-guru', [\App\Http\Controllers\Admin\AbsensiGuruController::class, 'index'])->name('absensi.guru');

    // Kedisiplinan & Poin Karakter
    Route::get('/kedisiplinan', [\App\Http\Controllers\Admin\PoinSiswaController::class, 'index'])->name('kedisiplinan.index');
    Route::get('/kedisiplinan/tambah', [\App\Http\Controllers\Admin\PoinSiswaController::class, 'create'])->name('kedisiplinan.create');
    Route::post('/kedisiplinan', [\App\Http\Controllers\Admin\PoinSiswaController::class, 'store'])->name('kedisiplinan.store');
    Route::get('/kedisiplinan/student-of-the-year', [\App\Http\Controllers\Admin\PoinSiswaController::class, 'studentOfTheYear'])->name('kedisiplinan.student-of-the-year');

    // Evaluasi Kinerja Guru
    Route::get('/evaluasi-guru', [\App\Http\Controllers\Admin\EvaluasiGuruController::class, 'index'])->name('evaluasi.index');
    Route::get('/evaluasi-guru/nilai', [\App\Http\Controllers\Admin\EvaluasiGuruController::class, 'create'])->name('evaluasi.create');
    Route::post('/evaluasi-guru', [\App\Http\Controllers\Admin\EvaluasiGuruController::class, 'store'])->name('evaluasi.store');
    Route::get('/evaluasi-guru/{evaluasi}/pdf', [\App\Http\Controllers\Admin\EvaluasiGuruController::class, 'cetakPdf'])->name('evaluasi.pdf');

    // Keuangan & SPP
    Route::get('/keuangan', [\App\Http\Controllers\Admin\TagihanSppController::class, 'index'])->name('keuangan.index');
    Route::post('/keuangan/generate', [\App\Http\Controllers\Admin\TagihanSppController::class, 'generateMassal'])->name('keuangan.generate');
    Route::post('/keuangan/{tagihan}/bayar', [\App\Http\Controllers\Admin\TagihanSppController::class, 'catatPembayaran'])->name('keuangan.bayar');
    Route::post('/keuangan/{tagihan}/ingatkan', [\App\Http\Controllers\Admin\TagihanSppController::class, 'kirimPengingat'])->name('keuangan.ingatkan');

    // RDM Kemenag Simulation
    Route::get('/rdm', [\App\Http\Controllers\Admin\RdmController::class, 'index'])->name('rdm.index');
    Route::post('/rdm/sync', [\App\Http\Controllers\Admin\RdmController::class, 'sync'])->name('rdm.sync');

    // Rumah Jurnal Moderation
    Route::get('/rumah-jurnal', [\App\Http\Controllers\Admin\RumahJurnalController::class, 'index'])->name('rumah-jurnal.index');
    Route::patch('/rumah-jurnal/{rumahJurnal}', [\App\Http\Controllers\Admin\RumahJurnalController::class, 'updateStatus'])->name('rumah-jurnal.update-status');
    Route::delete('/rumah-jurnal/{rumahJurnal}', [\App\Http\Controllers\Admin\RumahJurnalController::class, 'destroy'])->name('rumah-jurnal.destroy');

    // Auth Profile for Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Generic Authenticated Routes
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isGuru()) return redirect()->route('guru.dashboard');
        if ($user->isOrangTua()) return redirect()->route('orang-tua.dashboard');
        if ($user->isSiswa()) return redirect()->route('siswa.dashboard');
        return redirect('/');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // In-App Notifications
    Route::get('/notifikasi', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{notifikasi}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifikasi.read-all');

    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notifikasi}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

/**
 * Guru Panel Routes (Protected)
 */
Route::middleware(['auth', 'verified', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/absen-masuk', [\App\Http\Controllers\Guru\AbsensiGuruController::class, 'checkIn'])->name('absen-masuk');

    // Absensi Santri oleh Guru
    Route::get('/absensi-siswa', [\App\Http\Controllers\Guru\AbsensiSiswaController::class, 'index'])->name('absensi.siswa.index');
    Route::post('/absensi-siswa', [\App\Http\Controllers\Guru\AbsensiSiswaController::class, 'store'])->name('absensi.siswa.store');

    // Jurnal Mengajar Harian (Gate Terkunci bila belum Absen Masuk)
    Route::get('/jurnal', [\App\Http\Controllers\Guru\JurnalController::class, 'index'])->name('jurnal.index');
    Route::post('/jurnal', [\App\Http\Controllers\Guru\JurnalController::class, 'store'])->name('jurnal.store');

    // Rumah Jurnal (Publikasi Ilmiah Guru)
    Route::get('/rumah-jurnal', [\App\Http\Controllers\Guru\RumahJurnalController::class, 'index'])->name('rumah-jurnal.index');
    Route::post('/rumah-jurnal', [\App\Http\Controllers\Guru\RumahJurnalController::class, 'store'])->name('rumah-jurnal.store');

    // Evaluasi Kinerja Diri
    Route::get('/evaluasi-diri', [\App\Http\Controllers\Guru\EvaluasiController::class, 'index'])->name('evaluasi.index');

    // Manajemen Kelas & Siswa
    Route::get('/kelas', [\App\Http\Controllers\Guru\KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/{kelas}', [\App\Http\Controllers\Guru\KelasController::class, 'show'])->name('kelas.show');

    // Raport & Penilaian Massal
    Route::get('/raport', [\App\Http\Controllers\Guru\NilaiController::class, 'pilih'])->name('raport.index');
    Route::get('/raport/input', [\App\Http\Controllers\Guru\NilaiController::class, 'create'])->name('raport.create');
    Route::post('/raport/input', [\App\Http\Controllers\Guru\NilaiController::class, 'store'])->name('raport.store');
    Route::get('/raport/rekap', [\App\Http\Controllers\Guru\NilaiController::class, 'rekap'])->name('raport.rekap');
    Route::post('/raport/lock', [\App\Http\Controllers\Guru\NilaiController::class, 'lock'])->name('raport.lock');
    Route::post('/raport/hitung-ulang', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'hitungUlang'])->name('raport.hitung-ulang');

    // Penilaian Komponen Harian (Tugas & UH)
    Route::get('/nilai/tugas-uh', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'indexTugasUh'])->name('nilai.tugas-uh');
    Route::post('/nilai/tugas-uh', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'storeTugasUh'])->name('nilai.tugas-uh.store');
    Route::delete('/nilai/tugas-uh', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'destroySession'])->name('nilai.tugas-uh.destroy');

    // Penilaian Semester (UTS & UAS)
    Route::get('/nilai/uts-uas', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'indexUtsUas'])->name('nilai.uts-uas');
    Route::post('/nilai/uts-uas', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'storeUtsUas'])->name('nilai.uts-uas.store');

    // Program Remedial (Siswa di bawah KKM)
    Route::get('/nilai/remidi', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'indexRemidi'])->name('nilai.remidi');
    Route::post('/nilai/remidi', [\App\Http\Controllers\Guru\KomponenNilaiController::class, 'storeRemidi'])->name('nilai.remidi.store');
});

/**
 * Portal Orang Tua (Mobile-First / Responsive)
 */
Route::middleware(['auth', 'verified', 'role:orang_tua'])->prefix('orang-tua')->name('orang-tua.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\OrangTua\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/switch-anak/{anakId}', [\App\Http\Controllers\OrangTua\SwitchAnakController::class, 'switch'])->name('switch-anak');
    Route::get('/absensi', [\App\Http\Controllers\OrangTua\AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/raport', [\App\Http\Controllers\OrangTua\RaportController::class, 'index'])->name('raport.index');
    Route::get('/raport/pdf', [\App\Http\Controllers\OrangTua\RaportController::class, 'pdf'])->name('raport.pdf');
    Route::get('/poin', [\App\Http\Controllers\OrangTua\PoinController::class, 'index'])->name('poin.index');
    Route::get('/tagihan', [\App\Http\Controllers\OrangTua\TagihanController::class, 'index'])->name('tagihan.index');
});

/**
 * Siswa Panel Routes (Protected)
 */
Route::middleware(['auth', 'verified', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/raport', [\App\Http\Controllers\Siswa\RaportController::class, 'index'])->name('raport.index');
    Route::get('/raport/pdf', [\App\Http\Controllers\Siswa\RaportController::class, 'pdf'])->name('raport.pdf');
});

require __DIR__.'/auth.php';
