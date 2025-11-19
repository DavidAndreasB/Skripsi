<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController; 
// Tambah controller lain
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\JobSheetController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\spkController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'admin'])->prefix('user')->name('user.')->group(function () {
    // URL yang benar untuk membuat akun baru
    Route::get('/create', [UserController::class, 'create'])->name('create'); 
    Route::post('/', [UserController::class, 'store'])->name('store'); 
    Route::get('/', [UserController::class, 'index'])->name('index'); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   Route::get('/jobsheet', [JobSheetController::class, 'index'])->name('jobsheet.index');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

    Route::get('/spk', [spkController::class, 'index'])->name('spk.index');
    Route::get('/spk/create', [spkController::class, 'create'])->name('spk.create');
    Route::post('/spk', [spkController::class, 'store'])->name('spk.store');
    
    // Rute untuk melihat Detail SPK
    Route::get('/spk/{spk}', [spkController::class, 'show'])->name('spk.show');
    
    Route::get('/spk/{spk}/edit', [spkController::class, 'edit'])->name('spk.edit');
    Route::put('/spk/{spk}', [spkController::class, 'update'])->name('spk.update');
    Route::delete('/spk/{spk}', [spkController::class, 'destroy'])->name('spk.destroy');

Route::resource('spk', \App\Http\Controllers\SPKController::class);
        // --- AREA SUPER ADMIN ---
        // Rute ini dilindungi oleh middleware 'admin'
        Route::middleware(['admin'])->group(function () {
            
            // Menggunakan URL '/register' tapi diarahkan ke logika UserController Admin
            Route::get('/register', [UserController::class, 'create'])->name('register'); 
            Route::post('/register', [UserController::class, 'store'])->name('register.store');
            
            // Rute manajemen user lainnya
            Route::get('/user', [UserController::class, 'index'])->name('user.index');
            
        });
});


require __DIR__.'/auth.php';

