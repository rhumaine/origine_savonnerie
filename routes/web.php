<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitsController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderSummaryController;
use App\Http\Controllers\AdminController;

use App\Http\Middleware\AdminMiddleware;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/a-propos', function () {
    return view('a-propos');
})->name('a-propos');

//CONTACT
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
//FIN CONTACT

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

// PRODUITS
Route::get('/produits/{id}', [ProduitsController::class, 'show']);
Route::get('/panier', [PanierController::class, 'show'])->name('panier.show');
Route::post('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');
Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');


Route::get('/commande/{id}', [OrderSummaryController::class, 'commandeShow'])->middleware('auth')->name('commandes.show');

Route::get('/checkout/summary', [OrderSummaryController::class, 'show'])->name('recap.show');
Route::get('/checkout/paypal/payment', [OrderSummaryController::class, 'createPayPalPayment'])->name('paypal.payment');
//Route::get('/checkout/paypal/execute', [OrderSummaryController::class, 'executePayPalPayment'])->name('paypal.execute');
Route::get('/checkout/paypal/success', [OrderSummaryController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('/checkout/paypal/cancel', [OrderSummaryController::class, 'paymentCancel'])->name('paypal.payment.cancel');
// FIN PRODUITS



Route::get('/dashboard', [ProfileController::class, 'dashboard'])->middleware('auth', 'verified')->name('dashboard');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth', 'admin')->name('admin.dashboard');
Route::post('/admin/commande/update-status/{commande}', [AdminController::class, 'updateStatus'])->middleware('auth', 'admin')->name('update.status');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
