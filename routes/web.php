<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\SpkController;         // S BESAR
use App\Http\Controllers\JobSheetController;    // J S BESAR

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

    // --- SPK ---
    Route::resource('spk', SpkController::class);

    // --- JOBSHEET ROUTES ---
    Route::get('/jobsheet', [JobSheetController::class, 'index'])->name('jobsheet.index');
    Route::get('/jobsheet/{spk_id}', [JobSheetController::class, 'show'])->name('jobsheet.show');
    Route::post('/jobsheet', [JobSheetController::class, 'store'])->name('jobsheet.store');
    
    // PERHATIKAN BAGIAN '/{id}' DI BAWAH INI. JANGAN SAMPAI HILANG!
    Route::delete('/jobsheet/{id}', [JobSheetController::class, 'destroy'])->name('jobsheet.destroy');

    // --- ADMIN ---
    Route::middleware(['admin'])->group(function () {
        Route::get('/register', [UserController::class, 'create'])->name('register'); 
        Route::post('/register', [UserController::class, 'store'])->name('register.store');
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
    });
});

require __DIR__.'/auth.php';