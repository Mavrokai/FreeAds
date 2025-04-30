<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;
use App\Livewire\Annonces\ListeAnnonces;
use App\Livewire\Annonces\FormulaireAnnonce;


Route::get('/', function () {
    return view('index');
})->name('index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
Route::get('/annonces/create', [AnnonceController::class, 'create'])->middleware('auth')->name('annonces.create');
Route::post('/annonces', [AnnonceController::class, 'store'])->middleware('auth')->name('annonces.store');
Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');
Route::get('/annonces/{annonce}/edit', [AnnonceController::class, 'edit'])->middleware('auth')->name('annonces.edit');
Route::put('/annonces/{annonce}', [AnnonceController::class, 'update'])->middleware('auth')->name('annonces.update');
Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->middleware('auth')->name('annonces.destroy');


Route::get('/liste-annonces', ListeAnnonces::class)->name('livewire.annonces.liste');
Route::get('/annonce/creer', FormulaireAnnonce::class)->middleware('auth')->name('livewire.annonces.create');
Route::get('/annonce/{annonce}/modifier', FormulaireAnnonce::class)->middleware('auth')->name('livewire.annonces.edit');


Route::middleware(['auth'])->group(function () {
    Route::post('/photos/{photo}/main', [App\Http\Controllers\PhotoController::class, 'setMain'])->name('photos.main');
    Route::delete('/photos/{photo}', [App\Http\Controllers\PhotoController::class, 'destroy'])->name('photos.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
