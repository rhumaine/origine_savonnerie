<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// FOOTER
Route::get('/conditions', function () {
    return view('conditions');
})->name('conditions');

Route::get('/mentions', function () {
    return view('mentions');
})->name('mentions');

Route::get('/confidentialite', function () {
    return view('confidentialite');
})->name('confidentialite');

// FIN FOOTER


Route::get('/panier', function () {
    return view('panier');
})->name('panier');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
