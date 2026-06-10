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

Route::get('/ppdb', function () {
    return view('client.ppdb');
});

Route::get('/virtual-tour', function () {
    return view('client.virtual-tour');
});

/**
 * Admin Panel Routes (Protected)
 */
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('berita', \App\Http\Controllers\Admin\ArticleController::class)->names('admin.articles');

    
    // Auth Profile (Scaffolded by Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
