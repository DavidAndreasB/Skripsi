<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController; 
// Tambah controller lain
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\JobSheetController;
use App\Http\Controllers\PengaturanController;

use Illuminate\Support\Facades\Auth;

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

    
Route::resource('spk', \App\Http\Controllers\SPKController::class);


});


require __DIR__.'/auth.php';

