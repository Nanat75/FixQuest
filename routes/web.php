<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotaController;


// Landing page (halaman awal dengan pilihan Login & Register)
Route::get('/', function () {
    return view('auth.landing');
})->name('landing');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Dashboard dan Profile - setelah login
Route::middleware('auth')->group(function () {
   Route::get('/teknisi/dashboard', [NotaController::class, 'teknisiIndex'])->name('teknisi.dashboard');
Route::get('/admin/dashboard', [NotaController::class, 'adminIndex'])->name('admin.dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');
Route::post('/notas', [NotaController::class, 'store'])->name('notas.store');
Route::get('/notas/export', [NotaController::class, 'export'])->name('notas.export');
Route::put('/notas/{nota}', [NotaController::class, 'update'])->name('notas.update');
Route::get('/notas/export/bulan', [NotaController::class, 'exportByMonth'])->name('notas.exportByMonth');
Route::get('/notas/print', [NotaController::class, 'printAll'])->name('notas.print');
Route::get('/notas/print/overlay/{no}', [NotaController::class, 'printOverlay'])->name('notas.print.overlay');
Route::get('/nota/print-list', [NotaController::class, 'printListByMonth'])->name('nota.printListByMonth');




